<div class="mb-5">
    <form wire:submit="validateValues" class="max-w-sm mx-auto">
        <div class="mb-5">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                عنوان تخصص شما
            </label>
            <input type="text" id="title" wire:model="title"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="تعمیرات یخچال ...." />
            @error('title')
                <span class="text-red-500 text-sm font-bold">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-5">
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                دسته بندی تخصص شما
            </label>
            <select wire:model="category" id="category"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">دسته بندی را انتخاب کنید</option>
                @foreach ($categories as $categoryItem)
                    <option value="{{ $categoryItem->slug }}">
                        {{ $categoryItem->name }}
                    </option>
                @endforeach
            </select>
            @error('category')
                <span class="text-red-500 text-sm font-bold">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-5">
            <label for="province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                استان شما
            </label>
            <select wire:change="setCity" wire:model="province" id="province"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">استان را انتخاب کنید</option>
                @foreach ($provinces as $provinceItem)
                    <option value="{{ $provinceItem->slug }}">
                        {{ $provinceItem->name }}
                    </option>
                @endforeach
            </select>
            @error('province')
                <span class="text-red-500 text-sm font-bold">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-5">
            <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                شهر شما
            </label>
            <select wire:model="city" id="city"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">شهر را انتخاب کنید</option>
                @forelse ($cities as $cityItem)
                    <option value="{{ $cityItem->slug }}">
                        {{ $cityItem->name }}
                    </option>
                @empty
                    <option value="" class="bg-red-800 text-white" disabled>
                        برای استان انتخاب شده شهری ثبت نشده است
                    </option>
                @endforelse
            </select>
            @error('city')
                <span class="text-red-500 text-sm font-bold">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-5">
            <label for="workExperienceUnit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                واحد مدت تجربه کاری
            </label>
            <select wire:model.live.debounce="workExperienceUnit" id="workExperienceUnit"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">واحد مدت تجربه کاری را انتخاب کنید</option>
                <option value="month">ماه</option>
                <option value="year">سال</option>
            </select>
            @error('workExperienceUnit')
                <span class="text-red-500 text-sm font-bold">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-5">
            <label for="workExperienceDuration" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                مدت تجربه کاری
            </label>
            <select wire:model="workExperienceDuration" id="workExperienceDuration"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">مدت تجربه کاری را انتخاب کنید</option>
                @for ($i = 1; $i <= 40; $i++)
                    <option value="{{ $i }}">{{ $i }} @if ($workExperienceUnit == 'year')
                            سال
                        @elseif ($workExperienceUnit == 'month')
                            ماه
                        @endif
                    </option>
                @endfor
            </select>
            @error('workExperienceDuration')
                <span class="text-red-500 text-sm font-bold">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-5">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                توضیحات تخصص شما
            </label>
            <textarea id="description" wire:model="description" cols="30" rows="4"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="لطفا توضیحات را به صورت کامل بنویسید..."></textarea>
            @error('description')
                <span class="text-red-500 text-sm font-bold">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-5">
            @include('home.alert.error')
            @include('home.alert.success')
        </div>
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ثبت
            درخواست</button>
    </form>
</div>
