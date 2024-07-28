@extends('teacher.layouts.app')

@section('pageTitle')
    Edit Comment
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Comment') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('teacher.comment.update', $comment->id) }}">
                            @csrf

                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea id="content" class="form-control" name="content" required>{{ $comment->content }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">
                                {{ __('Update') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
