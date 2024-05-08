<?php

namespace App\Livewire\Service;

use App\Models\Service;
use Livewire\Component;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class Item extends Component
{
    public Service $service;

    /**
     * Toggle the bookmark status for a service by the authenticated user.
     */
    public function changeBookmark()
    {
        try {
            $bookmark = Auth::user()->bookmarks()->where("service_id", $this->service->id)->first();

            if ($bookmark) {
                // Remove the bookmark if it exists
                $bookmark->delete();
            } else {
                // Create a new bookmark for the service
                Bookmark::create([
                    "user_id" => Auth::user()->id,
                    "service_id" => $this->service->id,
                ]);
            }

            $this->dispatch("update-services");
        } catch (\Throwable $th) {
            return back()->with("error-alert", "لطفا دوباره تلاش کنید !");
        }
    }

    public function render()
    {
        return view('livewire.service.item');
    }
}
