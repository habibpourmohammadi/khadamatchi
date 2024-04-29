<?php

namespace App\Livewire\Service\Show;

use App\Models\Service;
use App\Models\ServiceComment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Comment extends Component
{
    public $serviceId;

    // Validation rules for the comment input
    #[Validate("required|min:5", "نظر")]
    public $comment;

    /**
     * Mount the component with the service ID based on the given service slug.
     */
    public function mount($serviceSlug)
    {
        // Resolve the service ID based on the provided slug
        $this->serviceId = Service::where("slug", $serviceSlug)->first()->id ?? null;
    }

    /**
     * Retrieve comments associated with the service.
     */
    #[Computed()]
    public function comments()
    {
        if ($this->serviceId == null) {
            return [];
        }

        // Retrieve active comments related to the service, including user information
        $comments = ServiceComment::where("service_id", $this->serviceId)
            ->where("status", "active")
            ->with("user")
            ->latest()
            ->get();

        return $comments;
    }

    /**
     * Create a new comment for the service.
     */
    public function createComment()
    {
        $this->validateOnly("comment");

        try {
            if (Auth::check()) {
                $service = Service::find($this->serviceId);

                // Check if the user's email is verified
                if (Auth::user()->account_verified_at == null) {
                    return to_route("home.my-profile.page")->with("swal-error", "لطفا ابتدا ایمیل خود را تایید کنید");
                }

                // Create a new comment
                ServiceComment::create([
                    "user_id" => Auth::user()->id,
                    "service_id" => $service->id,
                    "comment" => $this->comment,
                ]);

                // Reset the comment input field
                $this->reset("comment");
                // Redirect back with a success message
                return back()->with("success-alert", "نظر شما ثبت شد و بعد از تایید قابل مشاهده میباشد");
            } else {
                // Redirect to the login page if the user is not authenticated
                return to_route("home.login.page");
            }
        } catch (\Throwable $th) {
            // Reset the comment input field in case of an error
            $this->reset("comment");

            // Redirect back with an error message
            return back()->with("error-alert", "لطفا دوباره تلاش کنید");
        }
    }

    public function render()
    {
        return view('livewire.service.show.comment');
    }
}
