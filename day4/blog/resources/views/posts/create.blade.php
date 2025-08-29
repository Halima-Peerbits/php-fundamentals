@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-6">
    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center animate-bounce">
        ✍️ Create a New Post
    </h1>


    <!-- Post Form -->
    <form action="{{ route('posts.store') }}" method="POST"
          class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 transition transform hover:scale-[1.01] duration-300">
        @csrf

        <!-- Title -->
        <div class="mb-6">
            <label for="title" class="block text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                Post Title
            </label>
            <input type="text" id="title" name="title"
                   value="{{ old('title') }}"
                   placeholder="Enter a catchy title..."
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
                      placeholder="Write something awesome..."
                      class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none resize-none
                             @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
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
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md 
                           transition transform hover:scale-110">
                💾 Save Post
            </button>
        </div>
    </form>
</div>
@endsection

