<div class="bg-gray-50 shadow-lg md:w-2/6 xl:w-1/6 rounded-lg">
    <a href="{{ route('home.my-profile.page') }}"
        class="my-4 block hover:bg-gray-200 rounded-lg py-2 px-2 mx-1 hover:cursor-pointer hover:text-blue-700 transition-all">
        <span>حساب کاربری من</span>
    </a>
    @if (auth()->user()->services()->count() > 0)
        <a href="{{ route('home.my-services.page') }}"
            class="my-2 block hover:bg-gray-200 rounded-lg py-2 px-2 mx-1 hover:cursor-pointer hover:text-blue-700 transition-all">
            <span>سرویس های من</span>
        </a>
    @endif
    <a href=""
        class="my-2 block hover:bg-gray-200 rounded-lg py-2 px-2 mx-1 hover:cursor-pointer hover:text-blue-700 transition-all">
        <span>لیست علاقه مندی های من</span>
    </a>
</div>
