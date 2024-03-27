<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $contactMessages = ContactMessage::query()->when($search, function ($query) use ($search) {
            return $query->where("title", "like", "%$search%")->orWhere("message", "like", "%$search%")->orWhereHas("user", function ($query) use ($search) {
                $query->where("first_name", "like", "%$search%")->orWhere("last_name", "like", "%$search%")->orWhere("slug", "like", "%$search%")->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]);
            });
        })->with("user")->get();

        return view("admin.contact-message.index", compact("contactMessages"));
    }

    public function show(ContactMessage $message)
    {
        return view("admin.contact-message.show", compact("message"));
    }

    // change status
    public function changeSeenStatus(ContactMessage $message)
    {
        if ($message->seen == "true") {
            $message->update([
                "seen" => "false"
            ]);

            return back()->with("swal-success", "وضعیت دیده شدن پیام مورد نظر با موفقیت به (دیده نشده) تغییر یافت");
        } else {
            $message->update([
                "seen" => "true"
            ]);

            return back()->with("swal-success", "وضعیت دیده شدن پیام مورد نظر با موفقیت به (دیده شده) تغییر یافت");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return back()->with("swal-success", "پیام مورد نظر با موفقیت حذف شد");
    }
}
