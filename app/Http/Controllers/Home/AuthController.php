<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

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
     * Handle logout requests.
     */
    public function logout()
    {
        // Logout the user
        Auth::logout();

        // Redirect to the login page
        return to_route("home.login.page");
    }
}
