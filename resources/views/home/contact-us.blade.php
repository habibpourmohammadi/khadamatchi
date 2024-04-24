@extends('home.layouts.master')
@section('head-tag')
    <title>خدمات چی | ارتباط با ما</title>
@endsection
@section('content')
    <div class="my-44">
        <div class="text-center mb-5 mt-8 md:mb-8 md:mt-10">
            <h1 class="text-lg md:text-2xl">
                <span class="border-b border-red-500">
                    نظرات و پیشنهادات خود را با ما به اشتراک بگذارید ✌
                </span>
            </h1>
        </div>
        <livewire:register-contact-us-message />
    </div>
@endsection
