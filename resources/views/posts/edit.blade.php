@extends('layouts.app')

@section('content')
<h2 style="font-size: 28px; font-weight: bold; margin-bottom: 20px;">Edit Post</h2>

<form action="{{ route('posts.update', $post->_id) }}" method="POST" style="max-width: 700px; margin:auto; background-color: #ffffff; padding: 30px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 10px;">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 20px;">
        <label for="title" style="display:block; font-weight:bold; margin-bottom:8px;">Title</label>
        <input type="text" id="title" name="title" value="{{ $post->title }}" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;">
    </div>

    <div style="margin-bottom: 20px;">
        <label for="content" style="display:block; font-weight:bold; margin-bottom:8px;">Content</label>
        <textarea id="content" name="content" rows="6" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;">{{ $post->content }}</textarea>
    </div>

    <div style="margin-bottom: 20px;">
        <label for="author" style="display:block; font-weight:bold; margin-bottom:8px;">Author</label>
        <input type="text" id="author" name="author" value="{{ $post->author ?? '' }}" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;">
    </div>

    <div style="display:flex; justify-content:flex-start; gap:10px;">
        <button type="submit" style="background-color:#4f46e5; color:white; padding:10px 20px; border:none; border-radius:6px; cursor:pointer;">Update</button>
        <a href="{{ route('posts.index') }}" style="background-color:#6b7280; color:white; padding:10px 20px; border-radius:6px; text-decoration:none;">Cancel</a>
    </div>
</form>
@endsection
