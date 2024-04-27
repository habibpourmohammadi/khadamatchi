<div>
    <div class="text-right mb-5 mt-8 md:mb-8 md:mt-10">
        <span class="text-lg">
            <span class="border-b border-blue-500">
                متخصصین وبسایت خدمات چی 🔨
            </span>
        </span>
    </div>
    <div class="flex flex-row flex-wrap justify-center">
        @forelse ($this->services as $service)
            <div
                class="max-w-sm mx-2 my-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="#">
                    <img class="rounded-t-lg"
                        src="https://fastly.picsum.photos/id/0/5000/3333.jpg?hmac=_j6ghY5fCfSD6tvtcV74zXivkJSPIfR9B8w34XeQmvU"
                        alt="" />
                </a>
                <div class="p-5">
                    <a href="">
                        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $service->title }}
                        </h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        <span class="block">
                            نام و نام خانوادگی : {{ $service->user->full_name }}
                        </span>
                        <span class="block">
                            سابقه کاری : {{ $service->work_experience }}
                        </span>
                        <span class="block">
                            استان : {{ $service->province->name ?? '-' }}
                        </span>
                        <span class="block">
                            شهر : {{ $service->city->name ?? '-' }}
                        </span>
                        <span class="block">
                            دسته بندی : {{ $service->category->name ?? '-' }}
                        </span>
                    </p>
                    <a href="#"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        نمایش اطلاعات بیشتر
                    </a>
                </div>
            </div>
        @empty
            <div class="flex items-center justify-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 w-full"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">مشکلی پیش آمده !</span> متخصصی پیدا نشد 😔
                </div>
            </div>
        @endforelse
    </div>
    <div dir="ltr">
        {{ $this->services->links('livewire::simple-tailwind') }}
    </div>
</div>
