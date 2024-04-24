<div>
    <form wire:submit="create" class="max-w-sm mx-auto">
        <div class="mb-5">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                عنوان را وارد کنید <span class="text-red-700 font-bold">*</span>
            </label>
            <input wire:model="title" type="text" id="title"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="همکاری با وبسایت خدمات چی ..." />
            @error('title')
                <small class="text-red-700 font-bold">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-5">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                متن پیام را وارد کنید <span class="text-red-700 font-bold">*</span>
            </label>
            <textarea wire:model="message" name="message" id="message" cols="30" rows="5"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
            @error('message')
                <small class="text-red-700 font-bold">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            ثبت پیام
        </button>
        <div class="mt-3">
            @include('home.alert.success')
        </div>
    </form>
</div>
