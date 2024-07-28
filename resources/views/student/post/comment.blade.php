<div class="comment">
  <div class="content">
      <p>{{ $comment->content }}</p>
  </div>
  <div class="author">
      By: {{ $comment->user->fname }} {{ $comment->user->lname }} ({{ $comment->user_type }})
  </div>
  <div class="time">
       {{ $comment->created_at->diffForHumans() }}
  </div>

  <!-- Edit/Delete buttons -->
  @if (auth()->guard('student')->user()->is($comment->user) )
      <div>
          <form action="{{ route('student.comment.edit', $comment->id) }}" method="GET" style="display: inline;">
              @csrf
              <button type="submit">Edit</button>
          </form>
          <form action="{{ route('student.comment.destroy', $comment->id) }}" method="POST" style="display: inline;">
              @csrf
              @method('DELETE')
              <button type="submit">Delete</button>
          </form>
      </div>
  @endif


  <!-- Reply button -->
  <form action="{{ route('student.comment.storeReply') }}" method="POST">
      @csrf
      <input type="hidden" name="parent_comment_id" value="{{ $comment->id }}">
      <input type="hidden" name="post_id" value="{{ $comment->post_id }}">
      <input type="hidden" name="user_id" value="{{ auth()->guard('student')->user()->id }}">
      <input type="hidden" name="user_type" value="student">
      <input type="text" name="content" placeholder="Write your reply here..." required>
      <button type="submit">Reply</button>
  </form>


  <!-- Display replies -->
  @if ($comment->replies)
      <div class="replies">
          @foreach ($comment->replies as $reply)
              @include('student.post.comment', ['comment' => $reply])
          @endforeach
      </div>
  @endif
</div>
