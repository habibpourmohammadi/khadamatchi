<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Home\AuthController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Home\MyProfileController;
use App\Http\Controllers\Admin\Service\ImageController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Home\HomeController as HomeHomeController;
use App\Http\Controllers\Admin\Service\CommentController as ServiceCommentController;
use App\Http\Controllers\Home\ServiceController as HomeServiceController;

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

// ------------------------ Home ------------------------
Route::get("/", [HomeHomeController::class, "index"])->name("home.index");


// Auth
Route::get("login", [AuthController::class, "loginPage"])->name("home.login.page")->middleware("guest");
Route::post("login", [AuthController::class, "login"])->name("home.login")->middleware("guest");
Route::get("register", [AuthController::class, "registerPage"])->name("home.register.page")->middleware("guest");
Route::post("register", [AuthController::class, "register"])->name("home.register")->middleware("guest");
Route::post("logout", [AuthController::class, "logout"])->name("home.logout")->middleware("auth");
Route::get("logout", [AuthController::class, "logout"])->middleware("auth");

// my profile
Route::middleware("auth")->controller(MyProfileController::class)->prefix("my-profile")->group(function () {
    Route::get("/", "myProfilePage")->name("home.my-profile.page");
    Route::post("/", "myProfileUpdate")->name("home.my-profile.update");
    Route::post("/send-verify-token", "sendVerifyToken")->name("home.my-profile.send-verify-token");
    Route::get("/verify-email/{user:token}", "verifyEmail")->name("home.my-profile.verify-email");
    Route::get("/my-services", "myServicesPage")->name("home.my-services.page");
});

// contact us
Route::get("/contact-us", [HomeHomeController::class, "contactUsPage"])->name("home.contact-us.page")->middleware("auth");

// frequently asked questions (FAQ)
Route::get("/faq", [HomeHomeController::class, "faqPage"])->name("home.faqPage.page");

// service
Route::controller(HomeServiceController::class)->prefix("services")->group(function () {
    Route::get("/", "index")->name("home.services.index");
});

// ------------------------ Admin ------------------------
Route::middleware(["admin", "auth"])->prefix("admin")->group(function () {

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

    // provinces
    Route::controller(ProvinceController::class)->prefix("province")->group(function () {
        Route::get("/", "index")->name("admin.province.index");
        Route::get("/create", "create")->name("admin.province.create");
        Route::post("/store", "store")->name("admin.province.store");
        Route::get("/edit/{province}", "edit")->name("admin.province.edit");
        Route::put("/update/{province}", "update")->name("admin.province.update");
        Route::post("/change-status/{province}", "changeStatus")->name("admin.province.changeStatus");
        Route::delete("/delete/{province}", "destroy")->name("admin.province.delete");
    });

    // cities
    Route::controller(CityController::class)->prefix("city")->group(function () {
        Route::get("/", "index")->name("admin.city.index");
        Route::get("/create", "create")->name("admin.city.create");
        Route::post("/store", "store")->name("admin.city.store");
        Route::get("/edit/{city}", "edit")->name("admin.city.edit");
        Route::put("/update/{city}", "update")->name("admin.city.update");
        Route::post("/change-status/{city}", "changeStatus")->name("admin.city.changeStatus");
        Route::delete("/delete/{city}", "destroy")->name("admin.city.delete");
    });

    // tags
    Route::controller(TagController::class)->prefix("tag")->group(function () {
        Route::get("/", "index")->name("admin.tag.index");
        Route::get("/create", "create")->name("admin.tag.create");
        Route::post("/store", "store")->name("admin.tag.store");
        Route::get("/edit/{tag}", "edit")->name("admin.tag.edit");
        Route::put("/update/{tag}", "update")->name("admin.tag.update");
        Route::post("/change-status/{tag}", "changeStatus")->name("admin.tag.changeStatus");
        Route::delete("/delete/{tag}", "destroy")->name("admin.tag.delete");
    });

    // services
    Route::controller(ServiceController::class)->prefix("service")->group(function () {
        Route::get("/", "index")->name("admin.service.index");
        Route::get("/show/{service}", "show")->name("admin.service.show");
        Route::post("/change-status/{service}", "changeStatus")->name("admin.service.changeStatus");
        Route::delete("/delete/{service}", "destroy")->name("admin.service.delete");
        Route::get("/tags/{service}", "tags")->name("admin.service.tags");

        // comments
        Route::controller(ServiceCommentController::class)->prefix("comment")->group(function () {
            Route::get("/{service}", "index")->name("admin.service.comment.index");
            Route::get("/show/{service}/{comment}", "show")->name("admin.service.comment.show")->scopeBindings();
            Route::post("/change-status/{service}/{comment}", "changeStatus")->name("admin.service.comment.changeStatus")->scopeBindings();
            Route::delete("/delete/{service}/{comment}", "destroy")->name("admin.service.comment.delete")->scopeBindings();
        });

        // images
        Route::controller(ImageController::class)->prefix("image")->group(function () {
            Route::get("/{service}", "index")->name("admin.service.image.index");
            Route::post("/change-status/{service}/{image}", "changeStatus")->name("admin.service.image.changeStatus")->scopeBindings();
            Route::delete("/delete/{service}/{image}", "destroy")->name("admin.service.image.delete")->scopeBindings();
        });
    });

    // users
    Route::controller(UserController::class)->prefix("user")->group(function () {
        Route::get("/", "index")->name("admin.user.index");
        Route::post("/change-status/{user:slug}", "changeStatus")->name("admin.user.changeStatus");
        Route::get("/comments/{user:slug}", "comments")->name("admin.user.comments.show");
    });

    // admins
    Route::controller(AdminController::class)->prefix("admin")->group(function () {
        Route::get("/", "index")->name("admin.admin.index");
        Route::get("/create", "create")->name("admin.admin.create");
        Route::post("/store", "store")->name("admin.admin.store");
        Route::delete("/delete/{admin}/{user}", "destroy")->name("admin.admin.delete");
    });

    // faqs
    Route::controller(FaqController::class)->prefix("faq")->group(function () {
        Route::get("/", "index")->name("admin.faq.index");
        Route::get("/create", "create")->name("admin.faq.create");
        Route::post("/store", "store")->name("admin.faq.store");
        Route::get("/edit/{faq}", "edit")->name("admin.faq.edit");
        Route::put("/update/{faq}", "update")->name("admin.faq.update");
        Route::post("/change-status/{faq}", "changeStatus")->name("admin.faq.changeStatus");
        Route::delete("/delete/{faq}", "destroy")->name("admin.faq.delete");
    });

    // Contact messages
    Route::controller(ContactMessageController::class)->prefix("contact-message")->group(function () {
        Route::get("/", "index")->name("admin.contactMessage.index");
        Route::get("/{message}", "show")->name("admin.contactMessage.show");
        Route::post("/change-seen-status/{message}", "changeSeenStatus")->name("admin.contactMessage.changeSeenStatus");
        Route::delete("/delete/{message}", "destroy")->name("admin.contactMessage.delete");
    });

    // comments
    Route::controller(CommentController::class)->prefix("comment")->group(function () {
        Route::get("/", "index")->name("admin.comment.index");
        Route::get("/create", "create")->name("admin.comment.create");
        Route::post("/store", "store")->name("admin.comment.store");
        Route::get("/edit/{comment}", "edit")->name("admin.comment.edit");
        Route::put("/update/{comment}", "update")->name("admin.comment.update");
        Route::post("/change-status/{comment}", "changeStatus")->name("admin.comment.change-status");
        Route::delete("/delete/{comment}", "destroy")->name("admin.comment.delete");
    });
});
