<div>
    <form wire:submit="getFilter" class="mt-5 flex flex-col mx-5 md:flex-row md:justify-between">
        <div class="mb-3 flex flex-col md:flex-row md:w-full">
            <div class="mb-2 md:w-2/4 md:mx-1">
                <input type="text" wire:model="search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="جستجو ...">
                @error('search')
                    <small class="text-red-600 text-bold">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-2 md:w-1/4 md:mx-1">
                <select name="category" wire:model="category"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">همه دسته بندی ها</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category')
                    <small class="text-red-600 text-bold">{{ $message }}</small>
                @enderror
            </div>
            <div class="md:w-1/4 md:mx-1">
                <select name="city" wire:model="city"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">همه شهر ها</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->slug }}">{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('city')
                    <small class="text-red-600 text-bold">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div>
            <x-inputs.button type="submit" name="جستجو" />
        </div>
    </form>
</div>
