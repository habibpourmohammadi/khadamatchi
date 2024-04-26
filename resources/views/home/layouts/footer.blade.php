<footer class="bg-gray-100 rounded-lg shadow dark:bg-gray-900 mt-4 mx-2">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="{{ route('home.index') }}" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('home-assets/icon/logo-red.png') }}" class="h-8" alt="khadamatchi" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">خدمات چی</span>
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                <li>
                    <a href="{{ route('home.index') }}" class="hover:underline me-4 md:me-6">خانه</a>
                </li>
                <li>
                    <a href="{{ route('home.contact-us.page') }}" class="hover:underline me-4 md:me-6">ارتباط با ما</a>
                </li>
                <li>
                    <a href="{{ route('home.faqPage.page') }}" class="hover:underline me-4 md:me-6">سوالات متداول</a>
                </li>
                <li>
                    @auth
                        <a href="{{ route('home.my-profile.page') }}" class="hover:underline">
                            حساب کاربری
                        </a>
                    @endauth
                    @guest
                        <a href="{{ route('home.login.page') }}" class="hover:underline">

                            ورود به حساب کاربری
                        </a>
                    @endguest
                    </a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">
            تمام حقوق برای تیم
            <a href="{{ route('home.index') }}" class="hover:underline text-red-700 font-bold">خدمات چی </a>
            محفوظ است - 1403
        </span>
    </div>
</footer>
