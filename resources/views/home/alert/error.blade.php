@if (session('error-alert'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
        <p class="font-bold">مشکلی پیش آمده !</p>
        <p>
            {{ session('error-alert') }}
        </p>
    </div>
@endif
