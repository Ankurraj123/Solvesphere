@extends('layouts.app')

@section('title', 'Ask a Question – SolveSphere')
@section('page_title', 'Create Discussion Thread')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl shadow-xl p-8">
        <div class="border-b border-zinc-800/80 pb-4 mb-6">
            <h2 class="text-xl font-bold text-white tracking-tight">Ask the Community</h2>
            <p class="text-sm text-zinc-400 mt-1">Provide clear details, include error traces, and upload screenshots to get accurate answers.</p>
        </div>

        <form action="{{ route('problems.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-2">Title / Subject</label>
                <input id="title" name="title" type="text" required value="{{ old('title') }}"
                       class="w-full px-4 py-3 rounded-xl bg-zinc-950 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all text-sm @error('title') border-rose-500/50 @enderror"
                       placeholder="e.g. Memory leak in Node.js worker threads during heavy database writes">
                @error('title')
                    <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-2">Category</label>
                <select id="category_id" name="category_id" required
                        class="w-full px-4 py-3 rounded-xl bg-zinc-950 border border-zinc-800 text-zinc-300 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all text-sm cursor-pointer @error('category_id') border-rose-500/50 @enderror">
                    <option value="" disabled selected>Select category...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-2">Description / Code Details</label>
                <textarea id="description" name="description" rows="10" required
                          class="w-full px-4 py-3 rounded-xl bg-zinc-950 border border-zinc-800 text-white placeholder-zinc-500 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all text-sm @error('description') border-rose-500/50 @enderror"
                          placeholder="Describe your question in detail. You can use markdown rules to format code blocks, e.g. &#10;```javascript&#10;console.log('hello');&#10;```"></textarea>
                @error('description')
                    <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Optional Image Upload -->
            <div>
                <label class="block text-xs font-semibold text-zinc-300 uppercase tracking-wider mb-2">Attach Screenshot (Optional)</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border border-zinc-800/80 border-dashed rounded-xl bg-zinc-950/50 hover:bg-zinc-950 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-zinc-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-zinc-400">
                            <label for="image" class="relative cursor-pointer bg-transparent rounded-md font-semibold text-violet-400 hover:text-violet-300 focus-within:outline-none">
                                <span>Upload a file</span>
                                <input id="image" name="image" type="file" class="sr-only" onchange="previewFile()">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-3xs text-zinc-500">PNG, JPG, GIF up to 2MB</p>
                        <div id="file-name-preview" class="text-xs text-emerald-450 font-medium mt-2 hidden"></div>
                    </div>
                </div>
                @error('image')
                    <p class="text-xs text-rose-400 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800/80">
                <a href="{{ route('problems.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-zinc-400 bg-transparent hover:text-white transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-violet-600 to-indigo-500 hover:from-violet-500 hover:to-indigo-400 shadow-lg shadow-indigo-500/10 hover:shadow-indigo-500/20 transition-all cursor-pointer">
                    Publish Question
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewFile() {
        const fileInput = document.getElementById('image');
        const previewText = document.getElementById('file-name-preview');
        if (fileInput.files.length > 0) {
            previewText.textContent = "Selected file: " + fileInput.files[0].name;
            previewText.classList.remove('hidden');
        } else {
            previewText.classList.add('hidden');
        }
    }
</script>
@endsection
