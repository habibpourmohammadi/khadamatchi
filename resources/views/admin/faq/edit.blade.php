@extends('admin.layouts.master')
@section('head-tag')
    <title>پنل ادمین - ویرایش سوال متداول</title>
@endsection
@section('content')
    <form action="{{ route('admin.faq.update', $faq) }}" method="POST" class="text-right mt-5 mx-5">
        @csrf
        @method('PUT')
        <section class="form-group">
            <div class="my-4">
                <label for="title">عنوان سوال متداول</label>
                <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $faq->title) }}">
                @error('title')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </section>
        <section class="form-group">
            <div class="my-4">
                <label for="answer">جواب سوال متداول</label>
                <textarea name="answer" id="answer" class="form-control" cols="30" rows="8">{{ old('answer', $faq->answer) }}</textarea>
                @error('answer')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </section>
        <section class="form-group">
            <button type="submit" class="btn btn-sm btn-primary">ویرایش</button>
        </section>
    </form>
@endsection
