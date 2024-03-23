@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - ویرایش استان</title>
@endsection
@section('content')
    <form action="{{ route('admin.province.update', $province) }}" method="POST" class="text-right mt-5 mx-5">
        @csrf
        @method('PUT')
        <section class="form-group">
            <div class="my-4">
                <label for="name">نام استان</label>
                <input type="text" class="form-control" name="name" id="name"
                    value="{{ old('name', $province->name) }}">
                @error('name')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </section>
        <section class="form-group">
            <button type="submit" class="btn btn-sm btn-primary">ویرایش</button>
        </section>
    </form>
@endsection
