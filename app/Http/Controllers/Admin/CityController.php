<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\City\StoreRequest;
use App\Http\Requests\Admin\City\UpdateRequest;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get search query from request
        $search = request()->search;
        // Get sort order from request
        $sort = request()->sort;

        // Validate and set sorting order
        $sort = in_array($sort, ["ASC", "DESC"]) ? $sort : "DESC";

        // Query Builder for searching cities
        $citiesQuery = City::query()
            ->when($search, function ($query) use ($search) {
                // Add search conditions for city name and slug
                $query->where("name", "like", "%$search%")
                    ->orWhere("slug", "like", "%$search%")
                    ->orWhereHas("province", function ($query) use ($search) {
                        // Add search condition for province name
                        $query->where("name", "like", "%$search%");
                    });
            })
            ->with(['province']);

        // Sort and get results
        $cities = $citiesQuery->orderBy('id', $sort)->get();

        // Sort the Collection based on province name
        $cities = $cities->sortBy('province.name', SORT_REGULAR, $sort === 'DESC');

        // Send results to the view
        return view("admin.city.index", compact("cities"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::where("status", "active")->get();

        return view("admin.city.create", compact("provinces"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        City::create([
            "province_id" => $request->province_id,
            "name" => $request->name,
        ]);

        return to_route("admin.city.index")->with("swal-success", "شهر جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        $provinces = Province::where("status", "active")->get();

        return view("admin.city.edit", compact("provinces", "city"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, City $city)
    {
        $city->update([
            "province_id" => $request->province_id,
            "name" => $request->name,
        ]);

        return to_route("admin.city.index")->with("swal-success", "شهر مورد نظر با موفقیت ویرایش شد");
    }

    public function changeStatus(City $city)
    {
        if ($city->status == "active") {
            $city->update([
                "status" => "deactive"
            ]);

            return back()->with("swal-success", "وضعیت شهر مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        } else {
            $city->update([
                "status" => "active"
            ]);

            return back()->with("swal-success", "وضعیت شهر مورد نظر با موفقیت به (فعال) تغییر یافت");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        DB::transaction(function () use ($city) {
            $city->update([
                "name" => $city->name . ' ' . time(),
            ]);

            $city->delete();
        });

        return back()->with("swal-success", "شهر مورد نظر با موفقیت حذف شد");
    }
}
