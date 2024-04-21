<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;

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
    public function store(StoreRequest $request)
    {
        $image_path = null;

        if ($request->hasFile("image_path")) {
            $image = $request->file("image_path");
            $imageName = time() . '.' . $image->extension();
            $imagePath = public_path($this->path . $imageName);
            Image::make($image->getRealPath())->save($imagePath);
            $image_path = $this->path . $imageName;
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
    public function update(UpdateRequest $request, Category $category)
    {
        $image_path = $category->image_path;

        if ($request->hasFile("image_path")) {
            if (File::exists(public_path($category->image_path))) {
                File::delete(public_path($category->image_path));
            }

            $image = $request->file("image_path");
            $imageName = time() . '.' . $image->extension();
            $imagePath = public_path($this->path . $imageName);
            Image::make($image->getRealPath())->save($imagePath);
            $image_path = $this->path . $imageName;
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
    public function destroy(Category $category)
    {
        DB::transaction(function () use ($category) {
            $image_path = $category->image_path;

            $category->update([
                "name" => $category->name . ' ' . time(),
            ]);

            $category->delete();

            if (File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
        });

        return back()->with("swal-success", "دسته بندی مورد نظر با موفقیت حذف شد");
    }
}
