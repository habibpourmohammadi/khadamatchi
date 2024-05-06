<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\StoreRequest;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $admins = Admin::query()->when($search, function ($query) use ($search) {
            return $query->whereHas("user", function ($query) use ($search) {
                $query->where("first_name", "like", "%$search%")->orWhere("last_name", "like", "%$search%")->orWhere("slug", "like", "%$search%")->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]);
            });
        })->with("user")->get();

        return view("admin.admin.index", compact("admins"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::where("status", "active")->get();

        return view("admin.admin.create", compact("cities"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $inputs = $request->validated();

        DB::transaction(function () use ($inputs) {
            $city = City::find($inputs["city_id"]);

            $user = User::create([
                "first_name" => $inputs["first_name"],
                "last_name" => $inputs["last_name"],
                "email" => $inputs["email"],
                "password" => Hash::make($inputs["password"]),
                "province_id" => $city->province->id,
                "city_id" => $city->id,
                "gender" => "none",
            ]);

            Admin::create([
                "user_id" => $user->id
            ]);
        });

        return to_route("admin.admin.index")->with("swal-success", "ادمین جدید شما با موفقیت ایجاد شد");
    }

    public function destroy(Admin $admin, User $user)
    {
        // Check if the user associated with the admin record matches the specified user
        if ($admin->user_id != $user->id) {
            // If the users do not match, return a 404 error (Not Found)
            abort(404);
        }

        // Delete the admin record from the database
        $admin->delete();

        // Redirect to the admin index route with a success message
        return to_route("admin.admin.index")->with("swal-success", "ادمین مورد نظر با موفقیت حذف شد");
    }
}
