@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - نمایش خدمت</title>
@endsection
@section('content')
    <div class="card my-5 mx-4">
        @if (\File::exists(public_path($service->service_image_path)))
            <img src="{{ asset($service->service_image_path) }}" class="card-img-top" alt="عکس پیدا نشد">
        @endif
        <div class="card-body">
            <h5 class="card-title">عنوان : {{ $service->title }}</h5>
            <h5 class="card-title">اسلاگ : {{ $service->slug }}</h5>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">نام و نام خانوادگی : {{ $service->user->full_name }}</li>
            <li class="list-group-item">دسته بندی : {{ $service->category->name }}</li>
            <li class="list-group-item">استان : {{ $service->province->name }}</li>
            <li class="list-group-item">شهر : {{ $service->city->name }}</li>
            <li class="list-group-item"> تجربه کاری : {{ $service->work_experience }}</li>
            <li class="list-group-item"> وضعیت :
                <strong @class([
                    'text-success' => $service->status == 'active',
                    'text-danger' => $service->status == 'deactive',
                ])>
                    {{ $service->status == 'active' ? 'فعال' : 'غیر فعال' }}
                </strong>
            </li>
            <li class="list-group-item">توضیحات : {{ $service->description }}</li>
        </ul>
    </div>
@endsection
