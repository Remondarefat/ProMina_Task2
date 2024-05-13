<!-- resources/views/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Your index content goes here -->

    @if (Auth::check())
    <div class="mb-3">
        Helooo : {{ Auth::user()->name }}
    </div>
    @endif

    
</div>
@endsection
