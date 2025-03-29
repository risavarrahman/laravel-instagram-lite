<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Archive Post') }}
        </h2>
    </x-slot:header>

    <section class="bg-gray-50 dark:bg-gray-900 p-4 sm:p-6">
        <div class="mx-auto max-w-screen-2xl px-4 lg:px-12">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-end space-y-3 md:space-y-0 md:space-x-4 p-4">

                    @if (session('success'))
                        <div id="alert-3"
                            class="flex items-center lg:w-1/3 p-4 my-4 text-gray-800 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400"
                            role="alert">
                            {{ session('success') }}
                            {{-- Post deleted successfully --}}
                            <button type="button"
                                class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                                data-dismiss-target="#alert-3" aria-label="Close">
                                <span class="sr-only">Close</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">

                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            <button id="exportDropdownButton" data-dropdown-toggle="exportDropdown"
                                class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                type="button">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewbox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                </svg>
                                Export
                            </button>
                            <div id="exportDropdown"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="exportDropdownButton">
                                    <li>
                                        <a href="{{ route('archive.export.xlsx') }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Export
                                            XLSX</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('archive.export.pdf') }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Export
                                            PDF</a>
                                    </li>
                                </ul>
                            </div>

                            <form action="{{ route('post.archive') }}" method="GET">
                                <select name="filter" onchange="this.form.submit()"
                                    class="w-full md:w-auto flex items-center justify-center py-2 px-6 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    <option value="">
                                        All
                                    </option>
                                    <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Today</option>
                                    <option value="yesterday" {{ $filter == 'yesterday' ? 'selected' : '' }}>Yesterday
                                    </option>
                                    <option value="last_week" {{ $filter == 'last_week' ? 'selected' : '' }}>Last Week
                                    </option>
                                    <option value="last_year" {{ $filter == 'last_year' ? 'selected' : '' }}>Last Year
                                    </option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-blue-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Post / Video</th>
                                <th scope="col" class="px-4 py-3">Tanggal</th>
                                <th scope="col" class="px-4 py-3">Caption</th>
                                <th scope="col" class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Post
                                        {{ $post->file_type }}</td>
                                    <td class="px-4 py-3">{{ $post->created_at->format('j M Y H:i') }}</td>
                                    <td class="px-4 py-3">{{ $post->caption }}</td>
                                    <td class="px-4 py-2 flex">
                                        <a href="#"
                                            class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900 text-center"
                                            x-data="{ filePath: '{{ asset($post->file_path) }}', caption: '{{ $post->caption }}' }"
                                            x-on:click.prevent="$dispatch('open-modal', { id: 'view-post-archive', filePath: filePath, caption: caption })">
                                            View Post</a>

                                        <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit"
                                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 text-center"
                                                onclick="return confirm('Are you sure?')">Delete
                                                Post</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div
                    class="flex flex-col md:flex-row justify-end mx-auto items-start md:items-center space-y-3 md:space-y-0 p-4">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>

        <x-modal name="view-post-archive" maxWidth="5xl" focusable>
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
                <div class="flex flex-col p-4 leading-normal">
                    <span class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">Posts</span>
                    <p class="mb-3 font-light text-gray-700 dark:text-gray-400">
                        <span x-text="selectedCaption"></span>
                    </p>

                </div>
            </div>
        </x-modal>
    </section>
</x-app-layout>
