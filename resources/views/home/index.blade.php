@extends('home.layouts.master')
@section('head-tag')
    <title>خدمات چی | khadamatchi</title>
@endsection
@section('content')
    <div class="text-center mb-5 mt-8 md:mb-8 md:mt-10">
        <h1 class="text-lg md:text-2xl">
            <span class="border-b border-red-500">
                فرد متخصص رو نسبت به فیلتر های خودت انتخاب کن
            </span>
        </h1>
    </div>
    <form action="{{ route('home.services.index') }}" method="GET"
        class="mt-5 flex flex-col mx-5 md:flex-row md:justify-between">
        <div class="mb-3 flex flex-col md:flex-row md:w-full">
            <div class="mb-2 md:w-2/4 md:mx-1">
                <input type="text" name="search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="جستجو ...">
            </div>
            <div class="mb-2 md:w-1/4 md:mx-1">
                <select name="category"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">همه دسته بندی ها</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:w-1/4 md:mx-1">
                <select name="city"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">همه شهر ها</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->slug }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <button
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">جستجو</button>
        </div>
    </form>
    <div class="mt-5 md:mt-10">
        <a href="{{ route('home.services.index') }}">
            <img src="{{ asset('home-assets/images/banner.png') }}" alt=""
                class="rounded-lg md:rounded-2xl w-full md:w-4/5 m-auto">
        </a>
    </div>
    <div class="text-center mt-5 md:mt-12">
        <h1 class="text-lg md:text-2xl">
            <span class="border-b border-red-500">
                خدماتی که متخصصین ما انجام میدهند
            </span>
        </h1>
    </div>
    <div class="mt-5 flex flex-col items-center sm:flex-row sm:flex-wrap sm:justify-center">
        @foreach ($categoriesHasImage as $category)
            <div
                class="w-full max-w-44 m-3 bg-white border border-gray-200 delay-75 transition-all hover:border-red-300 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700">
                <a href="{{ route('home.services.index', ['category' => $category->slug]) }}">
                    <img class="p-1 rounded-t-lg" src="{{ asset($category->image_path) }}" alt="{{ $category->slug }}" />
                </a>
                <div class="px-1 pb-3 text-center">
                    <a href="{{ route('home.services.index', ['category' => $category->slug]) }}">
                        <h5 class="text-sm font-semibold tracking-tight text-gray-900 dark:text-white">
                            {{ $category->name }}
                        </h5>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-5 md:mt-10">
        <div class="text-center mb-8">
            <h1 class="text-lg md:text-2xl">
                <span class="border-b border-red-500">
                    میخواهید به جمع متخصصین خدمات چی بپیوندید ؟
                </span>
            </h1>
        </div>
        <livewire:register-expertise>
    </div>
    <div class="mt-8 md:mt-10">
        <div class="text-center mb-8">
            <h1 class="text-2xl">
                <span class="border-b border-red-500">
                    نظرات کاربران خدمات چی 💬
                </span>
            </h1>
        </div>
        <div class="flex flex-row flex-wrap justify-center">
            @foreach ($comments as $comment)
                <div
                    class="mx-1 my-1 block max-w-sm px-6 py-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <p class="font-normal text-gray-700 dark:text-gray-400 pb-2">
                        {{ $comment->comment }}
                    </p>
                    <div class="flex items-center gap-4 border-t-2 pt-3">
                        @if ($comment->user->profile_path !== null)
                            <img class="w-9 h-9 rounded-full" src="{{ asset($comment->user->profile_path) }}"
                                alt="">
                        @endif
                        <div class="font-medium dark:text-white">
                            <div>
                                {{ $comment->user->full_name }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
