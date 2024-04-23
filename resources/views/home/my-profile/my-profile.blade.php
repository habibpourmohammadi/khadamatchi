@extends('home.layouts.master')
@section('head-tag')
    <title>خدمات چی | حساب کاربری</title>
@endsection
@section('content')
    <div class="flex flex-col w-full md:flex-row mt-4 px-3 pb-20 md:py-28">
        @include('home.my-profile.sidebar')
        <div class="md:w-4/6 bg-gray-50 mt-5 md:mt-0 md:ms-3 shadow-lg py-2 px-2 md:py-5 md:px-5 rounded-lg">
            <form action="{{ route('home.my-profile.update') }}" method="POST" class="grid grid-cols-12 gap-2"
                enctype="multipart/form-data">
                @csrf
                <div class="col-span-6 mt-1">
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        نام
                    </label>
                    <input type="text" id="first_name" name="first_name"
                        class="bg-gray-50  border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="حبیب الله" required value="{{ old('first_name', auth()->user()->first_name) }}" />
                    @error('first_name')
                        <small class="text-red-700 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-span-6 mt-1">
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        نام خانوادگی
                    </label>
                    <input type="text" id="last_name" name="last_name"
                        class="bg-gray-50  border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="پورمحمدی" required value="{{ old('last_name', auth()->user()->last_name) }}" />
                    @error('last_name')
                        <small class="text-red-700 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-span-6 mt-1">
                    <label for="profile_path" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        پروفایل
                    </label>
                    <input type="file" id="profile_path" name="profile_path"
                        class="bg-gray-50 font-sans border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    @error('profile_path')
                        <small class="text-red-700 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-span-6 mt-1">
                    <label for="mobile" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        موبایل
                    </label>
                    <input type="number" id="mobile" name="mobile"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        @readonly(auth()->user()->mobile != null) value="{{ old('mobile', auth()->user()->mobile) }}" />
                    @error('mobile')
                        <small class="text-red-700 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div
                    class="{{ auth()->user()->account_verified_at == null ? 'col-span-8 sm:col-span-9' : 'col-span-12' }} mt-1">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        ایمیل
                    </label>
                    <input dir="rtl" type="email" id="email"
                        class="bg-gray-50 font-sans border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        readonly value="{{ auth()->user()->email }}" />
                    @error('email')
                        <small class="text-red-700 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                @if (auth()->user()->account_verified_at == null)
                    <div class="col-span-4 sm:col-span-3 mt-1 pt-9 text-left">
                        <a href=""
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-2 sm:px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            تایید ایمیل
                        </a>
                    </div>
                @endif
                <div class="col-span-6 mt-1">
                    <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        شهر
                    </label>
                    <select name="city" id="city"
                        class="bg-gray-50  border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($cities as $city)
                            <option value="{{ $city->slug }}" @selected($city->slug == old('city', auth()->user()->city->slug))>{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @error('city')
                        <small class="text-red-700 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-span-6 mt-1">
                    <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        جنسیت
                    </label>
                    <select name="gender" id="gender"
                        class="bg-gray-50  border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="male" @selected(old('gender', auth()->user()->gender) == 'male')>مرد</option>
                        <option value="female" @selected(old('gender', auth()->user()->gender) == 'female')>زن</option>
                        <option value="none" @selected(old('gender', auth()->user()->gender) == 'none')>مشخص نشده</option>
                    </select>
                    @error('gender')
                        <small class="text-red-700 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-span-12 mt-1">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ویرایش
                        اطلاعات</button>
                </div>
            </form>
        </div>
    </div>
@endsection
