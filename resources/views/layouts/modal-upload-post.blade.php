<x-modal name="upload-post" focusable>

    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600 border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            Upload New Post
        </h3>
        <button type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            x-on:click="$dispatch('close')">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
        </button>
    </div>

    <form method="POST" action="{{ route('post.upload') }}" class="px-2" enctype="multipart/form-data">
        @csrf
        <div class="p-4 space-y-4">

            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file"
                    class="flex flex-col items-center justify-center w-full h-72 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 ">
                    <div id="file-preview" class="hidden mt-4">
                        <img id="preview-image" class="flex flex-col items-start justify-center w-full max-h-64"
                            style="display:none;" />
                        <video id="preview-video" class="flex flex-col items-start justify-center w-full max-h-64"
                            controls style="display:none;"></video>
                    </div>
                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="delete-while-preview">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                                upload</span></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">JPG/PNG/JPEG/MP4/MOV (Max. 150 Mb)
                        </p>
                    </div>
                    <input id="dropzone-file" type="file" name="file" class="hidden" accept="image/*, video/*" />

                </label>
            </div>
            <label for="caption" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Caption</label>
            <textarea id="caption" rows="3" name="caption"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 "
                placeholder="Write your caption here"></textarea>

            <x-primary-button>
                {{ __('Upload Post') }}
            </x-primary-button>

        </div>
    </form>
</x-modal>
