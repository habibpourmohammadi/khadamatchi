@extends('home.layouts.master')
@section('head-tag')
    <title>خدمات چی | سوالات متداول</title>
@endsection
@section('content')
    <div class="mt-32 mb-52">
        <div class="text-center mb-5 mt-8 md:mb-8 md:mt-10">
            <h1 class="text-lg md:text-2xl">
                <span class="border-b border-red-500">
                    جواب سوالات متداول وبسایت خدمات چی رو اینجا ببین <small>👇</small>
                </span>
            </h1>
        </div>
        <div id="accordion-collapse" data-accordion="collapse" class="mx-36">
            @forelse ($faqs as $faq)
                <h2 id="accordion-collapse-heading-{{ $loop->iteration }}">
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-1 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                        data-accordion-target="#accordion-collapse-body-{{ $loop->iteration }}" aria-expanded="true"
                        aria-controls="accordion-collapse-body-{{ $loop->iteration }}">
                        <span>
                            {{ $faq->title }}
                        </span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-{{ $loop->iteration }}" class="hidden"
                    aria-labelledby="accordion-collapse-heading-{{ $loop->iteration }}">
                    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                        <p class="mb-2 text-gray-500 dark:text-gray-400">
                            {{ $faq->answer }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="bg-red-100 border text-center border-red-400 text-red-700 px-4 py-3 rounded relative"
                    role="alert">
                    <strong class="font-bold">مشکلی پیش اومده !</strong>
                    <span class="block sm:inline">لیست سوالات متداول خالیه 🤷‍♂️</span>
                </div>
            @endforelse
        </div>
    </div>
@endsection
