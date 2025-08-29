@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-6">
    <!-- Post Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 
                transform transition duration-500 hover:scale-[1.01] animate-fadeIn">

        <!-- Title -->
        <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4 tracking-wide">
            {{ $post->title }}
        </h1>

        <!-- Meta Info -->
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
            ✍️ By <span class="font-semibold">{{ $post->user->name }}</span> 
            • {{ $post->created_at->format('d M Y, h:i A') }}
        </p>

        <!-- Content -->
        <div class="prose dark:prose-invert max-w-none text-lg leading-relaxed mb-8">
            {!! nl2br(e($post->content)) !!}
        </div>

        <!-- Actions -->
        <div class="flex flex-wrap gap-3 items-center">
            <!-- Back -->
            <a href="{{ route('posts.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg 
                      transition transform hover:scale-105 shadow">
                ⬅ Back to Posts
            </a>

            <!-- Edit -->
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg 
                          transition transform hover:scale-105 shadow">
                    ✏️ Edit
                </a>
            @endcan

            <!-- Delete -->
            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?')">
                    @csrf 
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg 
                                   transition transform hover:scale-110 shadow">
                        🗑 Delete
                    </button>
                </form>
            @endcan
        </div>
    </div>
</div>

<!-- Simple Animation -->
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.6s ease-out;
}
</style>
@endsection

