@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - کاربران</title>
@endsection
@section('content')
    <section class="mb-2 d-flex justify-content-between align-items-center mt-4 mb-2">
        <h2 class="h4">کاربران</h2>
        <form action="{{ route('admin.user.index') }}" method="GET" class="w-25 d-flex">
            <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="جستجو ....">
            <input type="text" name="sort" value="{{ request()->sort }}" class="d-none">
            <button type="submit" class="d-none"></button>
        </form>
    </section>
    <section class="mb-2 d-flex justify-content-between mx-3 mt-3 border-bottom pb-3">
        <section>
            <a href="" class="btn btn-sm btn-primary disabled" id="servicesBtn">خدمت ها</a>
            <a href="" class="btn btn-sm btn-secondary disabled" id="commentsBtn">نظر ها</a>
        </section>
        <section>
            <form class="d-inline" action="" method="POST" id="changeStatusForm">
                @csrf
                <button class="btn btn-warning btn-sm disabled" type="submit" id="changeStatusBtn">تغییر وضعیت</button>
            </form>
        </section>
    </section>
    <section class="table-responsive">
        <table class="table table-striped text-right">
            <thead>
                <tr>
                    <th>#</th>
                    <th>نام و نام خانوادگی</th>
                    <th>اسلاگ</th>
                    <th>استان</th>
                    <th>شهر</th>
                    <th>ایمیل</th>
                    <th>شماره</th>
                    <th>پروفایل</th>
                    <th>جنسیت</th>
                    <th>تعداد خدمت ها</th>
                    <th>تعداد نظر ها</th>
                    <th>وضعیت</th>
                    <th>تاریخ تایید اکانت</th>
                    <th>
                        @if (!isset(request()->sort) || request()->sort == 'ASC')
                            <a href="{{ route('admin.user.index', ['search' => request()->search, 'sort' => 'DESC']) }}"
                                class="text-decoration-none">تاریخ ایجاد اکانت <i class="fa fa-sort"></i></a>
                        @else
                            <a href="{{ route('admin.user.index', ['search' => request()->search, 'sort' => 'ASC']) }}"
                                class="text-decoration-none">تاریخ ایجاد اکانت <i class="fa fa-sort"></i></a>
                        @endif
                    </th>
                    <th class="text-center">تنظیمات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ Str::limit($user->slug, 35, '...') ?? '-' }}</td>
                        <td>{{ $user->province->name }}</td>
                        <td>{{ $user->city->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td @class([
                            'text-danger' => $user->mobile == null,
                            'fw-bold' => $user->mobile == null,
                        ])>{{ $user->mobile ?? 'ثبت نشده' }}</td>
                        <th>
                            @if (isset($user->profile_path) && \File::exists(public_path($user->profile_path)))
                                <a href="{{ asset($user->profile_path) }}" target="_blank">
                                    <img src="{{ asset($user->profile_path) }}" alt="پروفایل پیدا نشد">
                                </a>
                            @else
                                <span class="text-danger">پروفایل پیدا نشد</span>
                            @endif
                        </th>
                        <td>{{ $user->user_gender }}</td>
                        <td>{{ $user->services->count() }} عدد</td>
                        <td>{{ $user->comments->count() }} عدد</td>
                        <th @class([
                            'text-success' => $user->status == 'active',
                            'text-danger' => $user->status == 'ban',
                        ])>{{ $user->status == 'active' ? 'فعال' : 'بن' }}
                        </th>
                        <td @class([
                            'text-danger' => $user->account_verified_at == null,
                            'fw-bold' => $user->account_verified_at == null,
                        ])>
                            {{ $user->account_verified_at != null ? jalaliDate($user->account_verified_at) : 'هنوز تایید نشده' }}
                        </td>
                        <td>{{ jalaliDate($user->created_at) }}</td>
                        <td class="text-center">
                            <input type="radio" class="radioInput" name="user" data-user-slug="{{ $user->slug }}">
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="22">
                            <div class="alert alert-danger text-center" role="alert">
                                @if (request()->search)
                                    موردی یافت نشد
                                @else
                                    کاربری ثبت نشده
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
            let changeStatusUrl = "user/change-status/";
            let servicesUrl = "service?search=";
            let commentsUrl = "user/comments/";

            radioInput.change(function(e) {
                let user_slug = $(this).data("user-slug");

                $("#servicesBtn").attr("href", servicesUrl + user_slug);
                $("#servicesBtn").removeClass("disabled");

                $("#commentsBtn").attr("href", commentsUrl + user_slug);
                $("#commentsBtn").removeClass("disabled");

                $("#changeStatusForm").attr("action", changeStatusUrl + user_slug);
                $("#changeStatusBtn").removeClass("disabled");
            });
        });
    </script>
@endsection
