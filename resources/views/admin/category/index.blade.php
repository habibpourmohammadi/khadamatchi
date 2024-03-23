@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - دسته بندی ها</title>
@endsection
@section('content')
    <section class="mb-2 d-flex justify-content-between align-items-center mt-4 mb-4">
        <h2 class="h4">دسته بندی ها</h2>
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
                        <th @class([
                            'text-success' => $category->status == 'active',
                            'text-danger' => $category->status == 'deactive',
                        ])>{{ $category->status == 'active' ? 'فعال' : 'غیر فعال' }}
                        </th>
                        <td>{{ jalaliDate($category->created_at) }}</td>
                        <td>
                            <a href="{{ route('admin.category.edit', $category) }}" class="btn btn-primary btn-sm">ویرایش</a>
                            <form action="{{ route('admin.category.changeStatus', $category) }}" class="d-inline" method="POST">
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
                                دسته بندی ای ثبت نشده
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
