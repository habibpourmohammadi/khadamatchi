@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - ایجاد ادمین</title>
@endsection
@section('content')
    <form action="{{ route('admin.admin.store') }}" method="POST" class="text-right mt-5 mx-5">
        @csrf
        <section class="form-group row">
            <div class="my-4 col-md-3">
                <label for="first_name">نام</label>
                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}">
                @error('first_name')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="my-4 col-md-3">
                <label for="last_name">نام خانوادگی</label>
                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}">
                @error('last_name')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="my-4 col-md-3">
                <label for="email">پست الکترونیکی</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                @error('email')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="my-4 col-md-3">
                <label for="password">رمز عبور</label>
                <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}">
                @error('password')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div>
                <label for="city_id">شهر</label>
                <select name="city_id" id="city_id" class="form-control">
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" @selected(old('city_id') == $city->id)>{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('city_id')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </section>
        <section class="form-group mt-3">
            <button type="submit" class="btn btn-sm btn-primary">افزودن</button>
        </section>
    </form>
@endsection
