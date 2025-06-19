@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
@endpush
<div class="max-w-4xl relative p-4 bg-white rounded-lg border dark:bg-gray-800 sm:p-5">
    <!-- Modal header -->
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit post</h3>
    </div>

    <form action="/dashboard/{{ $post->slug }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <input autofocus type="text" name="title" id="title" class="@error('title') bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 @enderror border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Post title" value="{{ old('title') ?? $post->title }}">
            @error('title') <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
            <select name="category_id" id="category_id" class="@error('category_id') bg-red-50 border-red-500 text-red-700 placeholder-red-700 focus:ring-red-500 focus:border-red-500 @enderror border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="0">Select a category</option>
                @foreach (App\Models\Category::get() as $category)
                    <option value="{{ $category->id }}" @selected((old('category_id') ?? $post->category->id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label for="body" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Body</label>
            <textarea name="body" id="body" rows="4" class="hidden @error('body') bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 @enderror block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Write post here">{{ old('body') ?? $post->body }}</textarea>
            <div id="editor">{!! old('body'), $post->body !!}</div>
            @error('body') <p class="mt-2 text-xs text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
        </div>
        <div class="flex gap-4">
            <button type="submit" class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                Update post
            </button>
            <a href="/dashboard" class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
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
