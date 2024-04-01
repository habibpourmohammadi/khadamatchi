<nav class="navbar navbar-expand-lg navbar-dark bg-red">
    <a class="navbar-brand" href="{{ route('admin.index') }}">خدمات چی</a>
    <section class="collapse navbar-collapse" id="navbarSupportedContent"></section>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    </button>
    <form class="d-inline ms-3" action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-warning text-white btn-sm">خروج از حساب</button>
    </form>
</nav>
