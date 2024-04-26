@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - نظر ها</title>
@endsection
@section('content')
    <section class="mb-4 d-flex justify-content-between align-items-center mt-4">
        <h2 class="h4">نظر ها</h2>
        <form action="{{ route('admin.comment.index') }}" method="GET" class="w-25 d-flex">
            <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="جستجو ....">
        </form>
        <a href="{{ route('admin.comment.create') }}" class="btn btn-sm btn-success">
            ایجاد نظر
        </a>
    </section>
    <section class="table-responsive">
        <table class="table table-striped text-right">
            <thead>
                <tr>
                    <th>#</th>
                    <th>نام و نام خانوادگی نظر دهنده</th>
                    <th>متن نظر</th>
                    <th>وضعیت</th>
                    <th>تاریخ ایجاد</th>
                    <th>تنظیمات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($comments as $comment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a class="text-decoration-none" target="_blank"
                                href="{{ route('admin.user.index', ['search' => $comment->user->slug]) }}">
                                {{ $comment->user->full_name }}
                            </a>
                        </td>
                        <td>{{ Str::limit($comment->comment, 50, '...') }}</td>
                        <th @class([
                            'text-success' => $comment->status == 'active',
                            'text-danger' => $comment->status == 'deactive',
                        ])>{{ $comment->status == 'active' ? 'فعال' : 'غیر فعال' }}
                        </th>
                        <td>{{ jalaliDate($comment->created_at) }}</td>
                        <td>
                            <a href="{{ route('admin.comment.edit', $comment) }}" class="btn btn-sm btn-primary">
                                ویرایش
                            </a>
                            <form action="{{ route('admin.comment.change-status', $comment) }}" class="d-inline"
                                method="POST">
                                @csrf
                                <button class="btn btn-warning btn-sm" type="submit">تغییر وضعیت</button>
                            </form>
                            <form class="d-inline" action="{{ route('admin.comment.delete', $comment) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger btn-sm btnDelete" type="submit">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="22">
                            <div class="alert alert-danger text-center" role="alert">
                                @if (request()->search)
                                    موردی یافت نشد
                                @else
                                    نظری ثبت نشده
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
