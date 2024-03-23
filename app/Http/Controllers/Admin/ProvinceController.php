<?php

namespace App\Http\Controllers\Admin;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Province\StoreRequest;
use App\Http\Requests\Admin\Province\UpdateRequest;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $provinces = Province::query()->when($search, function ($provinces) use ($search) {
            return $provinces->where("name", "like", "%$search%")->orWhere("slug", "like", "%$search%")->get();
        }, function ($provinces) {
            return $provinces->get();
        });

        return view("admin.province.index", compact("provinces"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.province.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        Province::create([
            "name" => $request->name
        ]);

        return to_route("admin.province.index")->with("swal-success", "استان جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        return view("admin.province.edit", compact("province"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Province $province)
    {
        $province->update([
            "name" => $request->name
        ]);

        return to_route("admin.province.index")->with("swal-success", "استان مورد نظر با موفقیت ویرایش شد");
    }


    public function changeStatus(Province $province)
    {
        if ($province->status == "active") {
            $province->update([
                "status" => "deactive"
            ]);

            return back()->with("swal-success", "وضعیت استان مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        } else {
            $province->update([
                "status" => "active"
            ]);

            return back()->with("swal-success", "وضعیت استان مورد نظر با موفقیت به (فعال) تغییر یافت");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        DB::transaction(function () use ($province) {
            $province->update([
                "name" => $province->name . ' ' . time(),
            ]);

            $province->delete();
        });

        return back()->with("swal-success", "استان مورد نظر با موفقیت حذف شد");
    }
}
