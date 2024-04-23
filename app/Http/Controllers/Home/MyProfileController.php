<?php

namespace App\Http\Controllers\Home;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Home\MyProfile\UpdateRequest;

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
    public function myProfileUpdate(UpdateRequest $request)
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
            // Delete the existing profile picture file if it exists
            if (File::exists(public_path($user->profile_path)) && $user->profile_path != null) {
                File::delete(public_path($user->profile_path));
            }

            // Upload the new profile picture and update the profile path
            $profile = $request->file("profile_path");
            $profileName = time() . '.' . $profile->extension();
            $profilePath = public_path($this->profile_path . $profileName);
            Image::make($profile->getRealPath())->save($profilePath);
            $inputs["profile_path"] = $this->profile_path . $profileName;
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
}
