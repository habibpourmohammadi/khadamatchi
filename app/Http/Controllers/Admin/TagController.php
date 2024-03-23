<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tag\StoreRequest;
use App\Http\Requests\Admin\Tag\UpdateRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $tags = Tag::query()->when($search, function ($query) use ($search) {
            return $query->where("name", "like", "%$search%")->orWhere("slug", "like", "%$search%");
        })->get();

        return view("admin.tag.index", compact("tags"));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.tag.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        Tag::create([
            "name" => $request->name
        ]);

        return to_route("admin.tag.index")->with("swal-success", "تگ جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view("admin.tag.edit", compact("tag"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Tag $tag)
    {
        $tag->update([
            "name" => $request->name,
        ]);

        return to_route("admin.tag.index")->with("swal-success", "تگ مورد نظر با موفقیت ویرایش شد");
    }

    public function changeStatus(Tag $tag)
    {
        if ($tag->status == "active") {
            $tag->update([
                "status" => "deactive"
            ]);

            return back()->with("swal-success", "وضعیت تگ مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        } else {
            $tag->update([
                "status" => "active"
            ]);

            return back()->with("swal-success", "وضعیت تگ مورد نظر با موفقیت به (فعال) تغییر یافت");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        DB::transaction(function () use ($tag) {
            $tag->update([
                "name" => $tag->name . ' ' . time(),
            ]);

            $tag->delete();
        });

        return back()->with("swal-success", "تگ مورد نظر با موفقیت حذف شد");
    }
}
