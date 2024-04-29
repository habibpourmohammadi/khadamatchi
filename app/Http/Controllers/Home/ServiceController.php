<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Service;
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

        // Render the service show view with the service data
        return view("home.service.show", compact("service"));
    }
}
