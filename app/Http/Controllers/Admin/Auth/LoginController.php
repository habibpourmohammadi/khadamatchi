<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\Auth\LoginRequest;

class LoginController extends Controller
{
    public function loginPage()
    {
        return view("admin.auth.login");
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->isAdmin()) {
                $request->session()->regenerate();
                return to_route("admin.index")->with("swal-success", "شما با موفقیت وارد پنل ادمین شدید");
            } else {
                Auth::logout();
                return back()->withInput()->withErrors(['password' => 'اطلاعات وارد شده صحیح نمی باشد']);
            }
        } else {
            return back()->withInput()->withErrors(['password' => 'اطلاعات وارد شده صحیح نمی باشد']);
        }
    }
}
