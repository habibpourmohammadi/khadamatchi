@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - ادمین ها</title>
@endsection
@section('content')
    <section class="mb-2 d-flex justify-content-between align-items-center mt-4 mb-4">
        <h2 class="h4">ادمین ها</h2>
        <form action="{{ route('admin.admin.index') }}" method="GET" class="w-25 d-flex">
            <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="جستجو ....">
        </form>
        <a href="{{ route('admin.admin.create') }}" class="btn btn-sm btn-success">ایجاد ادمین</a>
    </section>
    <section class="table-responsive">
        <table class="table table-striped text-right">
            <thead>
                <tr>
                    <th>#</th>
                    <th>نام و نام خانوادگی</th>
                    <th>ایمیل</th>
                    <th>شماره</th>
                    <th>تاریخ ایجاد ادمین</th>
                    <th>تنظیمات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($admins as $admin)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a class="text-decoration-none"
                                href="{{ route('admin.user.index', ['search' => $admin->user->slug]) }}"
                                target="_blank">{{ $admin->user->full_name }}</a>
                        </td>
                        <td>{{ $admin->user->email }}</td>
                        <td @class([
                            'text-danger' => $admin->user->mobile == null,
                            'fw-bold' => $admin->user->mobile == null,
                        ])>{{ $admin->user->mobile ?? 'ثبت نشده' }}</td>
                        <td>{{ jalaliDate($admin->created_at) }}</td>
                        <td>
                            <form class="d-inline"
                                action="{{ route('admin.admin.delete', ['admin' => $admin, 'user' => $admin->user]) }}"
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
                                    ادمینی ثبت نشده
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
