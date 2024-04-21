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
        $cities = City::where("status", "active")->get();
        $categories = Category::where("status", "active")->get();

        return view("home.index", compact("cities", "categories"));
    }
}
