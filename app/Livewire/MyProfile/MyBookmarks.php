<?php

namespace App\Livewire\MyProfile;

use App\Models\Service;
use Livewire\Component;
use App\Models\Bookmark;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class MyBookmarks extends Component
{
    use WithPagination;

    /**
     * Retrieve paginated bookmarked services for the authenticated user.
     */
    #[On("update-services")]
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

    public function render()
    {
        return view('livewire.my-profile.my-bookmarks');
    }
}
