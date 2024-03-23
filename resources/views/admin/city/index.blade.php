@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - شهر ها</title>
@endsection
@section('content')
    <section class="mb-2 d-flex justify-content-between align-items-center mt-4 mb-4">
        <h2 class="h4">شهر ها</h2>
        <form action="{{ route('admin.city.index') }}" method="GET" class="w-25 d-flex">
            <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="جستجو ....">
            <input type="text" name="sort" value="{{ request()->sort }}" class="d-none">
            <button type="submit" class="d-none"></button>
        </form>
        <a href="{{ route('admin.city.create') }}" class="btn btn-sm btn-success">
            ایجاد شهر
        </a>
    </section>
    <section class="table-responsive">
        <table class="table table-striped text-right">
            <thead>
                <tr>
                    <th>#</th>
                    <th>نام شهر</th>
                    <th>
                        @if (request()->sort == null || request()->sort == 'DESC')
                            <a href="{{ route('admin.city.index', ['search' => request()->search, 'sort' => 'ASC']) }}"
                                class="text-decoration-none">نام استان <i class="fa fa-sort"></i></a>
                        @else
                            <a href="{{ route('admin.city.index', ['search' => request()->search, 'sort' => 'DESC']) }}"
                                class="text-decoration-none">نام استان <i class="fa fa-sort"></i></a>
                        @endif
                    </th>
                    <th>اسلاگ</th>
                    <th>وضعیت</th>
                    <th>تاریخ ایجاد</th>
                    <th>تنظیمات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cities as $city)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $city->name }}</td>
                        <td>{{ $city->province->name }}</td>
                        <td>{{ $city->slug ?? '-' }}</td>
                        <th @class([
                            'text-success' => $city->status == 'active',
                            'text-danger' => $city->status == 'deactive',
                        ])>{{ $city->status == 'active' ? 'فعال' : 'غیر فعال' }}
                        </th>
                        <td>{{ jalaliDate($city->created_at) }}</td>
                        <td>
                            <a href="{{ route('admin.city.edit', $city) }}" class="btn btn-primary btn-sm">ویرایش</a>
                            <form action="{{ route('admin.city.changeStatus', $city) }}" class="d-inline" method="POST">
                                @csrf
                                <button class="btn btn-warning btn-sm" type="submit">تغییر وضعیت</button>
                            </form>
                            <form class="d-inline" action="{{ route('admin.city.delete', $city) }}" method="POST">
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
                                    شهری ثبت نشده
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
