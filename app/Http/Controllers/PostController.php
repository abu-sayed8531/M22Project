<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // posts of all users 

    public function all()
    {
        $posts = Post::paginate(1);
        return view('admin.home', compact('posts'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $posts = Post::where('user_id', $user_id)->paginate(1);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|string|unique:posts,title',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required',
            'featured_image' => ['required', 'image', 'mimes:jpeg,jpg,png,gif,svg', 'nullable'],
        ]);
        $imagePath = null;
        if ($request->file('featured_image')->isValid()) {
            $file = $request->file('featured_image');
            $clientPath = $file->getClientOriginalName();
            $imagePath = time() . '_' . $clientPath;
        }
        $validated['featured_image'] = $imagePath;

        $post = Post::create($validated);
        if ($imagePath !== null) {
            $storagePath = 'post_' . $post->id . '_' . $imagePath;
            $path = $file->storeAs('posts', $storagePath, 'public');
        }
        if ($post) {

            return redirect()->route('posts.index')->with('success', 'Post created successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact(['post', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|string|unique:posts,title,' . $post->id,
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required',
            'featured_image' => ['required', 'image', 'mimes:jpeg,jpg,png,gif,svg', 'nullable'],
        ]);
        $imagePath = null;
        if ($request->file('featured_image')->isValid()) {
            $file = $request->file('featured_image');
            $clientPath = $file->getClientOriginalName();
            $imagePath = time() . '_' . $clientPath;
        }
        $validated['featured_image'] = $imagePath;
        //dd(storage_path('app/public/posts/post_' . $post->id . '_' . $post->featured_image));
        if ($post->featured_image && file_exists(storage_path('app/public/posts/post_' . $post->id . '_' . $post->featured_image))) {
            unlink(storage_path('app/public/posts/post_' . $post->id . '_' . $post->featured_image));
        }

        $post->update($validated);
        if ($imagePath !== null) {
            $storagePath = 'post_' . $post->id . '_' . $imagePath;
            $path = $file->storeAs('posts', $storagePath, 'public');
        }
        if ($post) {

            return redirect()->route('posts.index')->with('success', 'Post updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->featured_image && file_exists(storage_path("app/public/posts/post_" . $post->id . '_' . $post->featured_image))) {
            unlink(storage_path("app/public/posts/post_" . $post->id . '_' . $post->featured_image));
        }
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}
