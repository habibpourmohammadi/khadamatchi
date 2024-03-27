@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - نمایش پیام</title>
@endsection
@section('content')
    <div class="card my-4 mx-5">
        <div class="card-header">
            عنوان : {{ $message->title }}
        </div>
        <div class="card-body">
            <p class="card-text">متن پیام : {{ $message->message }}</p>
        </div>
    </div>
@endsection
