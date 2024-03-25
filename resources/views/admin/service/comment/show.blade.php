@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - نمایش خدمت</title>
@endsection
@section('content')
    <div class="my-5 mx-5">
        <a href="{{ route('admin.service.comment.index', $service) }}" class="btn btn-sm btn-warning mb-3">بازگشت</a>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">عنوان خدمت :
                    <a class="text-decoration-none" target="_blank"
                        href="{{ route('admin.service.index', ['search' => $comment->service->slug]) }}">
                        {{ $comment->service->title }}
                    </a>
                </h5>
                <h5 class="card-title">نام و نام خانوادگی نظر دهنده :
                    <a class="text-decoration-none" target="_blank"
                        href="{{ route('admin.user.index', ['search' => $comment->user->slug]) }}">
                        {{ $comment->user->full_name }}
                    </a>
                </h5>
                <div class="border-bottom my-3"></div>
                <p class="card-text">متن نظر : {{ $comment->comment }}</p>
            </div>
        </div>
    </div>
@endsection
