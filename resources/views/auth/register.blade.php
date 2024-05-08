<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('home-assets/icon/logo-red.png') }}">
    <link rel="stylesheet" href="{{ asset('home-assets/css/main.css') }}">
    <title>خدمات چی | ثبت نام در وبسایت</title>
</head>

<body dir="rtl">
    <main class="h-screen flex items-center justify-center">
        <div class="w-full">
            <div class="text-center mb-8 md:mb-10">
                <h1 class="text-xl md:text-2xl">
                    <span class="border-b-2 border-blue-700">
                        ثبت نام در وبسایت
                    </span>
                </h1>
            </div>
            <form action="{{ route('home.register') }}" method="POST"
                class="max-w-sm mx-auto bg-gray-50 shadow-md px-3 py-5 rounded-lg">
                @csrf
                <div class="mb-5">
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        نام خود را وارد کنید <span class="text-red-700 font-bold">*</span>
                    </label>
                    <input type="text" id="first_name" name="first_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="حبیب الله" value="{{ old('first_name') }}" required />
                    @error('first_name')
                        <small class="text-red-600 ms-1 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        نام خانوادگی خود را وارد کنید <span class="text-red-700 font-bold">*</span>
                    </label>
                    <input type="text" id="last_name" name="last_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="پورمحمدی" value="{{ old('last_name') }}" required />
                    @error('last_name')
                        <small class="text-red-600 ms-1 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="mobile" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        شماره موبایل خود را وارد کنید
                    </label>
                    <input dir="ltr" type="number" id="mobile" name="mobile"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="0913xxxxxxx" value="{{ old('mobile') }}" />
                    @error('mobile')
                        <small class="text-red-600 ms-1 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        شهر خود را انتخاب کنید <span class="text-red-700 font-bold">*</span>
                    </label>
                    <select name="city" id="city"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">شهر خود را انتخاب کنید</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->slug }}" @selected(old('city'))>{{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('city')
                        <small class="text-red-600 ms-1 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        ایمیل خود را وارد کنید <span class="text-red-700 font-bold">*</span>
                    </label>
                    <input dir="ltr" type="email" id="email" name="email"
                        class="bg-gray-50 font-sans border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="khadamatchi@gmail.com" value="{{ old('email') }}" required />
                    @error('email')
                        <small class="text-red-600 ms-1 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        کلمه عبور خود را وارد کنید <span class="text-red-700 font-bold">*</span>
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
                        حساب کاربری دارید؟
                        <a href="{{ route('home.login.page') }}"
                            class="text-decoration-none text-blue-700 font-bold hover:underline">
                            ورود به حساب کاربری
                        </a>
                    </span>
                </div>
                <x-inputs.button type="submit" name="ثبت نام" />
            </form>
        </div>
    </main>
</body>

</html>
