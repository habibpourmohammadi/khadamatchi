@if (session('success-alert'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
        <p class="font-bold">عملیات با موفقیت انجام شد</p>
        <p>
            {{ session('success-alert') }}
        </p>
    </div>
@endif
