<div>
    <form wire:submit="setSearchValue" class="md:w-2/3 md:m-auto mt-5 flex flex-col mx-5 md:flex-row md:justify-between">
        <div class="mb-2 md:w-full md:me-2">
            <input type="text" wire:model="searchInput"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="جستجو ...">
        </div>
        <div>
            <x-inputs.button type="button" name="جستجو" />
        </div>
    </form>
    <livewire:service.tags.show :services="$this->services" />
</div>
