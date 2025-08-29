@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-6">
    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center animate-pulse">
        ✏️ Edit Post
    </h1>

    <!-- Edit Form -->
    <form action="{{ route('posts.update', $post) }}" method="POST"
          class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 transition transform hover:scale-[1.01] duration-300">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-6">
            <label for="title" class="block text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                Post Title
            </label>
            <input type="text" id="title" name="title"
                   value="{{ old('title', $post->title) }}"
                   placeholder="Update the title..."
                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none 
                          @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Content -->
        <div class="mb-6">
            <label for="content" class="block text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                Post Content
            </label>
            <textarea id="content" name="content" rows="6"
                      placeholder="Update the content..."
                      class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none resize-none
                             @error('content') border-red-500 @enderror">{{ old('content', $post->content) }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex justify-between items-center">
            <a href="{{ route('posts.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg transition transform hover:scale-105">
                ⬅ Back
            </a>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md 
                           transition transform hover:scale-110">
                🔄 Update Post
            </button>
        </div>
    </form>
</div>
@endsection

