<?php

namespace App\Livewire\Service;

use App\Models\Service;
use Livewire\Component;
use App\Models\Category;
use App\Models\City;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;

class Show extends Component
{
    use WithPagination;

    // Define validation rules for the search input
    #[Validate("nullable|string|max:150")]
    public $search;

    // Define validation rules for the category input
    #[Validate("nullable|exists:categories,slug")]
    public $category = null;

    // Default filter for category
    private $categoryFilter = "!=";

    // Define validation rules for the city input
    #[Validate("nullable|exists:cities,slug")]
    public $city = null;

    // Default filter for city
    private $cityFilter = "!=";

    // Initialize the component with filter values from the request
    public function mount()
    {
        $this->setFilter(request()->search, request()->category, request()->city);
    }

    // Handle the 'set-filter' event to update filter values
    #[On("set-filter")]
    public function setFilter($search = null, $category = null, $city = null)
    {
        $this->search = $search;
        $this->category = $category;
        $this->city = $city;

        $this->setValues();
    }

    // Set category and city values based on input and update filter conditions
    private function setValues()
    {
        $this->validate();

        // Set category ID and filter condition based on input
        $this->category = Category::where("slug", $this->category)->where("status", "active")->first()->id ?? null;
        if ($this->category == null) {
            $this->category = null;
            $this->categoryFilter = '!=';
        } else {
            $this->categoryFilter = '=';
        }

        // Set city ID and filter condition based on input
        $this->city = City::where("slug", $this->city)->where("status", "active")->first()->id ?? null;
        if ($this->city == null) {
            $this->city = null;
            $this->cityFilter = '!=';
        } else {
            $this->cityFilter = '=';
        }
    }

    // Computed property to fetch paginated services based on filters
    #[Computed()]
    public function services()
    {
        return Service::search($this->search)
            ->where("category_id", $this->categoryFilter, $this->category)
            ->where("city_id", $this->cityFilter, $this->city)
            ->where("status", "active")
            ->with("user", "category", "province", "city")
            ->paginate(6);
    }

    // Render the Livewire component view
    public function render()
    {
        return view('livewire.service.show');
    }
}
