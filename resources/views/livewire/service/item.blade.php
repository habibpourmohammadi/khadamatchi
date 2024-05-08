<div class="max-w-sm mx-2 my-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="max-w-56 max-h-56 m-auto">
        <a href="{{ route('home.services.show', $service) }}">
            <img class="rounded-t-lg h-56 m-auto" src="{{ asset($service->service_image_path) }}" alt="{{ $service->title }}" />
        </a>
    </div>
    <div class="p-5">
        <div class="flex flex-row justify-between">
            <a href="{{ route('home.services.show', $service) }}">
                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                    {{ $service->title }}
                </h5>
            </a>
            <span class="hover:cursor-pointer delay-75 transition-all hover:text-zinc-400"
                wire:click="changeBookmark()">
                @if (auth()->user()->hasBookmark($service->id))
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M6.32 2.577a49.255 49.255 0 0 1 11.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 0 1-1.085.67L12 18.089l-7.165 3.583A.75.75 0 0 1 3.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93Z"
                            clip-rule="evenodd" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                    </svg>
                @endif
            </span>
        </div>
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
        <x-inputs.a-button name="نمایش اطلاعات بیشتر" href="{{ route('home.services.show', $service) }}" />
    </div>
</div>
