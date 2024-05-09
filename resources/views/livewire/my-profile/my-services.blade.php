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
                            <img class="rounded-t-lg h-56  m-auto" src="{{ asset($service->service_image_path) }}"
                                alt="" />
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
                        <span class="block">
                            وضعیت :
                            <span
                                class="font-bold {{ $service->status == 'deactive' ? 'text-red-700' : 'text-green-700' }}">
                                {{ $service->status == 'active' ? 'فعال' : 'غیر فعال' }}
                            </span>
                        </span>
                    </p>
                    <div class="flex flex-row justify-between items-center border-t-2 pt-3">
                        تنظیمات
                        <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots-{{ $service->slug }}"
                            data-dropdown-placement="bottom-start"
                            class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600"
                            type="button">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                <path
                                    d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                            </svg>
                        </button>
                        <div id="dropdownDots-{{ $service->slug }}"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-2xl w-40 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownMenuIconButton">
                                <li>
                                    <a href="{{ route('home.services.show', $service) }}"
                                        class="block py-1.5 text-sm font-sm text-center text-white bg-blue-700 rounded-t-lg rounded-b-sm hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        نمایش
                                    </a>
                                </li>
                                <li>
                                    <button wire:click="setEditValue({{ $service->id }})"
                                        class="block w-full py-1.5 text-sm font-medium text-center text-white bg-teal-700 my-1 rounded-sm hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-300 dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800">
                                        ویرایش
                                    </button>
                                </li>
                                <li>
                                    <button wire:click="setTags({{ $service->id }})"
                                        class="tagBtn block w-full py-1.5 text-sm font-medium text-center text-white bg-cyan-700 my-1 rounded-sm hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">
                                        تگ ها
                                    </button>
                                </li>
                                <li>
                                    <button wire:click="setImages({{ $service->id }})"
                                        class="tagBtn block w-full py-1.5 text-sm font-medium text-center text-white bg-green-700 my-1 rounded-sm hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        عکس ها
                                    </button>
                                </li>
                                <li>
                                    <button wire:loading.remove type="button" wire:click="delete({{ $service->id }})"
                                        wire:confirm="آیا از حذف کردن این سرویس مطمعنید ؟ "
                                        class="block w-full py-1.5 text-sm font-medium text-center text-white bg-red-700 rounded-b-lg rounded-t-sm hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                        حذف
                                    </button>
                                    <button wire:loading wire:target="delete({{ $service->id }})" disabled
                                        type="button"
                                        class="text-white w-full bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-b-lg rounded-t-sm text-sm py-1.5 text-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 inline-flex items-center">
                                        صبر کنید ...
                                        <svg aria-hidden="true" role="status"
                                            class="inline w-4 h-4 ms-3 text-white animate-spin" viewBox="0 0 100 101"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                fill="#E5E7EB" />
                                            <path
                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                fill="currentColor" />
                                        </svg>
                                    </button>
                                </li>
                            </ul>
                        </div>
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

    <!-- edit modal -->
    <x-modal name="edit">
        <x-slot:title class="font-bold">
            ویرایش سرویس : {{ $editService->title ?? '-' }}
        </x-slot>
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
                            <option wire:key="province-slug-{{ $province->slug }}" value="{{ $province->slug }}">
                                {{ $province->name }}</option>
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
                    <label for="service_image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
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
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        توضیحات تخصص شما
                        <span class="text-red-700 font-bold">*</span>
                    </label>
                    <textarea id="description" rows="4" wire:model="editDescription"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                </div>
            </div>
            <button type="submit"
                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                ویرایش سرویس
            </button>
        </form>
    </x-modal>

    <!-- tags modal -->
    <x-modal name="tag">
        <x-slot:title class="font-bold">
            تگ های سرویس : {{ $editService->title ?? '-' }}
        </x-slot>
        <form wire:submit="updateTags" class="p-4 md:p-5">
            <div class="mb-4">
                <div>
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        تگ های مورد نظر را انتخاب کنید
                    </label>
                    <div wire:ignore>
                        <select multiple wire:model="finalSelectedTags" id="selectedTags"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @foreach ($tags as $tag)
                                <option wire:key="tag-slug-{{ $tag->slug }}" value="{{ $tag->slug }}">
                                    {{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" id="editTags"
                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                ویرایش تگ ها
            </button>
        </form>
    </x-modal>

    <!-- images modal -->
    <x-modal name="images">
        <x-slot:title class="font-bold">
            عکس های سرویس : {{ $editService->title ?? '-' }}
        </x-slot>
        <form wire:submit="addImage" class="p-4 md:p-5">
            <div class="mb-4">
                <div>
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        عکس جدید خود را انتخاب کنید <span class="text-red-700 font-bold">*</span>
                    </label>
                    <input type="file" wire:model="image" id="image"
                        accept="image/jpg , image/jpeg, image/png"
                        class="font-sans bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    @error('image')
                        <small class="text-red-700 font-bold">{{ $message }}</small>
                    @enderror
                    @if (session('upload-success'))
                        <small class="text-green-700 font-bold">{{ session('upload-success') }}</small>
                    @endif
                </div>
                @if ($images)
                    <div class="border-t-2 border-zinc-300 mt-5 pt-3">
                        <small class="border-b-2 border-red-500">عکس های سرویس شما :</small>
                        <div class="mt-2 flex flex-wrap">
                            @foreach ($images as $singleImage)
                                <div class="bg-green-500 p-1 rounded-lg mx-0.5 my-0.5">
                                    <a href="{{ asset($singleImage->image_path) }}" target="_blank">
                                        <img src="{{ asset($singleImage->image_path) }}" alt=""
                                            class="w-20 h-20">
                                    </a>
                                    <button type="button" wire:click="deleteImage({{ $singleImage->id }})"
                                        class="w-full flex bg-red-700 text-zinc-300 rounded-md justify-around px-1 py-0.5 mt-1 hover:bg-red-800 transition-all shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                        <small>حذف</small>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <button type="submit" id="editTags"
                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                ثبت عکس
            </button>
        </form>
    </x-modal>
</div>
@script
    <script>
        // Function to handle click event on tag modal close button
        $("#tag-modal-close-btn").click(function(e) {
            // Reset the selectedTags input field value to an empty array
            $("#selectedTags").val([]);
        });

        // Event listener to handle the 'open-tag-modal' event
        document.addEventListener('open-tag-modal', function() {
            // Retrieve the selectedTags input element
            let selectInput = $("#selectedTags");
            // Initialize an empty array to store selected tag slugs
            let selectedTags = [];

            // Loop through the selectedTags from Livewire component and extract slugs
            $wire.selectedTags.forEach(element => {
                selectedTags.push(element.slug);
            });

            // Set the value of the selectedTags input field to the array of selected tag slugs
            selectInput.val(selectedTags);

            // Initialize select2 on the selectedTags input field
            selectInput.select2();
        });

        // Function to handle click event on editTags button
        $("#editTags").click(function(e) {
            // Update the finalSelectedTags in the Livewire component with the values from selectedTags input field
            $wire.finalSelectedTags = $("#selectedTags").val()
        });
    </script>
@endscript
