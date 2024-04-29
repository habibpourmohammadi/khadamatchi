<?php

namespace App\Livewire\MyProfile;

use App\Models\Service;
use Livewire\Component;
use App\Models\Bookmark;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class MyBookmarks extends Component
{
    use WithPagination;

    /**
     * Retrieve paginated bookmarked services for the authenticated user.
     */
    #[Computed()]
    public function services()
    {
        $user = Auth::user();

        // Retrieve services that are bookmarked by the authenticated user
        $services = Service::whereHas('bookmarks', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'active')
            ->with('category', 'province', 'city')
            ->paginate(6);

        return $services;
    }

    /**
     * Toggle the bookmark status for a service by the authenticated user.
     */
    public function changeBookmark($serviceId)
    {
        try {
            $service = Service::find($serviceId);

            $bookmark = Auth::user()->bookmarks()->where("service_id", $service->id)->first();

            if ($bookmark) {
                // Remove the bookmark if it exists
                $bookmark->delete();
            } else {
                // Create a new bookmark for the service
                Bookmark::create([
                    "user_id" => Auth::user()->id,
                    "service_id" => $service->id,
                ]);
            }
        } catch (\Throwable $th) {
            return back()->with("error-alert", "لطفا دوباره تلاش کنید !");
        }
    }

    public function render()
    {
        return view('livewire.my-profile.my-bookmarks');
    }
}
