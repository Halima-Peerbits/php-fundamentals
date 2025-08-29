@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">

    <!-- Page Title + Button -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">📌 All Posts</h1>
        <a href="{{ route('posts.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-lg shadow-md transition transform hover:scale-105">
            ➕ New Post
        </a>
    </div>

    <!-- Posts List -->
    <div class="grid md:grid-cols-2 gap-6">
        @forelse ($posts as $post)
            <div x-data="{hover:false}"
                 @mouseenter="hover=true" @mouseleave="hover=false"
                 class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md transform transition duration-300 hover:-translate-y-1 hover:shadow-lg">

                <h3 class="text-xl font-bold text-indigo-700 dark:text-indigo-400 mb-2"
                    x-bind:class="hover ? 'underline' : ''">
                    {{ $post->title }}
                </h3>

                <p class="text-gray-700 dark:text-gray-300 mb-3 line-clamp-3">
                    {{ $post->content }}
                </p>

                <small class="block text-sm text-gray-500 dark:text-gray-400 mb-4">
                    ✍️ By <span class="font-medium">{{ $post->user->name }}</span>
                    · {{ $post->created_at->format('d M Y') }}
                </small>

                <!-- Action Buttons -->
                <div class="flex space-x-2">
                    <a href="{{ route('posts.show', $post) }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition">
                        View
                    </a>

                    @can('update', $post)
                        <a href="{{ route('posts.edit', $post) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded transition">
                            Edit
                        </a>
                    @endcan

                    @can('delete', $post)
                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this post?');">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition">
                                Delete
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            <p class="col-span-2 text-center text-gray-600 dark:text-gray-300">
                😔 No posts available. <a href="{{ route('posts.create') }}" class="text-indigo-600">Create one</a>!
            </p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>
@endsection

