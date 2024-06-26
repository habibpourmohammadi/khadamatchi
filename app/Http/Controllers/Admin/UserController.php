<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ServiceComment;
use App\Http\Controllers\Controller;
use App\Models\Admin;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;
        $sort = request()->sort;

        if (!in_array(request()->sort, ["ASC", "DESC"])) {
            $sort = "ASC";
        }

        $users = User::query()->when($search, function ($query) use ($search) {
            $query->where("first_name", "like", "%$search%")->orWhere("last_name", "like", "%$search%")->orWhere("slug", "like", "%$search%")->orWhere("mobile", "like", "%$search%")->orWhere("email", "like", "%$search%")->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"])->orWhereHas("province", function ($query) use ($search) {
                $query->where("name", "like", "%$search%")->orWhere("slug", "like", "%$search%");
            })->orWhereHas("city", function ($query) use ($search) {
                $query->where("name", "like", "%$search%")->orWhere("slug", "like", "%$search%");
            });
        })->with("province", "city", "services")->orderBy("created_at", $sort)->get();

        return view("admin.user.index", compact("users"));
    }

    // change status
    public function changeStatus(User $user)
    {
        if ($user->status == "active") {
            $user->update([
                "status" => "ban"
            ]);

            return back()->with("swal-success", "وضعیت کاربر مورد نظر با موفقیت به (بن) تغییر یافت");
        } else {
            $user->update([
                "status" => "active"
            ]);

            return back()->with("swal-success", "وضعیت کاربر مورد نظر با موفقیت به (فعال) تغییر یافت");
        }
    }

    public function changeAdminStatus(User $user)
    {
        // Check if the user is currently an admin
        if ($user->isAdmin()) {
            // If the user is an admin, delete the admin record (revoke admin status)
            $user->admin->delete();

            // Return back with success message indicating change to regular user
            return back()->with("swal-success", "وضعیت کاربر به (کاربر عادی) تغییر کرد");
        } else {
            // If the user is not an admin, create a new admin record (grant admin status)
            Admin::create([
                "user_id" => $user->id,
            ]);

            // Return back with success message indicating change to admin
            return back()->with("swal-success", "وضعیت کاربر به (ادمین) تغییر کرد");
        }
    }

    // show user comments
    public function comments(User $user)
    {
        $search = request()->search;

        $comments = ServiceComment::query()->when($search, function ($query) use ($search) {
            return $query->where("comment", "like", "%$search%")->orWhereHas("user", function ($query) use ($search) {
                $query->where("first_name", "like", "%$search%")->orWhere("last_name", "like", "%$search%")->orWhere("slug", "like", "%$search%")->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]);
            })->orWhereHas("service", function ($query) use ($search) {
                $query->where("title", "like", "%$search%")->orWhere("slug", "like", "%$search%");
            });
        })->with("user", "service")->where("user_id", $user->id)->get();

        return view("admin.user.comments", compact("comments", "user"));
    }
}
