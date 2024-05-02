@extends('home.layouts.master')
@section('head-tag')
    <title>خدمات چی | تگ ها</title>
@endsection
@section('content')
    <div class="text-center mb-5 mt-8 md:mb-8 md:mt-10">
        <h1 class="text-lg md:text-2xl">
            <span class="border-b border-red-500">
                فرد متخصص رو نسبت به تگ های انتخابی خودت انتخاب کن 🏷️
            </span>
        </h1>
    </div>
    <livewire:service.tags.index />
@endsection
