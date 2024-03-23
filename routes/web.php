<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ------------------------ Admin ------------------------
Route::prefix("admin")->group(function () {

    // Home
    Route::get("/", [HomeController::class, "index"])->name("admin.index");

    // categories
    Route::controller(CategoryController::class)->prefix("category")->group(function () {
        Route::get("/", "index")->name("admin.category.index");
        Route::get("/create", "create")->name("admin.category.create");
        Route::post("/store", "store")->name("admin.category.store");
        Route::get("/edit/{category}", "edit")->name("admin.category.edit");
        Route::put("/update/{category}", "update")->name("admin.category.update");
        Route::post("/change-status/{category}", "changeStatus")->name("admin.category.changeStatus");
        Route::delete("/delete/{category}", "destroy")->name("admin.category.delete");
    });
});
