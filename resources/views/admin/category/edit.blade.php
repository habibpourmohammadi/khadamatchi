@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - ویرایش دسته بندی</title>
@endsection
@section('content')
    <form action="{{ route('admin.category.update', $category) }}" method="POST" class="text-right mt-5 mx-5"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <section class="form-group row">
            <div class="my-4 col-md-6">
                <label for="name">نام دسته بندی</label>
                <input type="text" class="form-control" name="name" id="name"
                    value="{{ old('name', $category->name) }}">
                @error('name')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="my-4 col-md-6">
                <label for="image">عکس دسته بندی</label>
                <input type="file" class="form-control" name="image_path" id="image">
                @if ($category->image_path != null && \File::exists(public_path($category->image_path)))
                    <a href="{{ asset($category->image_path) }}" target="_blank">
                        <img src="{{ asset($category->image_path) }}" alt="" width="80" class="mt-2">
                    </a>
                @else
                    <small class="text-warning fw-bold">عکس ثبت نشده</small>
                @endif
                @error('image_path')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="my-4 col-md-12">
                <label for="description">توضیحات</label>
                <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </section>
        <section class="form-group">
            <button type="submit" class="btn btn-sm btn-primary">ویرایش</button>
        </section>
    </form>
@endsection
