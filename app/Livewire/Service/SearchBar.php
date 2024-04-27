<?php

namespace App\Livewire\Service;

use App\Models\City;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;

class SearchBar extends Component
{
    // Define validation rules and attributes for search, category, and city inputs

    #[Validate("nullable|string|max:150", "جستجو")]
    #[Url()]
    public $search;

    #[Validate("nullable|exists:categories,slug", "دسته بندی")]
    #[Url()]
    public $category;

    #[Validate("nullable|exists:cities,slug", "شهر")]
    #[Url()]
    public $city;

    // The mount method is called when the Livewire component is initialized
    public function mount()
    {
        // Initialize the component with the current filter values
        $this->getFilter();
    }

    // Retrieve and set the filter values from the component
    public function getFilter()
    {
        // Validate the input values based on defined rules
        $this->validate();

        // Dispatch an event to set the filter with search, category, and city values
        $this->dispatch("set-filter", $this->search, $this->category, $this->city);
    }

    // Render the Livewire component with specific data
    public function render()
    {
        return view(
            'livewire.service.search-bar',
            [
                "categories" => Category::where("status", "active")->select("name", "slug")->get(),
                "cities" => City::where("status", "active")->select("name", "slug")->get(),
            ]
        );
    }
}
