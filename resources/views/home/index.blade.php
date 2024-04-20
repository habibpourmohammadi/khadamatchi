@extends('home.layouts.master')
@section('head-tag')
    <title>خدمات چی | khadamatchi</title>
@endsection
@section('content')
    <div class="mt-5 md:mt-14">
        <a href="">
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
        @for ($i = 0; $i <= 13; $i++)
            <div
                class="w-full max-w-44 m-3 bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700">
                <a href="#">
                    <img class="p-1 rounded-t-lg"
                        src="https://s3.achareh.co/production.achareh.ir/uploads/images/e7ccc8a9617e4719a503c2d57f4ae948.png"
                        alt="product image" />
                </a>
                <div class="px-1 pb-3 text-center">
                    <a href="#">
                        <h5 class="text-sm font-semibold tracking-tight text-gray-900 dark:text-white">
                            تعمیرات لوازم خانگی {{ $i + 1 }}
                        </h5>
                    </a>
                </div>
            </div>
        @endfor
    </div>
@endsection
