<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
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
}
