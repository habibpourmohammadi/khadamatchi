<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Service $service)
    {
        $search = request()->search;

        $comments = $service->comments()->when($search, function ($query) use ($search) {
            return $query->where("comment", "like", "%$search%")->orWhereHas("user", function ($query) use ($search) {
                $query->where("first_name", "like", "%$search%")->orWhere("last_name", "like", "%$search%")->orWhere("slug", "like", "%$search%")->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]);
            })->orWhereHas("service", function ($query) use ($search) {
                $query->where("title", "like", "%$search%")->orWhere("slug", "like", "%$search%");
            });
        })->with("user", "service")->get();

        return view("admin.service.comment.index", compact("comments", "service"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service, ServiceComment $comment)
    {
        return view("admin.service.comment.show", compact("service", "comment"));
    }

    // change status
    public function changeStatus(Service $service, ServiceComment $comment)
    {
        if ($comment->status == "active") {
            $comment->update([
                "status" => "deactive"
            ]);

            return back()->with("swal-success", "وضعیت نظر مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        } else {
            $comment->update([
                "status" => "active"
            ]);

            return back()->with("swal-success", "وضعیت نظر مورد نظر با موفقیت به (فعال) تغییر یافت");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service, ServiceComment $comment)
    {
        $comment->delete();

        return back()->with("swal-success", "نظر مورد نظر با موفقیت حذف شد");
    }
}
