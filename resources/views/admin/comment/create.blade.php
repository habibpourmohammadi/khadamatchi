@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - ایجاد نظر</title>
@endsection
@section('content')
    <form action="{{ route('admin.comment.store') }}" method="POST" class="text-right mt-5 mx-5">
        @csrf
        <section class="form-group">
            <div class="my-4">
                <label for="user">نظر دهنده</label>
                <select name="user_id" id="user" class="form-control">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->full_name }}</option>
                    @endforeach
                </select>
                @error('user_id')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </section>
        <section class="form-group">
            <div class="my-4">
                <label for="comment">متن نظر</label>
                <textarea name="comment" id="comment" class="form-control" cols="30" rows="8">{{ old('comment') }}</textarea>
                @error('comment')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </section>
        <section class="form-group">
            <button type="submit" class="btn btn-sm btn-primary">افزودن</button>
        </section>
    </form>
@endsection
