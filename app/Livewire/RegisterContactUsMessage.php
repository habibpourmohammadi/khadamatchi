<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ContactMessage;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class RegisterContactUsMessage extends Component
{
    /**
     * The title of the contact us message.
     *
     * @var string
     */
    #[Validate("required|max:150")]
    public $title;

    /**
     * The content of the contact us message.
     *
     * @var string
     */
    #[Validate("required", "متن پیام")]
    public $message;

    /**
     * Register a contact us message.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        // Validate the request
        $this->validate();

        // Redirect to the login page if the user is not authenticated
        if (!Auth::check()) {
            return to_route("home.login.page");
        }
        // Redirect to the profile page with an error message if the user's email is not verified
        elseif (Auth::user()->account_verified_at == null) {
            return to_route("home.my-profile.page")->with("swal-error", "لطفا ابتدا ایمیل خود را تایید کنید !");
        }
        // Store the contact message if the user is authenticated and email is verified
        else {
            $this->store();
        }
    }

    /**
     * Store the contact us message.
     *
     * @return void
     */
    private function store()
    {
        // Create a new contact message record
        ContactMessage::create([
            "user_id" => Auth::user()->id,
            "title" => $this->title,
            "message" => $this->message,
        ]);

        // Reset the input fields
        $this->reset();

        // Flash a success message to the session
        session()->flash("success-alert", "پیام شما با موفقیت ثبت شد 👌");
    }
}
