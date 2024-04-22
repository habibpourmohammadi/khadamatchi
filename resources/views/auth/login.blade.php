<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('home-assets/icon/logo-red.png') }}">
    <link rel="stylesheet" href="{{ asset('home-assets/css/main.css') }}">
    <title>خدمات چی | ورود به حساب کاربری</title>
</head>

<body dir="rtl">
    <main class="h-screen flex items-center justify-center">
        <div class="w-full">
            <div class="text-center mb-8 md:mb-10">
                <h1 class="text-xl md:text-2xl">
                    <span class="border-b-2 border-blue-700">
                        ورود به حساب کاربری
                    </span>
                </h1>
            </div>
            <form action="{{ route('home.login') }}" method="POST" class="max-w-sm mx-auto bg-gray-50 shadow-md px-3 py-5 rounded-lg">
                @csrf
                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        ایمیل خود را وارد کنید :
                    </label>
                    <input dir="ltr" type="email" id="email" name="email"
                        class="bg-gray-50 font-sans border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="khadamatchi@gmail.com" required />
                    @error('email')
                        <small class="text-red-600 ms-1 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        کلمه عبور خود را وارد کنید :
                    </label>
                    <input dir="ltr" type="password" id="password" name="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required />
                    @error('password')
                        <small class="text-red-600 ms-1 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div class="flex items-start mb-5">
                    <span class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        حساب کاربری ندارید؟
                        <a href="" class="text-decoration-none text-blue-700 font-bold hover:underline">
                            ثبت نام در وبسایت
                        </a>
                    </span>
                </div>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    ورود به حساب کاربری
                </button>
            </form>
        </div>
    </main>
</body>

</html>
