<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/bootstrap.min.css') }}">
    <title>ورود به پنل ادمین</title>
</head>

<body dir="rtl">
    <main class="container">
        <form action="{{ route('admin.login') }}" method="POST"
            class="bg-dark mt-5 py-3 rounded px-3 w-50 m-auto">
            @csrf
            <div class="my-3">
                <label for="email" class="text-light fw-bold pb-2 pe-1">پست الکترونیکی : </label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old("email") }}">
                @error('email')
                <p class="text-danger fw-bold rounded w-50 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="my-3">
                <label for="password" class="text-light fw-bold pb-2 pe-1">رمز عبور : </label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                    <p class="text-danger fw-bold rounded w-50 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-4 mb-2 text-center">
                <button type="submit" class="btn btn-primary w-50">ورود</button>
            </div>
        </form>
    </main>
</body>

</html>
