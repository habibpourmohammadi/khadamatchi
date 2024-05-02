@extends('home.layouts.master')
@section('head-tag')
    <title>خدمات چی | خدمت ها</title>
@endsection
@section('content')
    <div dir="ltr" class="mt-24">
        <a href="{{ route('home.services.index') }}"
            class="focus:outline-none delay-75 transition-all text-white bg-red-600 hover:bg-red-700 hover:shadow-lg focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-red-900">
            بازگشت به صفحه خدمت ها
        </a>
    </div>
    <div class="py-3 mb-14 mt-5">
        <div
            class="shadow-lg bg-white border border-gray-200 rounded-lg dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
            <div class="flex flex-col items-center md:flex-row">
                <div id="gallery" class="relative w-full" data-carousel="slide">
                    <!-- Carousel wrapper -->
                    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                        <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                            <img src="{{ asset($service->service_image_path) }}"
                                class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="{{ $service->slug }}">
                        </div>
                        @foreach ($service->images as $image)
                            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                <img src="{{ asset($image->image_path) }}"
                                    class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                    alt="{{ $service->slug }}">
                            </div>
                        @endforeach
                    </div>
                    <!-- Slider controls -->
                    <button type="button"
                        class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-prev>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-gray-800 dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 1 1 5l4 4" />
                            </svg>
                            <span class="sr-only">قبلی</span>
                        </span>
                    </button>
                    <button type="button"
                        class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-next>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-gray-800 dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="sr-only">بعدی</span>
                        </span>
                    </button>
                </div>
                <div class="flex flex-col justify-between p-4 leading-normal">
                    <span class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $service->title ?? '-' }}
                        </h5>
                        <span class="block pt-2 font-normal text-lg text-gray-700 dark:text-gray-400">
                            نام و نام خانوادگی : {{ $service->user->full_name ?? '-' }}
                        </span>
                        @auth
                            <span
                                class="block pt-2 font-normal text-lg {{ $service->user->mobile == null ? 'text-red-700' : 'text-gray-700' }} dark:text-gray-400">
                                شماره تماس : {{ $service->user->mobile ?? 'ثبت نشده' }}
                            </span>
                        @endauth
                        @guest
                            <span class="block pt-2 font-normal text-lg text-gray-700 dark:text-gray-400">
                                شماره تماس : <a href="{{ route('home.login.page') }}" class="text-blue-700">برای دیدن شماره تماس
                                    ابتدا وارد حساب خود شوید</a>
                            </span>
                        @endguest
                        <span class="block pt-2 font-normal text-lg text-gray-700 dark:text-gray-400">
                            سابقه کاری : {{ $service->work_experience ?? '-' }}
                        </span>
                        <span class="block pt-2 font-normal text-lg text-gray-700 dark:text-gray-400">
                            استان : {{ $service->province->name ?? '-' }}
                        </span>
                        <span class="block pt-2 font-normal text-lg text-gray-700 dark:text-gray-400">
                            شهر : {{ $service->city->name ?? '-' }}
                        </span>
                        <span class="block pt-2 font-normal text-lg text-gray-700 dark:text-gray-400">
                            دسته بندی : {{ $service->category->name ?? '-' }}
                        </span>
                        <span class="block pt-2 font-normal text-lg text-gray-700 dark:text-gray-400">
                            توضیحات : {{ $service->description ?? '-' }}
                        </span>
                </div>
            </div>
            @php
                $activeTags = $service->tags()->where('status', 'active')->get();
            @endphp
            @if ($activeTags->count() > 0)
                <div class="border-t border-zinc-300 mx-4">
                    <div class="text-right ms-2 mb-2 mt-4 md:mb-2 md:mt-4">
                        <h6 class="text-md md:text-lg">
                            <span class="border-b border-blue-700">
                                تگ های خدمت 🏷️
                            </span>
                        </h6>
                    </div>
                    <div class="py-3 px-2">
                        @foreach ($activeTags as $tag)
                            <a href="{{ route('home.services.tags', ['search' => $tag->slug]) }}"
                                class="bg-gray-200 transition-all hover:bg-gray-300 text-gray-800 text-xs me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                                #{{ $tag->slug }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <livewire:service.show.comment :service-slug="$service->slug" />
    </div>
@endsection
