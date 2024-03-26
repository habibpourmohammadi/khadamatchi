<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Faq\StoreRequest;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $faqs = Faq::query()->when($search, function ($query) use ($search) {
            return $query->where("title", "like", "%$search%")->orWhere("answer", "like", "%$search%");
        })->get();

        return view("admin.faq.index", compact("faqs"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.faq.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        Faq::create([
            "title" => $request->title,
            "answer" => $request->answer,
        ]);

        return to_route("admin.faq.index")->with("swal-success", "سوال متداول جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return view("admin.faq.edit", compact("faq"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Faq $faq)
    {
        $faq->update([
            "title" => $request->title,
            "answer" => $request->answer,
        ]);

        return to_route("admin.faq.index")->with("swal-success", "سوال متداول مورد نظر با موفقیت ویرایش شد");
    }

    // change status
    public function changeStatus(Faq $faq)
    {
        if ($faq->status == "active") {
            $faq->update([
                "status" => "deactive"
            ]);

            return back()->with("swal-success", "وضعیت سوال متداول مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        } else {
            $faq->update([
                "status" => "active"
            ]);

            return back()->with("swal-success", "وضعیت سوال متداول مورد نظر با موفقیت به (فعال) تغییر یافت");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return back()->with("swal-success", "سوال متداول مورد نظر با موفقیت حذف شد");
    }
}
