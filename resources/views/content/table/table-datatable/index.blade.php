@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>All Posts</h2>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if ($post->pdf_first === 1)
                            @foreach ($post->media as $media)
                                @if ($media->collection_name === 'pdf')
                                    <!-- Display PDF if pdf_first is set to 1 -->
                                    <a class="btn btn-primary" href="{{ $media->getUrl() }}" target="_blank">View PDF</a>
                                    @break <!-- Break the loop after displaying the first PDF -->
                                @endif
                            @endforeach
                        @endif
                        <div class="card-body">
                            @if ($post->pdf_first !== 1)
                                <!-- Display other media if pdf_first is not set to 1 -->
                                @foreach ($post->media as $media)
                                    @if ($media->collection_name === 'feature')
                                        <img src="{{ $media->getUrl() }}" alt="{{ $post->title }}" class="img-fluid">
                                    @endif
                                @endforeach
                                @foreach ($post->media as $media)
                                    @if ($media->collection_name === 'pdf')
                                        <!-- Display PDF if pdf_first is set to 1 -->
                                        <a class="btn btn-primary" href="{{ $media->getUrl() }}" target="_blank">View PDF</a>
                                        @break <!-- Break the loop after displaying the first PDF -->
                                    @endif
                                @endforeach
                            @endif
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                            <div class="btn-group" role="group" aria-label="Post actions">
                                <!-- Edit button -->
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-info">Edit</a>
                                <!-- Delete button -->
                                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                </form>
                            </div>
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
