@extends('teacher.layouts.app')

@section('pageTitle')
    Post {{ $post->title }}
@endsection

@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/post/post.css') }}">
    <style>
        .replies :nth-child(4),
        .comment :nth-child(4) {
            margin-bottom: 5px;
            display: flex;
            flex-direction: row
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid p-0">

        <div class="row row-cols-1 row-cols-md-2 g-4">

            <div class="col">
                <div class="card post">
                    @if ($post->image)
                        <img class="post-image" src="{{ asset($post->image) }}" class="card-img-top" alt="">
                    @endif
                    <div class="card-body">
                        <div class="owner d-flex">
                            @if ($post->admin->image)
                                <img src="{{ asset($post->admin->image) }}" alt="">
                            @else
                                <img src="{{ asset('assets/imgs/temp_profile.jpg') }}" alt="">
                            @endif
                            <ul class="ms-3 p-0 mt-1">
                                <li class="fw-bold">{{ $post->admin->fname }}</li>
                                <li class="">{{ $post->created_at->diffForHumans() }}</li>
                            </ul>
                        </div>
                        <h3 class="card-title">{{ $post->title }}</h3>
                        <p class="card-text">{{ $post->description }}</p>
                        <ul class="reaction-bar d-flex justify-content-end p-0 m-0">
                            <li class="me-4"><a href="#"><i class="fa-solid fa-thumbs-up pe-2"></i>X
                                    Reactions</a>
                            </li>
                            <li class=""><a href="#"><i class="fa-solid fa-comment pe-2"></i>X Comments</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="comment-form">
                    <form action="{{ route('teacher.comment.store') }}" method="POST">
                        @csrf
                        <textarea name="content" placeholder="Write your comment here..." required></textarea>
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->guard('teacher')->user()->id }}">
                        <input type="hidden" name="user_type" value="teacher">
                        <button type="submit">Add Comment</button>
                    </form>
                </div>

                <div class="comments">
                    @foreach ($post->comments as $comment)
                        @include('teacher.post.comment', ['comment' => $comment])
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection

@section('pageScript')
    <!-- Any additional scripts if needed -->
@endsection
