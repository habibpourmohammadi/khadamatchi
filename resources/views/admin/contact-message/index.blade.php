@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - پیام ها</title>
@endsection
@section('content')
    <section class="mb-2 d-flex justify-content-between align-items-center mt-4 mb-4">
        <h2 class="h4">پیام ها</h2>
        <form action="{{ route('admin.contactMessage.index') }}" method="GET" class="w-25 d-flex">
            <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="جستجو ....">
        </form>
    </section>
    <section class="table-responsive">
        <table class="table table-striped text-right">
            <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>عنوان</th>
                    <th>متن پیام</th>
                    <th>وضعیت دیده شدن</th>
                    <th>تاریخ ایجاد</th>
                    <th>تنظیمات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contactMessages as $contactMessage)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('admin.user.index', ['search' => $contactMessage->user->slug]) }}" class="text-decoration-none" target="_blank">
                                {{ $contactMessage->user->full_name }}
                            </a>
                        </td>
                        <td>{{ Str::limit($contactMessage->title, 35, '...') }}</td>
                        <td>{{ Str::limit($contactMessage->message, 35, '...') }}</td>
                        <th @class([
                            'text-success' => $contactMessage->seen == 'true',
                            'text-danger' => $contactMessage->seen == 'false',
                        ])>{{ $contactMessage->seen == 'true' ? 'دیده شده' : 'دیده نشده' }}
                        </th>
                        <td>{{ jalaliDate($contactMessage->created_at) }}</td>
                        <td>
                            <a href="{{ route("admin.contactMessage.show",$contactMessage) }}" class="btn btn-sm btn-info">نمایش</a>
                            <form action="{{ route('admin.contactMessage.changeSeenStatus', $contactMessage) }}"
                                class="d-inline" method="POST">
                                @csrf
                                <button class="btn btn-warning btn-sm" type="submit">تغییر وضعیت دیده شدن</button>
                            </form>
                            <form class="d-inline" action="{{ route('admin.contactMessage.delete', $contactMessage) }}"
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
                                    پیامی ثبت نشده
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
