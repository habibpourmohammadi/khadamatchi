<?php

namespace App\Livewire\MyProfile;

use App\Models\City;
use App\Models\Service;
use Livewire\Component;
use App\Models\Category;
use App\Models\Province;
use App\Models\ServiceImage;
use App\Models\Tag;
use App\Services\Image\ImageService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
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

    /**
     * All available tags.
     */
    public $tags;

    /**
     * The tags that were previously associated with the service.
     */
    public $selectedTags = [];

    /**
     * The final selected tags that should be saved to the database.
     */
    public $finalSelectedTags = [];

    /**
     * images related to the service
     */
    public $images;

    /**
     *
     */
    #[Validate("required|image|mimes:png,jpg,jpeg|max:1024")]
    public $image;

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
     * Initializes the component by loading provinces and categories and tags data.
     */
    public function mount()
    {
        $this->cities = [];
        $this->provinces = Province::where("status", "active")->get();
        $this->categories = Category::where("status", "active")->get();
        $this->tags = Tag::where("status", "active")->get();
    }

    /**
     * Handles the update of an existing service.
     */
    public function updateService(ImageService $imageService)
    {
        // Validate the incoming request data
        $this->validate([
            'editTitle' => ["required", "max:150"],
            'editProvince' => ["required", "exists:provinces,slug"],
            'editCity' => ["required", "exists:cities,slug"],
            'editCategory' => ["required", "exists:categories,slug"],
            'editServiceImage' => ["nullable", "image", "mimes:png,jpg,jpeg", "max:1024"],
            'editWorkExperienceUnit' => ["required", "in:year,month"],
            'editWorkExperienceDuration' => ["required", "digits_between:1,40"],
            'editDescription' => ["required", "min:5"],
        ], [], [
            // Custom attribute names for validation error messages
            "editTitle" => "عنوان تخصص",
            "editProvince" => "استان",
            "editCity" => "شهر",
            "editCategory" => "دسته بندی",
            "editServiceImage" => "عکس سرویس",
            "editWorkExperienceUnit" => "واحد مدت تجربه کاری",
            "editWorkExperienceDuration" => "مدت تجربه کاری",
            "editDescription" => "توضیحات تخصص",
        ]);

        // Ensure user is authorized to edit the service
        if ($this->serviceAuthentication($this->editService->id)) {
            // Handle service image upload and update service data
            if ($this->editServiceImage) {
                // Check if the uploaded file is not a PNG, JPEG, or JPG image
                // OR if the file size exceeds 1 MB.
                if (!in_array($this->editServiceImage->extension(), ["png", "jpeg", "jpg"]) || $this->editServiceImage->getSize() > 1024000) {
                    // Close the modal and display an error message.
                    $this->dispatch("close-modal");
                    return back()->with("error-alert", "لطفا دوباره تلاش کنید");
                }

                // Delete the existing service image from storage using ImageService
                $imageService->deleteFromStorage($this->editService->service_image_path);

                // Retrieve the service image from the editServiceImage property
                $image = $this->editServiceImage;

                // Save the retrieved service image using ImageService with custom resizing options (556x556 with aspect ratio)
                $image = $imageService->save($image, $this->image_path, null, null, [556, 556, true]);

                // Update the editServiceImage property with the newly saved image path
                $this->editServiceImage = $image;
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

                // Resetting form input fields and closing modal after successfully editing a service
                $this->reset("editTitle", "editCategory", "editProvince", "editCity", "editServiceImage", "editWorkExperienceUnit", "editWorkExperienceDuration", "editDescription");

                $this->dispatch("close-modal");

                return back()->with("success-alert", "سرویس مورد نظر با موفقیت ویرایش شد");
            }
        } else {
            $this->dispatch("close-modal");
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
            $this->reset("editTitle", "cities", "editProvince", "editCategory", "editWorkExperienceUnit", "editWorkExperienceDuration", "editDescription", "editCity");
            $this->fill([
                "editTitle" => $this->editService->title,
                "cities" => $this->editService->province->cities()->where("status", "active")->get(),
                "editCity" => $this->editService->city->slug,
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
     * This method is used to set tags for a specific service
     */
    public function setTags($serviceId)
    {
        // Check if the user is authorized to edit the service
        if ($this->serviceAuthentication($serviceId)) {
            // Reset the finalSelectedTags array to prepare for new selections
            $this->reset("finalSelectedTags");
            // Find the service by ID
            $this->editService = Service::find($serviceId);
            // Retrieve the selected tags associated with the service and store them in the selectedTags array
            $this->selectedTags = $this->editService->tags()->where("status", "active")->select('name', "slug")->get()->toArray();
            // Open the tag modal for tag selection
            $this->dispatch("open-tag-modal");
        } else {
            // If the user is not authorized, redirect back with an error message
            return back()->with("error-alert", "لطفا دوباره تلاش کنید");
        }
    }

    public function updateTags()
    {
        // Check if the authenticated user has permission to update the tags for the service
        if ($this->serviceAuthentication($this->editService->id)) {
            $tagIds = [];

            // Retrieve the tag IDs based on the final selected tags
            foreach ($this->finalSelectedTags as $tag) {
                // Find the tag ID by slug and ensure it's active
                $tagId = Tag::where("slug", $tag)->where("status", "active")->first()->id ?? null;

                // If a tag ID is found, add it to the array
                if ($tagId) {
                    $tagIds[] = $tagId;
                }
            }

            // Check if any tag ID is null (indicating invalid tags)
            if (in_array(null, $tagIds)) {
                // Reset the finalSelectedTags and close the tag modal
                $this->dispatch("close-tag-modal");
                $this->reset("finalSelectedTags");

                // Return back with an error message
                return back()->with("error-alert", "لطفا دوباره تلاش کنید");
            } else {
                // Sync the tag IDs with the service's tags
                $this->editService->tags()->sync($tagIds);

                // Reset finalSelectedTags and close the tag modal
                $this->dispatch("close-tag-modal");
                $this->reset("finalSelectedTags");

                // Return back with a success message
                return back()->with("success-alert", "تگ های سرویس مورد نظر با موفقیت ویرایش شدند");
            }
        } else {
            // If the user doesn't have permission, return back with an error message
            return back()->with("error-alert", "لطفا دوباره تلاش کنید");
        }
    }

    /**
     * Set and prepare images for a specified service.
     */
    public function setImages($serviceId)
    {
        // Check service authentication
        if ($this->serviceAuthentication($serviceId)) {
            // Reset images and image properties
            $this->reset("images", "image");
            // Retrieve service for editing
            $this->editService = Service::find($serviceId);
            // Retrieve active images associated with the service
            $this->images = $this->editService->images()->where("status", "active")->get();
            // Set images to null if no active images found
            if ($this->images->count() <= 0) {
                $this->images = null;
            }

            // Dispatch event to open images modal
            $this->dispatch("open-images-modal");
        } else {
            // If service authentication fails, return with error alert
            return back()->with("error-alert", "لطفا دوباره تلاش کنید");
        }
    }

    /**
     * store a new image for the current service.
     */
    public function addImage(ImageService $imageService)
    {
        // Validate only the "image" input field
        $this->validateOnly("image");

        // Check service authentication
        if ($this->serviceAuthentication($this->editService->id)) {
            // Check if an image file was uploaded
            if ($this->image) {
                // Retrieve the uploaded image from the $this->image property
                $image = $this->image;

                // Get the size of the image
                $imageSize = $image->getSize();

                // Get the format of the image
                $imageType = $image->extension();

                // Save the image using ImageService and update the $image variable with the new image path
                $image = $imageService->save($image, $this->image_path);

                // Update the $this->image property with the new image path
                $this->image = $image;
            } else {
                // Close images modal and return with error alert if no image was selected
                $this->dispatch("close-images-modal");
                return back()->with("error-alert", "لطفا دوباره تلاش کنید");
            }

            // Create a new record for the uploaded image in the database
            ServiceImage::create([
                "service_id" => $this->editService->id,
                "image_path" => $this->image,
                "image_size" => $imageSize,
                "image_type" => $imageType,
            ]);

            // Reset the "image" property after successful upload
            $this->reset("image");

            // Return back with success message
            return back()->with("upload-success", "عکس جدید شما با موفقیت ثبت شد و بعد از تایید ادمین نمایش داده میشود");
        } else {
            // Close images modal and return with error alert if authentication fails
            $this->dispatch("close-images-modal");
            return back()->with("error-alert", "لطفا دوباره تلاش کنید");
        }
    }

    /**
     * Delete a specific image associated with a service.
     */
    public function deleteImage($imageId, ImageService $imageService)
    {
        // Find the image record by ID
        $image = ServiceImage::find($imageId);

        // Check service authentication
        if ($this->serviceAuthentication($image->service->id ?? null)) {
            // delete the image from storage
            $imageService->deleteFromStorage($image->image_path);

            // Delete the image record from the database
            $image->delete();

            // Update the images list for the edited service
            $this->images = $this->editService->images()->where("status", "active")->get();

            // Set images to null if no active images found
            if ($this->images->count() <= 0) {
                $this->images = null;
            }

            // Return back with success message after image deletion
            return back()->with("upload-success", "عکس مورد نظر با موفقیت حذف شد");
        } else {
            // Close images modal and return with error alert if authentication fails
            $this->dispatch("close-images-modal");
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
