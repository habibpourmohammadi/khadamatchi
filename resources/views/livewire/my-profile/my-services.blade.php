<div>
    <div class="mx-8">
        @include('home.alert.error')
        @include('home.alert.success')
    </div>
    <div class="flex flex-row flex-wrap justify-center">
        @forelse ($this->services as $service)
            <div wire:key="service-slug-{{ $service->slug }}"
                class="max-w-sm mx-2 my-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="max-w-56 max-h-56 m-auto">
                    @if ($service->service_image_path)
                        <a href="{{ route('home.services.show', $service) }}">
                            <img class="rounded-t-lg" src="{{ asset($service->service_image_path) }}" alt="" />
                        </a>
                    @else
                        <span class="block text-center text-red-700 font-bold bg-gray-100 py-2 rounded-lg">
                            عکس ندارد
                        </span>
                    @endif
                </div>
                <div class="p-5">
                    <a href="{{ route('home.services.show', $service) }}">
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
                    <div class="flex flex-row justify-between border-t-2 pt-3">
                        <a href="{{ route('home.services.show', $service) }}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            نمایش
                        </a>
                        <button wire:click="setEditValue({{ $service->id }})"
                            class="inline-flex items-center ms-1 px-3 py-2 text-sm font-medium text-center text-white bg-teal-700 rounded-lg hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-300 dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800">
                            ویرایش
                        </button>
                        <button type="button" wire:click="delete({{ $service->id }})"
                            wire:confirm="آیا از حذف کردن این سرویس مطمعنید ؟ "
                            class="inline-flex items-center ms-1 px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            حذف
                        </button>
                    </div>
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
                    <span class="font-medium">
                        لیست سرویس های شما خالی است !
                    </span>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Main modal -->
    <div x-cloak x-data="{ show: false }" x-show="show" x-on:open-modal.window="show = true"
        x-on:close-modal.window="show = false" x-transition tabindex="-1" aria-hidden="true"
        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        ویرایش سرویس : {{ $editService->title ?? '-' }}
                    </h3>
                    <button x-on:click="show = false" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form wire:submit="updateService" class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                عنوان تخصص
                                <span class="text-red-700 font-bold">*</span>
                            </label>
                            <input type="text" id="title" wire:model="editTitle"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="تعمیرات یخچال ...">
                            @error('editTitle')
                                <small class="text-red-700 font-bold">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                استان شما
                                <span class="text-red-700 font-bold">*</span>
                            </label>
                            <select id="province" wire:model="editProvince" wire:change="setCity"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="">استان را انتخاب کنید</option>
                                @foreach ($provinces as $province)
                                    <option wire:key="province-slug-{{ $province->slug }}" value="{{ $province->slug }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                            @error('editProvince')
                                <small class="text-red-700 font-bold">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                شهر شما
                                <span class="text-red-700 font-bold">*</span>
                            </label>
                            <select id="city" wire:model="editCity"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="">شهر را انتخاب کنید</option>
                                @foreach ($cities as $city)
                                    <option wire:key="city-slug-{{ $city->slug }}" @selected($city->slug == $editCity)
                                        value="{{ $city->slug }}">
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('editCity')
                                <small class="text-red-700 font-bold">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                دسته بندی تخصص شما
                                <span class="text-red-700 font-bold">*</span>
                            </label>
                            <select id="category" wire:model="editCategory"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="">دسته بندی را انتخاب کنید</option>
                                @foreach ($categories as $category)
                                    <option wire:key="category-slug-{{ $category->slug }}" value="{{ $category->slug }}">
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('editCategory')
                                <small class="text-red-700 font-bold">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="service_image"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                عکس سرویس شما
                            </label>
                            <input accept="image/png, image/jpeg, image/jpg" type="file" id="service_image"
                                wire:model="editServiceImage"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @error('editServiceImage')
                                <small class="text-red-700 font-bold">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="workExperienceUnit"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                واحد مدت تجربه کاری
                                <span class="text-red-700 font-bold">*</span>
                            </label>
                            <select wire:model.live.debounce="editWorkExperienceUnit" id="workExperienceUnit"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="">واحد مدت تجربه کاری را انتخاب کنید</option>
                                <option value="month">ماه</option>
                                <option value="year">سال</option>
                            </select>
                            @error('editWorkExperienceUnit')
                                <small class="text-red-700 font-bold">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="workExperienceDuration"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                مدت تجربه کاری
                                <span class="text-red-700 font-bold">*</span>
                            </label>
                            <select wire:model="editWorkExperienceDuration" id="workExperienceDuration"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="">مدت تجربه کاری را انتخاب کنید</option>
                                @for ($i = 1; $i <= 40; $i++)
                                    <option value="{{ $i }}">{{ $i }} @if ($editWorkExperienceUnit == 'year')
                                            سال
                                        @elseif ($editWorkExperienceUnit == 'month')
                                            ماه
                                        @endif
                                    </option>
                                @endfor
                            </select>
                            @error('editWorkExperienceDuration')
                                <small class="text-red-700 font-bold">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-span-2">
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                توضیحات تخصص شما
                                <span class="text-red-700 font-bold">*</span>
                            </label>
                            <textarea id="description" rows="4" wire:model="editDescription"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Write product description here"></textarea>
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        ویرایش سرویس
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
