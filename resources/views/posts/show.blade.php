@extends('layouts.app')

@section('content')
    <div class="container ">
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->content }}</p>
        @if ($post->tags)
            <p><strong>Tags:</strong> {{ $post->tags }}</p>
        @endif
        
        <!-- Display Media Files -->
        @foreach ($post->media as $media)
            @if ($media->collection_name === 'feature')
                <img src="{{ $media->getUrl() }}" alt="{{ $post->title }}" class="img-fluid">
            @elseif ($media->collection_name === 'pdf')
                <a class="btn btn-primary btn-block w-25" href="{{ $media->getUrl() }}" target="_blank">View PDF</a>
            @endif
        @endforeach
        
        @if ($post->pinned)
            <p>This post is pinned</p>
        @endif
    </div>
@endsection
