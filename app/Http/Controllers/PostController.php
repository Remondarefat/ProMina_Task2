<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class PostController extends Controller
{
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|string',
            'feature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_first' => 'nullable|boolean',
            'pinned' => 'boolean',
        ]);
    
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->tags = $request->tags;
        $post->pinned = $request->has('pinned');
        $post->pdf_first = $request->has('pdf_first_option');
        $post->save();
    
        // Handle feature image upload
        if ($request->hasFile('feature')) {
            $post->addMediaFromRequest('feature')->toMediaCollection('feature');
        }
    
        // Handle PDF upload
        if ($request->hasFile('pdf_first')) {
            $post->addMediaFromRequest('pdf_first')->toMediaCollection('pdf');
        }
    
        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }
    public function index()
    {
        $posts = Post::latest()->with('media')->get();
        return view('posts.index',compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }
    public function edit(Post $post)
    {
        return view('posts.edit', ['post' => $post]);
    }

    // Update method to handle updating a specific post
    public function update(Request $request, Post $post)
    {
        // dd($request);
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|string',
            'feature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pinned' => 'nullable|boolean', 
            'pdf_first' => 'nullable|boolean',
        ]);
        
        $post->pinned = $request->input('pinned', false);

        $post->title = $request->title;
        $post->content = $request->content;
        $post->tags = $request->tags;
        $post->pinned = $request->has('pinned');
        $post->pdf_first = $request->has('pdf_first_option');

        $post->save();

        // Handle feature image update
        if ($request->hasFile('feature')) {
            $post->clearMediaCollection('feature');
            $post->addMediaFromRequest('feature')->toMediaCollection('feature');
        }

        // Handle PDF update
        if ($request->hasFile('pdf_first')) {
            $post->clearMediaCollection('pdf');
            $post->addMediaFromRequest('pdf_first')->toMediaCollection('pdf');
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    // Delete method to delete a specific post
    public function destroy(Post $post)
    {
        // Delete associated media files
        $post->clearMediaCollection();

        // Delete the post
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }

}
