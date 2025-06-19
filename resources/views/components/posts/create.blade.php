@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
@endpush

<div class="max-w-4xl relative p-4 bg-white rounded-lg border dark:bg-gray-800 sm:p-5">
    <!-- Modal header -->
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add post</h3>
    </div>

    {{-- Validation Error --}}
    {{-- @if($errors->any())
    <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <svg class="shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Danger</span>
        <div>
            <span class="font-medium">Ensure that these requirements are met:</span>
            <ul class="mt-1.5 list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif --}}

    <!-- Modal body -->
    <form action="/dashboard" method="POST" id="post-form">
        @csrf
        <div class="mb-4">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <input autofocus type="text" name="title" id="title" class="@error('title') bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 @enderror border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Post title" value="{{ old('title') }}">
            @error('title') <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
            <select name="category_id" id="category_id" class="@error('category_id') bg-red-50 border-red-500 text-red-700 placeholder-red-700 focus:ring-red-500 focus:border-red-500 @enderror border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="0">Select a category</option>
                @foreach (App\Models\Category::get() as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="body" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Body</label>
            <textarea name="body" id="body" rows="4" class="hidden @error('body') bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 @enderror block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Write post here">{{ old('body') }}</textarea>
            <div id="editor"></div>
            @error('body') <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
        </div>
        <div class="flex gap-4">
            <button type="submit" class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Add new post
            </button>
            <a href="/dashboard" class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                <svg aria-hidden="true" class="w-5 h-5 mr-1.5 -ml-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Write post here',
        });

        const postForm = document.getElementById('post-form');
        const postBody = document.getElementById('body');
        const quillEditor = document.getElementById('editor');

        postForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const content = quillEditor.children[0].innerHTML;
            postBody.value = content; // Get the HTML content from the Quill editor
            postForm.submit(); // Submit the form
        })
    </script>
@endpush
