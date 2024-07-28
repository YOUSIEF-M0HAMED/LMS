<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $posts = Post::all();
    return view('admin.post.index', ['posts' => $posts]);
  }

  public function show($id)
    {
        $post = Post::with('comments.replies')->findOrFail($id);
        return view('admin.post.show', compact('post'));
    }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.post.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required',
      'description' => 'required',
      'image' => 'max:4096',
    ]);
    $image = null;
    if ($request->has('image')) {
      $file = $request->file('image');
      $extension = $file->getClientOriginalExtension();
      $path = 'posts/';
      $filename = time() . '.' . $extension;
      $file->move($path, $filename);
      $image = $path . $filename;
    }
    Post::create([
      'title' => $request->title,
      'description' => $request->description,
      'image' => $image,
      'admin_id' => $request->admin,
    ]);
    return redirect()->route('admin.post.index')->with('success', 'Post created successfully');
  }


  public function edit(Post $post)
  {
    return view('admin.post.edit', ['post' => $post]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Post $post)
  {
    // Validate the request
    request()->validate([
      'title' => 'required',
      'description' => 'required',
    ]);

    // Keep a reference to the current image
    $current_image = $post->image;

    // Check if a new image is uploaded
    if (request()->hasFile('image')) {
      $file = request()->file('image');
      $extension = $file->getClientOriginalExtension();
      $path = 'posts/';
      $filename = time() . '.' . $extension;

      // Ensure the directory exists and is writable
      if (!file_exists($path)) {
        mkdir($path, 0755, true);
      }

      // Move the new image
      $file->move($path, $filename);

      // Update the current image path to the new image
      $new_image_path = $path . $filename;

      // Debugging statement
      if (!file_exists($new_image_path)) {
        dd('Image upload failed', $new_image_path);
      }

      // Delete the old image if a new image was uploaded successfully
      if ($current_image && file_exists($current_image)) {
        unlink($current_image);
      }

      $current_image = $new_image_path;
    }

    // Update the post with the new data
    $post->update([
      'title' => request()->title,
      'description' => request()->description,
      'admin_id' => request()->admin,
      'image' => $current_image,
    ]);

    // Redirect with a success message
    return redirect()->route('admin.post.index')->with('success', 'Post updated successfully');
  }


  public function destroy(Post $post)
  {
    $post->delete();
    return redirect()->route('admin.post.index')->with('success', 'Post deleted successfully');
  }
}