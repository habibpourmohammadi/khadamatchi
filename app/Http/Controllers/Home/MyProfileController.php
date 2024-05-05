<?php

namespace App\Http\Controllers\Home;

use App\Models\City;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Requests\Home\MyProfile\UpdateRequest;
use App\Services\Image\ImageService;

class MyProfileController extends Controller
{
    private $profile_path = 'images' . DIRECTORY_SEPARATOR . "profile" . DIRECTORY_SEPARATOR;

    /**
     * Display the user's profile page.
     */
    public function myProfilePage()
    {
        // Retrieve active cities
        $cities = City::where("status", "active")->get();

        // Return the view with cities data
        return view("home.my-profile.my-profile", compact("cities"));
    }

    /**
     * Update the user's profile information.
     */
    public function myProfileUpdate(UpdateRequest $request, ImageService $imageService)
    {
        // Validate the request and retrieve validated data
        $inputs = $request->validated();

        // Retrieve the authenticated user
        $user = Auth::user();

        // Find the city based on the provided slug
        $city = City::where("slug", $request->city)->where("status", "active")->first();

        // If the city is not found, return with error message
        if (!isset($city)) {
            return back()->withInput()->withErrors(['city' => 'شهر انتخاب شده صحیح نمی باشد']);
        }
        // If the mobile number is different from the one in the database, keep the existing one
        elseif ($user->mobile != null && $request->mobile != $user->mobile) {
            $inputs["mobile"] = $user->mobile;
        }

        // Set the profile path to the current one
        $inputs["profile_path"] = $user->profile_path;

        // If a new profile picture is uploaded, update the profile path
        if ($request->hasFile("profile_path")) {
            // Delete the existing profile image from storage using ImageService
            $imageService->deleteFromStorage($user->profile_path);

            // Retrieve the uploaded profile image file from the request
            $profile = $request->file("profile_path");

            // Save the uploaded profile image using ImageService and obtain the saved image path
            $profile = $imageService->save($profile, $this->profile_path);

            // Update the input array with the new profile image path
            $inputs["profile_path"] = $profile;
        }

        // Update the user's profile information
        $user->update([
            "first_name" => $inputs["first_name"],
            "last_name" => $inputs["last_name"],
            "profile_path" => $inputs["profile_path"],
            "mobile" => $inputs["mobile"],
            "city_id" => $city->id,
            "province_id" => $city->province->id,
            "gender" => $inputs["gender"],
        ]);

        // Redirect back with a success message
        return back()->with("swal-success", "اطلاعات حساب شما با موفقیت ویرایش شد");
    }

    /**
     * Send verification token to the user's email for account activation.
     */
    public function sendVerifyToken()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // If the user's account is already verified, return with an error message
        if (isset($user->account_verified_at)) {
            return back()->with("swal-error", "لطفا دوباره تلاش کنید !");
        }

        // Generate a random verification token
        $token = Str::random(125);;

        try {
            // Update the user's token with the generated one
            $user->update([
                "token" => $token,
            ]);

            // Create an email service instance
            $emailService = new EmailService();
            $details = [
                'title' => 'ایمیل فعال سازی حساب کاربری',
                'body' => "برای فعال سازی حساب اینجا کلیک کنید",
                'url' => route("home.my-profile.verify-email", $token),
            ];

            // Set email details
            $emailService->setDetails($details);
            $emailService->setFrom("noreplay@example.com", "khadamatchi");
            $emailService->setSubject("ایمیل فعال سازی");
            $emailService->setTo($user->email);

            // Create a message service instance and send the email
            $messageService = new MessageService($emailService);
            $messageService->send();

            return back()->with("swal-success", "ایمیل فعال سازی برای شما ارسال شد ، لیست ایمیل های ارسال شده خود را چک کنید");
        } catch (\Throwable $th) {
            return back()->with("swal-error", "لطفا دوباره تلاش کنید !");
        }
    }

    /**
     * Verify the user's email using the provided token.
     */
    public function verifyEmail(User $user)
    {
        // If the user's account is already verified, reset the token
        if (isset($user->account_verified_at)) {
            $user->update([
                "token" => null
            ]);
        }

        // Update the user's account_verified_at field to mark the email as verified and reset the token
        $user->update([
            "account_verified_at" => now(),
            "token" => null,
        ]);

        return to_route("home.my-profile.page")->with("swal-success", "ایمیل شما با موفقیت تایید شد");
    }

    /**
     * Renders the user's services page if the user has at least one service.
     * If the user has no services, it aborts with a 404 error.
     */
    public function myServicesPage()
    {
        // Check if the authenticated user has any services
        if (Auth::user()->services()->count() <= 0) {
            // If the user has no services, abort with a 404 error
            abort(404);
        }

        // Render the my-services view if the user has services
        return view("home.my-profile.my-services");
    }

    /**
     * Render the user's bookmarks page.
     */
    public function myBookmarksPage()
    {
        return view("home.my-profile.my-bookmarks");
    }
}
