@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - عکس ها</title>
@endsection
@section('content')
    <section class="mb-2 d-flex justify-content-between align-items-center mt-4 mb-2">
        <h2 class="h4">عکس ها</h2>
        <form action="{{ route('admin.service.image.index', $service) }}" method="GET" class="w-25 d-flex">
            <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="جستجو ....">
        </form>
    </section>
    <section class="border-bottom pb-3">
        <a href="{{ route('admin.service.index') }}" class="btn btn-sm btn-warning">بازگشت</a>
    </section>
    <section class="table-responsive">
        <table class="table table-striped text-right">
            <thead>
                <tr>
                    <th>#</th>
                    <th>عنوان خدمت</th>
                    <th>عکس</th>
                    <th>سایز</th>
                    <th>نوع</th>
                    <th>وضعیت</th>
                    <th>تاریخ ایجاد</th>
                    <th>تنظیمات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($images as $image)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a class="text-decoration-none" target="_blank"
                                href="{{ route('admin.service.index', ['search' => $image->service->slug]) }}">
                                {{ Str::limit($image->service->title, 35, '...') }}
                            </a>
                        </td>
                        <td>
                            @if (\File::exists(public_path($image->image_path)))
                                <a href="{{ asset($image->image_path) }}" target="_blank">
                                    <img src="{{ asset($image->image_path) }}" alt="عکس پیدا نشد">
                                </a>
                            @else
                                <span class="text-danger fw-bold">عکس پیدا نشد</span>
                            @endif
                        </td>
                        <td>{{ $image->image_size }}</td>
                        <td>{{ $image->image_type }}</td>
                        <th @class([
                            'text-success' => $image->status == 'active',
                            'text-danger' => $image->status == 'deactive',
                        ])>{{ $image->status == 'active' ? 'فعال' : 'غیر فعال' }}
                        </th>
                        <td>{{ jalaliDate($image->created_at) }}</td>
                        <td>
                            <form
                                action="{{ route('admin.service.image.changeStatus', ['service' => $service, 'image' => $image]) }}"
                                class="d-inline" method="POST">
                                @csrf
                                <button class="btn btn-warning btn-sm" type="submit">تغییر وضعیت</button>
                            </form>
                            <form class="d-inline"
                                action="{{ route('admin.service.image.delete', ['service' => $service, 'image' => $image]) }}"
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
                                    عکسی ثبت نشده
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
