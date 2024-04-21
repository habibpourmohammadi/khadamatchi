<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.layouts.head-tag')
    @yield('head-tag')
</head>

<body dir="rtl">
    @include('home.layouts.header')
    <main class="container m-auto">
        @yield('content')
    </main>
    @include('home.layouts.footer')
    @include('home.layouts.script-tag')
    @yield('script')
</body>

</html>
