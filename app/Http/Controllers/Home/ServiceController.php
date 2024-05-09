<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Tag;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display the service index page.
     */
    public function index()
    {
        return view("home.service.index");
    }

    /**
     * Display the specified service on the show page.
     */
    public function show(Service $service)
    {
        // Check if the service is active; if not, return a 404 error
        if ($service->status != "active") {
            abort(404);
        }

        // Retrieve related active services from the same category (excluding the current service)
        $relatedServices = Service::where("category_id", $service->category_id)
            ->where("status", "active")
            ->whereNotIn('id', [$service->id])
            ->take(15)
            ->get();

        // Render the service show view with the service data and related services
        return view("home.service.show", compact("service", "relatedServices"));
    }

    /**
     * Display a page listing services associated with a specific tag.
     */
    public function tags()
    {
        return view("home.service.tags");
    }
}
