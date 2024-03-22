<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('admin.layouts.head-tag')
    @yield('head-tag')
</head>

<body dir="rtl">
    <section id="app">
        @include('admin.layouts.top-nav')
        <section class="container-fluid">
            <section class="row row-cols-2">
                <section class="col-md-2 p-0">
                    @include('admin.layouts.sidebar')
                </section>
                <section class="col-md-10 pb-3">
                    @yield('content')
                </section>
            </section>
        </section>
    </section>

    @include('admin.layouts.script-tag')

    {{-- sweetalert - start --}}

    @include('admin.sweetalert.success')
    @include('admin.sweetalert.error')
    @include('admin.sweetalert.delete')

    {{-- sweetalert - end --}}

    @yield('script-tag')
</body>

</html>
