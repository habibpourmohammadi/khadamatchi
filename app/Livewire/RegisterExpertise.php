<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\City;
use App\Models\Province;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RegisterExpertise extends Component
{
    /**
     * The title of the expertise.
     *
     * @var string
     */
    #[Validate("required|max:150", "عنوان تخصص")]
    public $title;

    /**
     * The description of the expertise.
     *
     * @var string
     */
    #[Validate("required|min:5", "توضیحات تخصص")]
    public $description;

    /**
     * The category of the expertise.
     *
     * @var string
     */
    #[Validate("required|exists:categories,slug", "دسته بندی")]
    public $category;

    /**
     * The province of the expertise.
     *
     * @var string
     */
    #[Validate("required|exists:provinces,slug", "استان")]
    public $province;

    /**
     * The city of the expertise.
     *
     * @var string
     */
    #[Validate("required|exists:cities,slug", "شهر")]
    public $city;

    /**
     * The work experience unit of the expertise.
     *
     * @var string
     */
    #[Validate("required|in:year,month", "واحد مدت تجربه کاری")]
    public $workExperienceUnit;

    /**
     * The work experience duration of the expertise.
     *
     * @var string
     */
    #[Validate("required|digits_between:1,40", "مدت تجربه کاری")]
    public $workExperienceDuration;

    /**
     * The categories available for selection.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $categories;

    /**
     * The provinces available for selection.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $provinces;

    /**
     * The cities available for selection based on the selected province.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $cities;

    /**
     * Mount the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->categories = Category::where("status", "active")->get();
        $this->provinces = Province::where("status", "active")->get();
        $this->cities = [];
    }

    /**
     * Set the available cities based on the selected province.
     *
     * @return void
     */
    public function setCity()
    {
        $this->validateOnly("province");
        $province = Province::where("slug", $this->province)->first();

        $this->cities = City::where("province_id", $province->id)->where("status", "active")->get();
    }

    /**
     * Validate the input values and register the expertise.
     *
     * @return void
     */
    public function validateValues()
    {
        // Check if the user is not authenticated, redirect to the login page
        if (!Auth::check()) {
            return to_route("home.login.page");
        }
        // Check if the user's email is not verified, redirect to the user's profile page with an error message
        elseif (Auth::user()->account_verified_at == null) {
            return to_route("home.my-profile.page")->with("swal-error", "لطفا ابتدا ایمیل خود را تایید کنید !");
        }

        $this->validate();

        if (Auth::check()) {
            $this->register();
        }
    }

    /**
     * Register the expertise.
     *
     * @return void
     */
    private function register()
    {
        // Check if the user is not authenticated, redirect to the login page
        if (!Auth::check()) {
            return to_route("home.login.page");
        }
        // Check if the user's email is not verified, redirect to the user's profile page with an error message
        elseif (Auth::user()->account_verified_at == null) {
            return to_route("home.my-profile.page")->with("swal-error", "لطفا ابتدا ایمیل خود را تایید کنید !");
        }

        $user_id = Auth::user()->id;
        $category = Category::where("slug", $this->category)->where("status", "active")->first();
        $province = Province::where("slug", $this->province)->where("status", "active")->first();
        $city = City::where("slug", $this->city)->where("status", "active")->first();
        $title = $this->title;
        $description = $this->description;
        $work_experience_duration = $this->workExperienceDuration;
        $work_experience_unit = $this->workExperienceUnit;

        if (
            !isset($user_id) ||
            !isset($category) ||
            !isset($province) ||
            !isset($city) ||
            $province->id != $city->province_id
        ) {
            session()->flash("error-alert", "مشکلی پیش آمده لطفا دوباره تلاش کنید !");
        } else {
            Service::create([
                "user_id" => $user_id,
                "category_id" => $category->id,
                "province_id" => $province->id,
                "city_id" => $city->id,
                "title" => $title,
                "description" => $description,
                "work_experience_duration" => $work_experience_duration,
                "work_experience_unit" => $work_experience_unit,
            ]);

            session()->flash("success-alert", "درخواست شما با موفقیت ثبت شد منتظر تایید پشتیبانی باشید ✔");
        }

        $this->reset("title", "description", "category", "province", "city", "workExperienceUnit", "workExperienceDuration");
    }

    public function render()
    {
        return view('livewire.register-expertise');
    }
}
