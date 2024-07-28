<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'content' => 'required|string',
      'post_id' => 'required|exists:posts,id',
      'user_id' => 'required|integer',
      'user_type' => 'required|string',

  ]);

  $comment = new Comment();
  $comment->content = $validatedData['content'];
  $comment->post_id = $validatedData['post_id'];
  $comment->user_id = $validatedData['user_id'];
  $comment->user_type = $validatedData['user_type'];

  $comment->save();

  return redirect()->back()->with('success', 'Comment added successfully!');
}

public function storeReply(Request $request)
  {
    $validatedData = $request->validate([
      'parent_comment_id' => 'required|exists:comments,id',
      'content' => 'required|string',
      'post_id' => 'required|exists:posts,id',
      'user_id' => 'required|integer',
      'user_type' => 'required|string',

  ]);

  $comment = new Comment();
  $comment->parent_comment_id = $validatedData['parent_comment_id'];
  $comment->content = $validatedData['content'];
  $comment->post_id = $validatedData['post_id'];
  $comment->user_id = $validatedData['user_id'];
  $comment->user_type = $validatedData['user_type'];

  $comment->save();

  return redirect()->back()->with('success', 'reply added successfully!');
}

public function edit($id)
    {
        $notifications = auth()->guard('student')->user()->unreadNotifications;
        $comment = Comment::findOrFail($id);
        return view('student.post.editComment', compact('comment','notifications'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('student.post.show',$comment->post_id)->with('success', 'Comment updated successfully');
    }

public function destroy($id)
{
    $comment = Comment::findOrFail($id);
    $comment->delete();

    return redirect()->back()->with('success', 'Comment deleted successfully');
}


}