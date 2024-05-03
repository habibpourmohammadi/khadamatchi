<?php

namespace App\Http\Controllers\Home;

use App\Models\City;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use GuzzleHttp\RetryMiddleware;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Notifications\ResetPasswordNotification;
use App\Http\Requests\Auth\ForgotPasswordRequest;

class AuthController extends Controller
{
    /**
     * Display the login page.
     */
    public function loginPage()
    {
        return view("auth.login");
    }

    /**
     * Handle login requests.
     */
    public function login(LoginRequest $request)
    {
        // Retrieve the login credentials from the request
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Check if the authenticated user is an admin
            if (Auth::user()->isAdmin()) {
                // Regenerate the session
                $request->session()->regenerate();
                // Redirect to the admin dashboard with success message
                return to_route("admin.index")->with("swal-success", "شما با موفقیت وارد پنل ادمین شدید");
            } else {
                // Regenerate the session
                $request->session()->regenerate();
                // Prepare the welcome message
                $message = Auth::user()->full_name . " " . "عزیز به وبسایت خدمات چی خوش آمدید";
                // Redirect to the user dashboard with success message
                return to_route("home.index")->with("swal-success", $message);
            }
        } else {
            // If authentication fails, redirect back with input and error message
            return back()->withInput()->withErrors(['password' => 'اطلاعات وارد شده صحیح نمی باشد']);
        }
    }

    /**
     * Display the registration page.
     */
    public function registerPage()
    {
        // Retrieve active cities
        $cities = City::where("status", "active")->get();
        // Return the registration view with cities
        return view("auth.register", compact("cities"));
    }

    /**
     * Process the registration request.
     */
    public function register(RegisterRequest $request)
    {
        // Find the city based on the provided slug
        $city = City::where("slug", $request->city)->where("status", "active")->first();

        // If the city is not found, return with error message
        if (!isset($city)) {
            return back()->withInput()->withErrors(['city' => 'شهر انتخاب شده صحیح نمی باشد']);
        }

        // Create a new user with the provided information
        User::create([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "mobile" => $request->mobile,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "city_id" => $city->id,
            "province_id" => $city->province_id,
            "gender" => "none",
        ]);

        // Redirect to the login page with a success message
        return to_route("home.login.page")->with("swal-success", "حساب کاربری شما ایجاد شد، وارد حساب کاربری خود شوید");
    }

    /**
     * Handle logout requests.
     */
    public function logout()
    {
        // Logout the user
        Auth::logout();

        // Redirect to the login page
        return to_route("home.login.page");
    }

    /**
     * Display the forgot password page.
     */
    public function forgotPasswordPage()
    {
        return view("auth.forgot-password");
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        // Find user by email
        $user = User::where("email", $request->email)->first();

        // If user not found, simulate delay and return success message
        if (!$user) {
            sleep(3); // Simulate delay for security purposes

            return back()->with("swal-success", "ایمیل بازنشانی کلمه عبور با موفقیت ارسال شد !");
        }

        try {
            // Send password reset link and notify user
            $response = Password::sendResetLink(
                ["email" => $user->email],
                function ($user, $token) {
                    $user->notify(new ResetPasswordNotification($token, $user->email));
                }
            );
        } catch (\Throwable $th) {
            // Handle exception and return error message
            return back()->with("swal-error", "لطفا مجدد تلاش کنید !");
        }

        // Check response from password reset link sending
        if ($response != Password::RESET_LINK_SENT) {
            // If response indicates failure, return with input and error messages
            return back()->withInput()->withErrors(['email' => __($response)]);
        } else {
            // If successful, return with success message
            return back()->with("swal-success", "ایمیل بازنشانی کلمه عبور با موفقیت ارسال شد !");
        }
    }

    /**
     * Display the reset password page.
     */
    public function resetPasswordPage($token)
    {
        return view("auth.reset-password", compact("token"));
    }

    /**
     * Reset the user's password.
     */
    public function resetPassword(ResetPasswordRequest $request, $token)
    {
        // Attempt to reset the password using the provided token and user credentials
        $response = Password::reset(
            [
                "email" => $request->email,
                "password" => $request->password,
                "password_confirmation" => $request->password,
                "token" => $token,
            ],
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // Check the response from the password reset attempt
        if ($response != Password::PASSWORD_RESET) {
            // If reset fails, return back with input and error messages
            return back()->withInput()->withErrors(['email' => __($response)]);
        } else {
            // If reset is successful, redirect to login page with success message
            return to_route("home.login.page")->with("swal-success", "کلمه عبور شما با موفقیت ویرایش شد !");
        }
    }
}
