<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ServiceComment;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $users = User::query()->when($search, function ($query) use ($search) {
            $query->where("first_name", "like", "%$search%")->orWhere("last_name", "like", "%$search%")->orWhere("slug", "like", "%$search%")->orWhere("mobile", "like", "%$search%")->orWhere("email", "like", "%$search%")->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"])->orWhereHas("province", function ($query) use ($search) {
                $query->where("name", "like", "%$search%")->orWhere("slug", "like", "%$search%");
            })->orWhereHas("city", function ($query) use ($search) {
                $query->where("name", "like", "%$search%")->orWhere("slug", "like", "%$search%");
            });
        })->with("province", "city", "services")->get();

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

    // show user comments
    public function comments(User $user)
    {
        $search = request()->search;

        $comments = $user->comments()->when($search, function ($query) use ($search) {
            return $query->where("comment", "like", "%$search%")->orWhereHas("user", function ($query) use ($search) {
                $query->where("first_name", "like", "%$search%")->orWhere("last_name", "like", "%$search%")->orWhere("slug", "like", "%$search%")->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]);
            })->orWhereHas("service", function ($query) use ($search) {
                $query->where("title", "like", "%$search%")->orWhere("slug", "like", "%$search%");
            });
        })->with("user", "service")->get();

        return view("admin.user.comments", compact("comments", "user"));
    }
}
