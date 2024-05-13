@extends('layouts.admin')
@section('content')

<div class="container">
    @if(isset($post))
        <h2>Edit Post</h2>
        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
    @else
        <h2>Create Post</h2>
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @endif
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $post->title ?? '' }}" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" class="form-control" rows="6" required>{{ $post->content ?? '' }}</textarea>
            </div>
            <div class="form-group">
                <label for="tags">Tags</label>
                <input type="text" name="tags" id="tags" class="form-control" value="{{ $post->tags ?? '' }}">
            </div>
            <div class="form-group">
                <label for="feature">Feature Image</label>
                <input type="file" name="feature" id="feature" class="form-control-file">
            </div>
            <div class="form-group">
                <label for="pdf_first">PDF</label>
                <input type="file" name="pdf_first" id="pdf_first" class="form-control-file">
            </div>
            <div class="form-group">
                <input type="checkbox" name="pinned" id="pinned"  class="form-check-input" {{ $post->pinned ? 'checked' : '' }}>
                <label for="pinned" class="form-check-label">Pinned</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="pdf_first_option" id="pdf_first_option" class="form-check-input">
                <label for="pdf_first_option" class="form-check-label">Display first part as PDF</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">
                @if(isset($post))
                    Update Post
                @else
                    Create Post
                @endif
            </button>
        </form>
    </div>
</div>
@endsection