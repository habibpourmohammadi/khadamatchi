<?php

namespace App\Livewire\MyProfile;

use App\Models\City;
use App\Models\Service;
use Livewire\Component;
use App\Models\Category;
use App\Models\Province;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class MyServices extends Component
{
    use WithFileUploads;

    // Directory path for storing service images
    private $image_path = 'images' . DIRECTORY_SEPARATOR . "services" . DIRECTORY_SEPARATOR;

    // Public properties for holding province, city, and category data
    public $provinces;
    public $cities;
    public $categories;

    // Property for storing the service being edited
    public $editService = null;

    // Input properties with validation rules for service editing form

    #[Validate("required|max:150", "عنوان تخصص")]
    public $editTitle;

    #[Validate("required|exists:provinces,slug", "استان")]
    public $editProvince;

    #[Validate("required|exists:cities,slug", "شهر")]
    public $editCity;

    #[Validate("required|exists:categories,slug", "دسته بندی")]
    public $editCategory;

    #[Validate("nullable|image|mimes:png,jpg,jpeg|max:1024", "عکس سرویس")]
    public $editServiceImage;

    #[Validate("required|in:year,month", "واحد مدت تجربه کاری")]
    public $editWorkExperienceUnit;

    #[Validate("required|digits_between:1,40", "مدت تجربه کاری")]
    public $editWorkExperienceDuration;

    #[Validate("required|min:5", "توضیحات تخصص")]
    public $editDescription;

    /**
     * Initializes the component by loading provinces and categories data.
     */
    public function mount()
    {
        $this->cities = [];
        $this->provinces = Province::where("status", "active")->get();
        $this->categories = Category::where("status", "active")->get();
    }

    /**
     * Handles the update of an existing service.
     */
    public function updateService()
    {
        // Validate input data
        $this->validate();

        // Ensure user is authorized to edit the service
        if ($this->serviceAuthentication($this->editService->id)) {
            // Handle service image upload and update service data
            if ($this->editServiceImage) {
                // Delete existing service image if it exists
                if ($this->editService->service_image_path != null && File::exists(public_path($this->editService->service_image_path))) {
                    File::delete(public_path($this->editService->service_image_path));
                }

                //  Upload new service image
                $image = $this->editServiceImage;
                $imageName = time() . '.' . $image->extension();
                $imagePath = public_path($this->image_path . $imageName);
                Image::make($image->getRealPath())->save($imagePath);
                $this->editServiceImage = $this->image_path . $imageName;
            } else {
                $this->editServiceImage = $this->editService->service_image_path;
            }

            // Retrieve and validate category, province, and city data
            $category = Category::where("slug", $this->editCategory)->where("status", "active")->first();
            $province = Province::where("slug", $this->editProvince)->where("status", "active")->first();
            $city = City::where("slug", $this->editCity)->where("status", "active")->first();

            // Validate category, province, and city relationship
            if (
                !isset($category) ||
                !isset($province) ||
                !isset($city) ||
                $province->id != $city->province_id
            ) {
                $this->dispatch("close-modal");
                return back()->with("error-alert", "لطفا دوباره تلاش کنید");
            } else {
                // Update the service with validated data
                $this->editService->update([
                    "category_id" => $category->id,
                    "province_id" => $province->id,
                    "city_id" => $city->id,
                    "title" => $this->editTitle,
                    "service_image_path" => $this->editServiceImage,
                    "description" => $this->editDescription,
                    "work_experience_duration" => $this->editWorkExperienceDuration,
                    "work_experience_unit" => $this->editWorkExperienceUnit,
                ]);

                // Close the modal and provide success feedback
                $this->dispatch("close-modal");
                return back()->with("success-alert", "سرویس مورد نظر با موفقیت ویرایش شد");
            }
        } else {
            return back()->with("error-alert", "لطفا دوباره تلاش کنید");
        }
    }

    /**
     * Sets the city options based on the selected province.
     */
    public function setCity()
    {
        $this->validateOnly("editProvince");
        $province = Province::where("slug", $this->editProvince)->first();

        // Retrieve and set cities for the selected province
        $this->cities = City::where("province_id", $province->id)->where("status", "active")->get();
        $this->reset("editCity");
    }

    /**
     * Sets the edit values for a selected service.
     */
    public function setEditValue($serviceId)
    {
        // Ensure user is authorized to edit the service
        if ($this->serviceAuthentication($serviceId)) {
            // Retrieve the service data and pre-fill the edit form
            $this->editService = Service::find($serviceId);
            $this->fill([
                "editTitle" => $this->editService->title,
                "cities" => $this->editService->province->cities()->where("status", "active")->get(),
                "editProvince" => $this->editService->province->slug,
                "editCategory" => $this->editService->category->slug,
                "editWorkExperienceUnit" => $this->editService->work_experience_unit,
                "editWorkExperienceDuration" => $this->editService->work_experience_duration,
                "editDescription" => $this->editService->description,
            ]);
            $this->dispatch("open-modal");
        } else {
            return back()->with("error-alert", "لطفا دوباره تلاش کنید");
        }
    }

    /**
     * Deletes a specified service.
     */
    public function delete($serviceId)
    {
        // Ensure user is authorized to delete the service
        if ($this->serviceAuthentication($serviceId)) {
            // Delete the service
            Service::find($serviceId)->delete();
            return back()->with("success-alert", "سرویس شما با موفقیت حذف شد.");
        } else {
            return back()->with("error-alert", "لطفا دوباره تلاش کنید");
        }
    }

    /**
     * Validates whether the current user is authorized to manage the specified service.
     */
    private function serviceAuthentication($serviceId)
    {
        try {
            $service = Service::find($serviceId);

            // Check if the authenticated user is the owner of the service
            if ($service->user_id != Auth::user()->id) {
                return false;
            }

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Retrieves the list of services owned by the authenticated user.
     */
    #[Computed()]
    public function services()
    {
        return Auth::user()->services()->with("user", "category", "city", "province")->get();
    }
}
