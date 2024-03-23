@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - تگ ها</title>
@endsection
@section('content')
    <section class="mb-2 d-flex justify-content-between align-items-center mt-4 mb-4">
        <h2 class="h4">تگ ها</h2>
        <form action="{{ route('admin.tag.index') }}" method="GET" class="w-25 d-flex">
            <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="جستجو ....">
        </form>
        <a href="{{ route('admin.tag.create') }}" class="btn btn-sm btn-success">
            ایجاد تگ
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
                @forelse ($tags as $tag)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tag->name }}</td>
                        <td>{{ $tag->slug ?? '-' }}</td>
                        <th @class([
                            'text-success' => $tag->status == 'active',
                            'text-danger' => $tag->status == 'deactive',
                        ])>{{ $tag->status == 'active' ? 'فعال' : 'غیر فعال' }}
                        </th>
                        <td>{{ jalaliDate($tag->created_at) }}</td>
                        <td>
                            <a href="{{ route('admin.tag.edit', $tag) }}" class="btn btn-primary btn-sm">ویرایش</a>
                            <form action="{{ route('admin.tag.changeStatus', $tag) }}" class="d-inline" method="POST">
                                @csrf
                                <button class="btn btn-warning btn-sm" type="submit">تغییر وضعیت</button>
                            </form>
                            <form class="d-inline" action="{{ route('admin.tag.delete', $tag) }}" method="POST">
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
                                    تگی ثبت نشده
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
