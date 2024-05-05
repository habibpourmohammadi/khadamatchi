<?php

namespace App\Services\Image;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Save an uploaded image with optional resizing and store in storage.
     *
     * @param UploadedFile $image The uploaded image file.
     * @param string $storagePath The storage path where the image will be saved.
     * @param string|null $imageName The desired image name (or null for auto-generated name).
     * @param string|null $format The image format (e.g., 'png', 'jpg', 'jpeg') or derived from the file extension.
     * @param array|null $resize Array containing width, height, and aspect ratio options for resizing.
     * @param bool $storeInStorage Whether to store the image in storage (default: true) or local disk.
     * @return string The path to the saved image.
     */
    public function save(
        UploadedFile $image,
        string $storagePath,
        ?string $imageName = null,
        ?string $format = null,
        ?array $resize = null,
        bool $storeInStorage = true
    ) {
        // Determine the image format based on the original file extension
        $format = $format ?: $image->getClientOriginalExtension();

        // Generate a unique image name if not provided
        $imageName = $imageName == null ? uniqid('image_') . '.' . $format : $imageName . '.' . $format;

        // Create an instance of Intervention Image from the uploaded file
        $image = Image::make($image);

        // Resize the image if resize options are provided
        if ($resize && is_array($resize) && count($resize) > 0) {
            $width = $resize[0] ?? null;
            $height = $resize[1] ?? null;
            $aspectRatio = $resize[2] ?? null;

            // Validate and apply resizing options

            if ($width != null && !is_int($width)) {
                $width = null;
            }

            if ($height != null && !is_int($height)) {
                $height = null;
            }

            if ($aspectRatio != null && !is_bool($aspectRatio)) {
                $aspectRatio = null;
            }

            // Apply resizing based on specified options
            if ($aspectRatio === true && (is_int($width) || is_int($height))) {
                $image->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } elseif (is_int($width) || is_int($height)) {
                $image->resize($width, $height);
            }
        }

        // Define the complete image path within the storage directory
        $imagePath = $storagePath . DIRECTORY_SEPARATOR . $imageName;

        // Store the image in the specified storage location
        if ($storeInStorage) {
            Storage::disk("public")->put($imagePath, (string) $image->encode($format));
            $imagePath = Storage::url($imagePath);
        } else {
            // Save the image locally to the specified path
            $image->save($imagePath);
        }

        // Return the path to the saved image
        return $imagePath;
    }

    /**
     * Delete an image from storage.
     *
     * @param string $imagePath The path to the image in storage.
     * @return bool True if image was successfully deleted, false otherwise.
     */
    public function deleteFromStorage(?string $imagePath = null)
    {
        if ($imagePath) {
            // Convert the image path format for deletion from storage
            $imagePath = str_replace('storage', 'public', $imagePath);

            // Check if the image file exists and delete it from storage
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
                return true; // Image deletion successful
            }

            return false; // Image not found or deletion failed
        } else {
            return false;
        }
    }
}
