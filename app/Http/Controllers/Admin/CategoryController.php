<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Services\Image\ImageService;

class CategoryController extends Controller
{

    private $path = 'images' . DIRECTORY_SEPARATOR . "category" . DIRECTORY_SEPARATOR;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $categories = Category::query()->when($search, function ($categories) use ($search) {
            return $categories->where("name", "like", "%$search%")->orWhere("slug", "like", "%$search%")->orWhere("description", "like", "%$search%")->get();
        }, function ($categories) {
            return $categories->get();
        });

        return view("admin.category.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.category.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, ImageService $imageService)
    {
        $image_path = null;

        // Check if the request contains a file with the field name "image_path"
        if ($request->hasFile("image_path")) {
            // Retrieve the uploaded file from the request
            $image = $request->file("image_path");

            // Save the uploaded image using the $imageService and store the returned image path
            $image = $imageService->save($image, $this->path);

            // Assign the saved image path to the variable $image_path
            $image_path = $image;
        }

        Category::create([
            "name" => $request->name,
            "image_path" => $image_path,
            "description" => $request->description,
        ]);

        return to_route("admin.category.index")->with("swal-success", "دسته بندی جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view("admin.category.edit", compact("category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Category $category, ImageService $imageService)
    {
        $image_path = $category->image_path;

        // Check if the request contains a file with the field name "image_path"
        if ($request->hasFile("image_path")) {
            // Delete the previous image associated with the category from storage
            $imageService->deleteFromStorage($category->image_path);

            // Retrieve the uploaded file from the request
            $image = $request->file("image_path");

            // Save the newly uploaded image using the $imageService and store the returned image path
            $image = $imageService->save($image, $this->path);

            // Assign the saved image path to the variable $image_path
            $image_path = $image;
        }

        $category->update([
            "name" => $request->name,
            "image_path" => $image_path,
            "description" => $request->description,
        ]);

        return to_route("admin.category.index")->with("swal-success", "دسته بندی مورد نظر با موفقیت ویرایش شد");
    }

    public function changeStatus(Category $category)
    {
        if ($category->status == "active") {
            $category->update([
                "status" => "deactive"
            ]);

            return back()->with("swal-success", "وضعیت دسته بندی مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        } else {
            $category->update([
                "status" => "active"
            ]);

            return back()->with("swal-success", "وضعیت دسته بندی مورد نظر با موفقیت به (فعال) تغییر یافت");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, ImageService $imageService)
    {
        DB::transaction(function () use ($category, $imageService) {
            // Retrieve the image path associated with the category
            $image_path = $category->image_path;

            $category->update([
                "name" => $category->name . ' ' . time(),
            ]);

            $category->delete();

            // Delete the associated image from storage using the ImageService
            $imageService->deleteFromStorage($image_path);
        });

        return back()->with("swal-success", "دسته بندی مورد نظر با موفقیت حذف شد");
    }
}
