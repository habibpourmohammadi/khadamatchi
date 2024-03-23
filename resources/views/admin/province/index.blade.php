@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - استان ها</title>
@endsection
@section('content')
    <section class="mb-2 d-flex justify-content-between align-items-center mt-4 mb-4">
        <h2 class="h4">استان ها</h2>
        <form action="{{ route('admin.province.index') }}" method="GET" class="w-25 d-flex">
            <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="جستجو ....">
        </form>
        <a href="{{ route('admin.province.create') }}" class="btn btn-sm btn-success">
            ایجاد استان
        </a>
    </section>
    <section class="table-responsive">
        <table class="table table-striped text-right">
            <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>اسلاگ</th>
                    <th>وضعیت</th>
                    <th>تاریخ ایجاد</th>
                    <th>تنظیمات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($provinces as $province)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $province->name }}</td>
                        <td>{{ $province->slug ?? '-' }}</td>
                        <th @class([
                            'text-success' => $province->status == 'active',
                            'text-danger' => $province->status == 'deactive',
                        ])>{{ $province->status == 'active' ? 'فعال' : 'غیر فعال' }}
                        </th>
                        <td>{{ jalaliDate($province->created_at) }}</td>
                        <td>
                            <a href="{{ route('admin.province.edit', $province) }}"
                                class="btn btn-primary btn-sm">ویرایش</a>
                            <form action="{{ route('admin.province.changeStatus', $province) }}" class="d-inline"
                                method="POST">
                                @csrf
                                <button class="btn btn-warning btn-sm" type="submit">تغییر وضعیت</button>
                            </form>
                            <form class="d-inline" action="{{ route('admin.province.delete', $province) }}" method="POST">
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
                                    استانی ثبت نشده
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
