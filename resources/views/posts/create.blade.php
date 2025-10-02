@extends('layouts.app')

@section('content')
    <h2 style="font-size: 24px; margin-bottom: 20px;">Create Post</h2>

    <form action="{{ route('posts.store') }}" method="POST" style="max-width: 600px;">
        @csrf
        <div style="margin-bottom: 15px;">
            <label for="title" style="display:block; margin-bottom:5px;">Title:</label>
            <input type="text" name="title" id="title" style="width:100%; padding:10px; border:1px solid #e5e7eb; border-radius:6px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for="content" style="display:block; margin-bottom:5px;">Content:</label>
            <textarea name="content" id="content" rows="5" style="width:100%; padding:10px; border:1px solid #e5e7eb; border-radius:6px;"></textarea>
        </div>
        <div style="margin-bottom: 15px;">
            <label for="author" style="display:block; margin-bottom:5px;">Author:</label>
            <input type="text" name="author" id="author" style="width:100%; padding:10px; border:1px solid #e5e7eb; border-radius:6px;">
        </div>
        <button type="submit" class="btn">Create</button>
    </form>
@endsection
