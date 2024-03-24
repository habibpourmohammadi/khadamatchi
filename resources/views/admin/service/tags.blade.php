@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - نمایش تگ های خدمت</title>
@endsection
@section('content')
    <div class="my-5 mx-5">
        <ul class="list-group w-50  m-auto">
            <li class="list-group-item active">لیست تگ ها : </li>
            @forelse ($tags as $tag)
                <a href="{{ route('admin.tag.index', ['search' => $tag->name]) }}" class="text-decoration-none">
                    <li class="list-group-item">{{ $tag->name }}</li>
                </a>
            @empty
                <li class="list-group-item text-center text-danger fw-bold">هیچ تگی برای این خدمت ثبت نشده است</li>
            @endforelse
        </ul>
    </div>
@endsection
