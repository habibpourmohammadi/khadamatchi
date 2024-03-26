@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - سوالات متداول</title>
@endsection
@section('content')
    <section class="mb-2 d-flex justify-content-between align-items-center mt-4 mb-4">
        <h2 class="h4">سوالات متداول</h2>
        <form action="{{ route('admin.faq.index') }}" method="GET" class="w-25 d-flex">
            <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="جستجو ....">
        </form>
        <a href="{{ route('admin.faq.create') }}" class="btn btn-sm btn-success">
            ایجاد سوال متداول
        </a>
    </section>
    <section class="table-responsive">
        <table class="table table-striped text-right">
            <thead>
                <tr>
                    <th>#</th>
                    <th>عنوان</th>
                    <th>جواب</th>
                    <th>وضعیت</th>
                    <th>تاریخ ایجاد</th>
                    <th>تنظیمات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($faqs as $faq)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $faq->title }}</td>
                        <td>{{ Str::limit($faq->answer, 120, '...') }}</td>
                        <th @class([
                            'text-success' => $faq->status == 'active',
                            'text-danger' => $faq->status == 'deactive',
                        ])>{{ $faq->status == 'active' ? 'فعال' : 'غیر فعال' }}
                        </th>
                        <td>{{ jalaliDate($faq->created_at) }}</td>
                        <td>
                            <a href="{{ route('admin.faq.edit', $faq) }}"
                                class="btn btn-primary btn-sm">ویرایش</a>
                            <form action="{{ route('admin.faq.changeStatus', $faq) }}" class="d-inline"
                                method="POST">
                                @csrf
                                <button class="btn btn-warning btn-sm" type="submit">تغییر وضعیت</button>
                            </form>
                            <form class="d-inline" action="{{ route('admin.faq.delete', $faq) }}" method="POST">
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
                                    سوال متداولی ثبت نشده
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
