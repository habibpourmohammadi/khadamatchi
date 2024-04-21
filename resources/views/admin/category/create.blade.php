@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - ایجاد دسته بندی</title>
@endsection
@section('content')
    <form action="{{ route('admin.category.store') }}" method="POST" class="text-right mt-5 mx-5" enctype="multipart/form-data">
        @csrf
        <section class="form-group row">
            <div class="my-4 col-md-6">
                <label for="name">نام دسته بندی</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                @error('name')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="my-4 col-md-6">
                <label for="image">عکس دسته بندی</label>
                <input type="file" class="form-control" name="image_path" id="image">
                @error('image_path')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="my-4 col-md-12">
                <label for="description">توضیحات</label>
                <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </section>
        <section class="form-group">
            <button type="submit" class="btn btn-sm btn-primary">افزودن</button>
        </section>
    </form>
@endsection
