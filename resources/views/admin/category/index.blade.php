@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - دسته بندی ها</title>
@endsection
@section('content')
    <section class="mb-2 d-flex justify-content-between align-items-center mt-4 mb-4">
        <h2 class="h4">دسته بندی ها</h2>
        <form action="{{ route('admin.category.index') }}" method="GET" class="w-25 d-flex">
            <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="جستجو ....">
        </form>
        <a href="{{ route('admin.category.create') }}" class="btn btn-sm btn-success">
            ایجاد دسته بندی
        </a>
    </section>
    <section class="table-responsive">
        <table class="table table-striped text-right">
            <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>اسلاگ</th>
                    <th>توضیحات</th>
                    <th>عکس</th>
                    <th>وضعیت</th>
                    <th>تاریخ ایجاد</th>
                    <th>تنظیمات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug ?? '-' }}</td>
                        <td>{{ Str::limit($category->description, 35, '...') }}</td>
                        <td>
                            @if ($category->image_path != null && \File::exists(public_path($category->image_path)))
                                <a href="{{ asset($category->image_path) }}" target="_blank">
                                    <img src="{{ asset($category->image_path) }}" alt="" width="30">
                                </a>
                            @else
                                <small class="text-danger fw-bold">عکس ثبت نشده</small>
                            @endif
                        </td>
                        <th @class([
                            'text-success' => $category->status == 'active',
                            'text-danger' => $category->status == 'deactive',
                        ])>{{ $category->status == 'active' ? 'فعال' : 'غیر فعال' }}
                        </th>
                        <td>{{ jalaliDate($category->created_at) }}</td>
                        <td>
                            <a href="{{ route('admin.category.edit', $category) }}"
                                class="btn btn-primary btn-sm">ویرایش</a>
                            <form action="{{ route('admin.category.changeStatus', $category) }}" class="d-inline"
                                method="POST">
                                @csrf
                                <button class="btn btn-warning btn-sm" type="submit">تغییر وضعیت</button>
                            </form>
                            <form class="d-inline" action="{{ route('admin.category.delete', $category) }}" method="POST">
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
                                    دسته بندی ای ثبت نشده
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
