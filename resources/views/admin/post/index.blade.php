@extends('admin.layouts.app')
@section('pageTitle')
    Admin Posts | All Posts
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/post/post.css') }}">
@endsection
@section('content')
    <div class="container-fluid p-0">
        <div class="text-center my-4">
            <a href="{{ route('admin.post.create') }}" class="btn btn-primary">Create Post</a>
        </div>
        <div class="row row-cols-1 row-cols-md-2 g-4">

            @foreach ($posts as $post)
                <div class="col">
                    <a href="{{ route('admin.post.show', $post->id) }}">
                        <div class="card post p-3">
                            @if ($post->image != null)
                                <img class="post-image w-100" src="{{ asset($post->image) }}" class="card-img-top"
                                    alt="">
                            @endif
                            <div class="card-body">
                                <div class="owner d-flex">
                                    @if ($post->admin->image != null)
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
                                {{-- <ul class="reaction-bar d-flex justify-content-end p-0 m-0">
                                <li class="me-4"><a href="#"><i class="fa-solid fa-thumbs-up pe-2"></i>X
                                        Reactions</a>
                                </li>
                                <li class=""><a href="#"><i class="fa-solid fa-comment pe-2"></i>X Comments</a>
                                </li>
                            </ul> --}}
                                <div>
                                    <a href="{{ route('admin.post.edit', $post->id) }}" class="btn btn-secondary">Edit</a>
                                    <form action="{{ route('admin.post.destroy', $post->id) }}" method="post"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-dark">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            @endforeach

        </div>
    </div>
@endsection
@section('pageScript')
@endsection
