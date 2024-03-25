<?php

namespace App\Http\Controllers\Admin\Service;

use App\Models\Service;
use App\Models\ServiceImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Service $service)
    {
        $search = request()->search;

        $images = ServiceImage::query()->when($search, function ($query) use ($search) {
            return $query->where("image_size", "like", "%$search%")->orWhere("image_type", "like", "%$search%")->orWhereHas("service", function ($query) use ($search) {
                $query->where("title", "like", "%$search%")->orWhere("slug", "like", "%$search%");
            });
        })->with("service")->where("service_id", $service->id)->get();

        return view("admin.service.image.index", compact("images", "service"));
    }

    // change status
    public function changeStatus(Service $service, ServiceImage $image)
    {
        if ($image->status == "active") {
            $image->update([
                "status" => "deactive"
            ]);

            return back()->with("swal-success", "وضعیت عکس مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        } else {
            $image->update([
                "status" => "active"
            ]);

            return back()->with("swal-success", "وضعیت عکس مورد نظر با موفقیت به (فعال) تغییر یافت");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service, ServiceImage $image)
    {
        if (File::exists(public_path($image->image_path))) {
            File::delete(public_path($image->image_path));
        }

        $image->delete();

        return back()->with("swal-success", "عکس مورد نظر با موفقیت حذف شد");
    }
}
