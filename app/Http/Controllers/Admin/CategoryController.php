<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
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
        Category::create([
            "name" => $request->name,
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
        $category->update([
            "name" => $request->name,
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
            $category->update([
                "name" => $category->name . ' ' . time(),
            ]);

            $category->delete();
        });

        return back()->with("swal-success", "دسته بندی مورد نظر با موفقیت حذف شد");
    }
}
