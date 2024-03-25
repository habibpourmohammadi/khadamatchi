@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - خدمت ها</title>
@endsection
@section('content')
    <section class="mb-2 d-flex justify-content-between align-items-center mt-4 mb-2">
        <h2 class="h4">خدمت ها</h2>
        <form action="{{ route('admin.service.index') }}" method="GET" class="w-25 d-flex">
            <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="جستجو ....">
        </form>
    </section>
    <section class="mb-2 d-flex justify-content-between mx-3 mt-3 border-bottom pb-3">
        <section>
            <a href="" class="btn btn-sm btn-info disabled" id="showBtn">نمایش</a>
            <form class="d-inline" action="" method="POST" id="changeStatusForm">
                @csrf
                <button class="btn btn-warning btn-sm disabled" type="submit" id="changeStatusBtn">تغییر وضعیت</button>
            </form>
            <a href="" class="btn btn-sm btn-primary disabled" id="tagsBtn">تگ ها</a>
            <a href="" class="btn btn-sm btn-secondary disabled" id="commentsBtn">نظر ها</a>
        </section>
        <section>
            <form class="d-inline" action="" method="POST" id="deleteForm">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger btn-sm btnDelete disabled" type="submit" id="deleteBtn">حذف</button>
            </form>
        </section>
    </section>
    <section class="table-responsive">
        <table class="table table-striped text-right">
            <thead>
                <tr>
                    <th>#</th>
                    <th>نام و نام خانوادگی</th>
                    <th>دسته بندی</th>
                    <th>استان</th>
                    <th>شهر</th>
                    <th>عنوان</th>
                    <th>اسلاگ</th>
                    <th>عکس</th>
                    <th>تجربه کاری</th>
                    <th>تعداد نظر ها</th>
                    <th>وضعیت</th>
                    <th>تاریخ ایجاد</th>
                    <th class="text-center">تنظیمات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('admin.user.index', ['search' => $service->user->slug]) }}"
                                class="text-decoration-none" target="_blank">
                                {{ $service->user->full_name }}
                            </a>
                        </td>
                        <td>{{ $service->category->name }}</td>
                        <td>{{ $service->province->name }}</td>
                        <td>{{ $service->city->name }}</td>
                        <td>{{ Str::limit($service->title, 35, '...') }}</td>
                        <td>{{ Str::limit($service->slug, 35, '...') ?? '-' }}</td>
                        <th>
                            @if (\File::exists(public_path($service->service_image_path)))
                                <a href="{{ asset($service->service_image_path) }}" target="_blank">
                                    <img src="{{ asset($service->service_image_path) }}" alt="عکس پیدا نشد">
                                </a>
                            @else
                                <span class="text-danger">عکس پیدا نشد</span>
                            @endif
                        </th>
                        <td>{{ $service->work_experience }}</td>
                        <td>{{ $service->comments->count() }} عدد</td>
                        <th @class([
                            'text-success' => $service->status == 'active',
                            'text-danger' => $service->status == 'deactive',
                        ])>{{ $service->status == 'active' ? 'فعال' : 'غیر فعال' }}
                        </th>
                        <td>{{ jalaliDate($service->created_at) }}</td>
                        <td class="text-center">
                            <input type="radio" class="radioInput" name="service" data-service-id="{{ $service->id }}">
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="22">
                            <div class="alert alert-danger text-center" role="alert">
                                @if (request()->search)
                                    موردی یافت نشد
                                @else
                                    خدمتی ثبت نشده
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
@section('script-tag')
    <script>
        $(document).ready(function() {
            let radioInput = $(".radioInput");
            let deleteUrl = "service/delete/";
            let showUrl = "service/show/";
            let changeStatusUrl = "service/change-status/";
            let tagsUrl = "service/tags/";
            let commentsUrl = "service/comment/";

            radioInput.change(function(e) {
                let service_id = $(this).data("service-id");

                $("#showBtn").attr("href", showUrl + service_id);
                $("#showBtn").removeClass("disabled");

                $("#tagsBtn").attr("href", tagsUrl + service_id);
                $("#tagsBtn").removeClass("disabled");

                $("#commentsBtn").attr("href", commentsUrl + service_id);
                $("#commentsBtn").removeClass("disabled");

                $("#deleteForm").attr("action", deleteUrl + service_id);
                $("#deleteBtn").removeClass("disabled");

                $("#changeStatusForm").attr("action", changeStatusUrl + service_id);
                $("#changeStatusBtn").removeClass("disabled");
            });
        });
    </script>
@endsection
