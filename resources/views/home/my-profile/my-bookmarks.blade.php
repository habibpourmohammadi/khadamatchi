@extends('home.layouts.master')
@section('head-tag')
    <title>خدمات چی | لیست علاقه مندی های من</title>
@endsection
@section('content')
    <div class="flex flex-col w-full md:flex-row mt-4 px-3 pb-20 md:py-28">
        @include('home.my-profile.sidebar')
        <div class="md:w-4/6 xl:w-5/6 bg-gray-50 mt-5 md:mt-0 md:ms-3 shadow-lg py-2 px-2 md:py-5 md:px-5 rounded-lg">
            <livewire:my-profile.my-bookmarks>
        </div>
    </div>
@endsection
