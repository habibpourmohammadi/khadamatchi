@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - نظر ها</title>
@endsection
@section('content')
    <section class="mb-2 d-flex justify-content-between align-items-center mt-4 mb-2">
        <h2 class="h4">نظر ها</h2>
        <form action="{{ route('admin.user.comments.show', $user) }}" method="GET" class="w-25 d-flex">
            <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="جستجو ....">
        </form>
    </section>
    <section class="border-bottom pb-3">
        <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-warning">بازگشت</a>
    </section>
    <section class="table-responsive">
        <table class="table table-striped text-right">
            <thead>
                <tr>
                    <th>#</th>
                    <th>نام و نام خانوادگی نظر دهنده</th>
                    <th>عنوان خدمت</th>
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
                        <td>
                            <a class="text-decoration-none" target="_blank"
                                href="{{ route('admin.service.index', ['search' => $comment->service->slug]) }}">
                                {{ Str::limit($comment->service->title, 35, '...') }}
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
                            <a href="{{ route('admin.service.comment.show', ['service' => $comment->service, 'comment' => $comment]) }}"
                                class="btn btn-sm btn-info">نمایش</a>
                            <form
                                action="{{ route('admin.service.comment.changeStatus', ['service' => $comment->service, 'comment' => $comment]) }}"
                                class="d-inline" method="POST">
                                @csrf
                                <button class="btn btn-warning btn-sm" type="submit">تغییر وضعیت</button>
                            </form>
                            <form class="d-inline"
                                action="{{ route('admin.service.comment.delete', ['service' => $comment->service, 'comment' => $comment]) }}"
                                method="POST">
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
