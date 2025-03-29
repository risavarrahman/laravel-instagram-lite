<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile Page') }}
        </h2>
    </x-slot:header>

    <div class="flex flex-col bg-blue-50 align-center justify-center py-8">
        <div class="max-w-7xl mx-auto justify-center">

            <div
                class="flex flex-col mx-auto items-start justify-between bg-white rounded-lg shadow-sm md:flex-row md:max-w-xl">
                @if ($user->profile_photo)
                    <img class="w-40 h-40 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                        src="{{ asset($user->profile_photo) }}" alt="">
                @else
                    <svg class="w-40 h-40 p-1 text-gray-400 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd"></path>
                    </svg>
                @endif

                <div class="flex flex-col justify-between mx-auto items-start p-4 leading-normal">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $user->username }}
                    </h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $user->user_bio }}</p>
                </div>
                <div class="flex flex-col justify-between mx-auto items-start p-4 leading-normal">
                    <span class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">Posts</span>
                    <p class="mb-3 font-light text-gray-700 dark:text-gray-400">
                        <span class="font-bold">{{ $user->posts->count() }}</span>
                    </p>

                </div>
            </div>

            @if (session('success'))
                <div id="alert-3"
                    class="flex items-center p-4 my-4 text-gray-800 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400"
                    role="alert">
                    {{ session('success') }}
                    <button type="button"
                        class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                        data-dismiss-target="#alert-3" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
            @endif

            <div class="grid grid-cols-3 gap-2 items-center mx-auto mt-10">
                {{-- <div class="mx-auto">
                    <img class="h-auto max-w-full rounded-lg"
                        src="{{ asset('./assets/images/dadf7d3ed7a40d6c4717c7bd716af3b7.jpg') }}" alt="">
                </div> --}}
                @foreach ($posts as $post)
                    <div class="mx-auto ">
                        <a href="#"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            x-data="{ filePath: '{{ asset($post->file_path) }}', caption: '{{ $post->caption }}' }"
                            x-on:click.prevent="$dispatch('open-modal', { id: 'open-post', filePath: filePath, caption: caption });">
                            <img src="{{ asset($post->file_path) }}" alt="{{ $post->caption }}"
                                class="h-96 w-72 object-cover rounded-lg border border-gray-800">
                            <span class="hidden">{{ asset($post->file_path) }}</span>
                        </a>
                    </div>
                @endforeach

            </div>


        </div>

    </div>

    <x-modal name="open-post" maxWidth="5xl" focusable>
        <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Post
            </h3>
            <button type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                x-on:click="$dispatch('close')">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>

        <div
            class="flex flex-col items-start bg-white border border-gray-200 rounded-lg shadow-sm md:flex-row md:max-w-5xl dark:border-gray-700 dark:bg-gray-800">
            <img class="object-cover w-full h-4/5 rounded-lg md:max-h-[800px] md:max-w-3xl md:rounded-none md:rounded-s-lg"
                x-bind:src="selectedFilePath" alt="Selected Image">
            {{-- src="{{ asset('./assets/images/1743104896_1335726.jpeg') }}" alt="Selected Image"> --}}
            <div class="flex flex-col p-4 leading-normal">
                <span class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">Posts</span>
                <p class="mb-3 font-light text-gray-700 dark:text-gray-400">
                    <span x-text="selectedCaption"></span>
                </p>

            </div>
        </div>
    </x-modal>

</x-app-layout>
