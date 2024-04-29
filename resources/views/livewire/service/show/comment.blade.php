<div class="mt-10">
    <div class="text-right mb-3 mt-8 md:mb-5 md:mt-10">
        <span class="text-lg">
            <span class="border-b border-red-500">
                نظرات کاربران برای این متخصص 💬
            </span>
        </span>
    </div>
    <div class="flex flex-col flex-wrap justify-start">
        @forelse ($this->comments as $comment)
            <div wire:key="comment-id-{{ $comment->id }}"
                class="mx-1 my-2 block w-full px-6 py-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <p class="font-normal text-gray-700 dark:text-gray-400 pb-2">
                    {{ $comment->comment }}
                </p>
                <div class="flex items-center gap-4 border-t-2 pt-3">
                    @if ($comment->user->profile_path !== null)
                        <img class="w-9 h-9 rounded-full" src="{{ asset($comment->user->profile_path) }}" alt="">
                    @endif
                    <div class="font-medium dark:text-white">
                        <div>
                            {{ $comment->user->full_name }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-red-100 border text-center border-red-400 text-red-700 px-4 py-3 rounded relative"
                role="alert">
                <strong class="font-bold">لیست نظر ها خالی است !</strong>
                <span class="block sm:inline">برای این متخصص نظری ثبت نشده 🤷‍♂️</span>
            </div>
        @endforelse
    </div>
    <div class="text-center mb-3 mt-8 md:mb-5 md:mt-10">
        <span class="text-lg">
            <span class="border-b border-red-500">
                ثبت نظر برای این متخصص 💬
            </span>
        </span>
    </div>
    <form wire:submit="createComment" class="max-w-sm mx-auto mt-8">
        <div class="mb-5">
            <label for="comment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                متن نظر را وارد کنید <span class="text-red-700 font-bold">*</span>
            </label>
            <textarea wire:model="comment" id="comment" cols="30" rows="5"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
            @error('comment')
                <small class="text-red-700 font-bold">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            ثبت نظر
        </button>
        <div class="mt-3">
            @include('home.alert.success')
            @include('home.alert.error')
        </div>
    </form>
</div>
