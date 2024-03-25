<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->search;

        $services = Service::query()->when($search, function ($query) use ($search) {
            return $query->where("title", "like", "%$search%")
                ->orWhere("slug", "like", "%$search%")
                ->orWhereHas("user", function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where("first_name", "like", "%$search%")
                            ->orWhere("last_name", "like", "%$search%")
                            ->orWhere("slug", "like", "%$search%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]);
                    });
                })
                ->orWhereHas("category", function ($query) use ($search) {
                    $query->where("name", "like", "%$search%")
                        ->orWhere("slug", "like", "%$search%");
                })
                ->orWhereHas("city", function ($query) use ($search) {
                    $query->where("name", "like", "%$search%")
                        ->orWhere("slug", "like", "%$search%");
                })
                ->orWhereHas("province", function ($query) use ($search) {
                    $query->where("name", "like", "%$search%")
                        ->orWhere("slug", "like", "%$search%");
                });
        })->with("user", "category", "city", "province")->get();



        return view("admin.service.index", compact("services"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view("admin.service.show", compact("service"));
    }


    public function changeStatus(Service $service)
    {
        if ($service->status == "active") {
            $service->update([
                "status" => "deactive"
            ]);

            return back()->with("swal-success", "وضعیت خدمت مورد نظر با موفقیت به (غیر فعال) تغییر یافت");
        } else {
            $service->update([
                "status" => "active"
            ]);

            return back()->with("swal-success", "وضعیت خدمت مورد نظر با موفقیت به (فعال) تغییر یافت");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $image_path = $service->service_image_path;

        DB::transaction(function () use ($service) {
            $service->update([
                "title" => $service->title . ' ' . time(),
            ]);

            $service->delete();
        });

        if (File::exists(public_path($image_path))) {
            File::delete(public_path($image_path));
        }

        return back()->with("swal-success", "خدمت مورد نظر با موفقیت حذف شد");
    }

    // show service tags
    public function tags(Service $service)
    {
        $tags = $service->tags;
        return view("admin.service.tags", compact("tags"));
    }
}
