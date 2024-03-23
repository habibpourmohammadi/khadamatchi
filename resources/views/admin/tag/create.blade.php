@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - ایجاد تگ</title>
@endsection
@section('content')
    <form action="{{ route('admin.tag.store') }}" method="POST" class="text-right mt-5 mx-5">
        @csrf
        <section class="form-group">
            <div class="my-4">
                <label for="name">نام تگ</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                @error('name')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </section>
        <section class="form-group">
            <button type="submit" class="btn btn-sm btn-primary">افزودن</button>
        </section>
    </form>
@endsection
