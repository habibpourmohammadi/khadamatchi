@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - ویرایش شهر</title>
@endsection
@section('content')
    <form action="{{ route('admin.city.update', $city) }}" method="POST" class="text-right mt-5 mx-5">
        @csrf
        @method('PUT')
        <section class="form-group">
            <div class="my-4">
                <label for="name">نام شهر</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $city->name) }}">
                @error('name')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </section>
        <section class="form-group">
            <div class="my-4">
                <label for="province">استان</label>
                <select name="province_id" id="province" class="form-control">
                    <option value="">استان را انتخاب کنید</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}" @selected(old('province_id', $city->province_id) == $province->id)>{{ $province->name }}</option>
                    @endforeach
                </select>
                @error('province_id')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </section>
        <section class="form-group">
            <button type="submit" class="btn btn-sm btn-primary">ویرایش</button>
        </section>
    </form>
@endsection
