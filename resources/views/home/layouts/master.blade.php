<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.layouts.head-tag')
    @yield('head-tag')
</head>

<body dir="rtl">
    @include('home.layouts.header')
    @yield('content')

    @include('home.layouts.script-tag')
    @yield('script')
</body>

</html>
