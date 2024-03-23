@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - ویرایش دسته بندی</title>
@endsection
@section('content')
    <form action="{{ route('admin.category.update', $category) }}" method="POST" class="text-right mt-5 mx-5">
        @csrf
        @method('PUT')
        <section class="form-group">
            <div class="my-4">
                <label for="name">نام دسته بندی</label>
                <input type="text" class="form-control" name="name" id="name"
                    value="{{ old('name', $category->name) }}">
                @error('name')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="my-4">
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
