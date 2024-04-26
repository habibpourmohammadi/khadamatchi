<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Comment\StoreRequest;

class CommentController extends Controller
{
    /**
     * Display the index page for comments with optional search functionality.
     */
    public function index()
    {
        // Retrieve the search term from the request
        $search = request()->search;

        // Query comments based on search criteria
        $comments = Comment::query()->when($search, function ($query) use ($search) {
            return $query->where("comment", "like", "%$search%")->orWhereHas("user", function ($query) use ($search) {
                $query->where("first_name", "like", "%$search%")->orWhere("last_name", "like", "%$search%")->orWhere("slug", "like", "%$search%")->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]);
            });
        })->with("user")->get();

        // Return the view with the fetched comments
        return view("admin.comment.index", compact("comments"));
    }

    /**
     * Display the create comment form with a list of active users.
     */
    public function create()
    {
        // Retrieve a list of active users
        $users = User::where("status", "active")->get();

        // Return the view with the list of users for comment creation
        return view("admin.comment.create", compact("users"));
    }

    /**
     * Store a newly created comment.
     */
    public function store(StoreRequest $request)
    {
        // Create a new comment record with the provided user ID and comment content
        Comment::create([
            "user_id" => $request->user_id,
            "comment" => $request->comment,
        ]);

        // Redirect back to the comments index page with a success alert message
        return to_route("admin.comment.index")->with("swal-success", "نظر جدید شما با موفقیت ایجاد شد");
    }

    /**
     * Show the form for editing the specified comment.
     */
    public function edit(Comment $comment)
    {
        // Retrieve active users for selection
        $users = User::where("status", "active")->get();

        // Return the view with the comment data and available users
        return view("admin.comment.edit", compact("comment", "users"));
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(StoreRequest $request, Comment $comment)
    {
        // Update the comment with the new user ID and comment content
        $comment->update([
            "user_id" => $request->user_id,
            "comment" => $request->comment,
        ]);

        // Redirect back to the comment index page with a success message
        return to_route("admin.comment.index")->with("swal-success", "نظر مورد نظر با موفقیت ویرایش شد");
    }

    /**
     * Change the status of the specified comment.
     */
    public function changeStatus(Comment $comment)
    {
        // Check the current status of the comment and toggle it
        if ($comment->status == "active") {
            // Deactivate the comment
            $comment->update([
                "status" => "deactive"
            ]);

            // Return with a success message for deactivation
            return back()->with("swal-success", "وضعیت نظر مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        } else {
            // Activate the comment
            $comment->update([
                "status" => "active"
            ]);

            // Return with a success message for activation
            return back()->with("swal-success", "وضعیت نظر مورد نظر با موفقیت به (فعال) تغییر یافت");
        }
    }

    /**
     * Delete the specified comment.
     */
    public function destroy(Comment $comment)
    {
        // Delete the specified comment
        $comment->delete();

        // Return with a success message for deletion
        return back()->with("swal-success", "نظر مورد نظر با موفقیت حذف شد");
    }
}
