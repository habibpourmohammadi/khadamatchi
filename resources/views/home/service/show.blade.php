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
                <img class="object-cover w-96 rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg"
                    src="{{ asset($service->service_image_path) }}" alt="">
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
                            <a href=""
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
