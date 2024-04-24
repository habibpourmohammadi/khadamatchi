<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        // Retrieve active cities
        $cities = City::where("status", "active")->get();
        // Retrieve categories with images
        $categoriesHasImage = Category::where("status", "active")->where("image_path", "!=", null)->get();
        // Retrieve all active categories
        $categories = Category::where("status", "active")->get();

        // Pass the retrieved data to the view
        return view("home.index", compact("cities", "categories", "categoriesHasImage"));
    }

    /**
     * Display the contact us page.
     */
    public function contactUsPage()
    {
        return view("home.contact-us");
    }
}
