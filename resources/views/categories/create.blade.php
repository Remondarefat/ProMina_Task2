@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Create Category</h2>
        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="desc">Description</label>
                <textarea name="desc" id="desc" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="parent_id">Parent Category</label>
                <select name="parent_id" id="parent_id" class="form-control">
                    <option value="">Select Parent Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
        <label for="icon">Icon</label>
            <input type="file" name="icon" id="icon" class="form-control-file"> <!-- Input field for 'icon' -->
        </div>
            <div class="form-group">
        <label for="img">Img</label>
            <input type="file" name="img" id="img" class="form-control-file"> <!-- Input field for 'img' -->
        </div>
            
            <button type="submit" class="btn btn-primary mt-3">Create Category</button>
        </form>
    </div>
@endsection
