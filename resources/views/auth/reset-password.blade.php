<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('home-assets/icon/logo-red.png') }}">
    <link rel="stylesheet" href="{{ asset('home-assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/sweetalert/css/sweetalert2.css') }}">
    <title>خدمات چی | تغییر کلمه عبور</title>
</head>

<body dir="rtl">
    <main class="h-screen flex items-center justify-center">
        <div class="w-full">
            <div class="text-center mb-5 md:mb-8">
                <h1 class="text-xl md:text-2xl">
                    <span class="border-b-2 border-blue-700">
                        تغییر کلمه عبور
                    </span>
                </h1>
            </div>
            <form action="{{ route('password.reset.action', $token) }}" method="POST"
                class="max-w-sm mx-auto bg-gray-50 shadow-md px-3 py-5 rounded-lg">
                @csrf
                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        ایمیل :
                    </label>
                    <input dir="ltr" type="email" id="email" name="email"
                        class="bg-gray-50 font-sans border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="khadamatchi@gmail.com" value="{{ request()->email }}" required />
                    @error('email')
                        <small class="text-red-600 ms-1 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        کلمه عبور :
                    </label>
                    <input type="password" id="password" name="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="کلمه عبور جدید خود را وارد کنید" />
                    @error('password')
                        <small class="text-red-600 ms-1 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        تایید مجدد کلمه عبور :
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="تایید مجدد کلمه عبور جدید خود را وارد کنید" />
                    @error('password_confirmation')
                        <small class="text-red-600 ms-1 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <x-inputs.button type="submit" name="تغییر کلمه عبور" />
            </form>
        </div>
    </main>
    <script src="{{ asset('admin-assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin-assets/sweetalert/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin-assets/sweetalert/js/sweetalert2.min.js') }}"></script>
    @include('home.alert.sweetalert.success')
    @include('home.alert.sweetalert.error')
</body>

</html>
