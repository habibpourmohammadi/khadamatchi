<?php

namespace App\Livewire\Service\Tags;

use Livewire\Component;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;
use App\Models\Service as ServiceModel;

class Service extends Component
{
    // Define a public property to hold the ServiceModel instance
    public ServiceModel $service;

    // Method to handle bookmarking/unbookmarking a service
    public function changeBookmark(ServiceModel $service)
    {
        // Check if the authenticated user has bookmarked the service
        $bookmark = Auth::user()->bookmarks()->where("service_id", $service->id)->first();

        if ($bookmark) {
            // If bookmark exists, delete it (unbookmark the service)
            $bookmark->delete();
        } else {
            // If bookmark doesn't exist, create a new bookmark (bookmark the service)
            Bookmark::create([
                "user_id" => Auth::user()->id,
                "service_id" => $service->id,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.service.tags.service');
    }
}
