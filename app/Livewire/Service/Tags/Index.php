<?php

namespace App\Livewire\Service\Tags;

use App\Models\Tag;
use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

class Index extends Component
{
    // Property for storing the search slug
    #[Url("search")]
    public $search = null;

    // Property for storing the search input
    public $searchInput = null;

    // Initialize the component with values based on the current request
    public function mount()
    {
        // Fill the search and searchInput properties based on the incoming request
        $this->fill([
            "search" => request()->search,
            "searchInput" => Tag::where("slug", $this->search)->first()->name ?? $this->search,
        ]);
    }

    // Method to update the search value based on the user input
    public function setSearchValue()
    {
        // Update the search property by replacing spaces with dashes in the searchInput
        $this->fill([
            "search" => str_replace(" ", "-", $this->searchInput),
        ]);
    }

    // Computed property to fetch services based on the current search
    #[Computed()]
    public function services()
    {
        // Retrieve the current search value
        $search = $this->search;

        // Query services based on the search value and other criteria
        return Service::query()
            ->when($search, function ($query) use ($search) {
                return $query->whereHas("tags", function ($query) use ($search) {
                    $query->where("slug", "like", "%{$search}%");
                });
            })
            ->where("status", "active")
            ->where("service_image_path", "!=", null)
            ->with("user", "category", "province", "city")
            ->get();
    }

    public function render()
    {
        return view('livewire.service.tags.index');
    }
}
