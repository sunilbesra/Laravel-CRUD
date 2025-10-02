@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-lg p-6 max-w-2xl mx-auto">
    <h2 class="text-3xl font-bold mb-4">{{ $post->title }}</h2>
    <p class="text-gray-700 mb-4">{{ $post->content }}</p>
    <p class="text-sm text-gray-500">By {{ $post->author }} on {{ $post->created_at }}</p>

    <div class="mt-6 flex space-x-3">
        <a href="{{ route('posts.edit', $post->_id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Edit</a>
        <a href="{{ route('posts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Back</a>
    </div>
</div>
@endsection
