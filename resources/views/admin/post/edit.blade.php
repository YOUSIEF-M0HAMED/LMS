@extends('admin.layouts.app')
@section('pageTitle')
    Admin Posts | Edit
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/post/post.css') }}">
@endsection
@section('content')
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Create Post') }}</div>


                    <div class="card-body">
                        {{-- <form id="change_post_image" action="{{ route('admin.post.change_image', $post->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="image"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>
                                <div class="col-md-6 image">
                                    @if ($post->image)
                                        <img class="mb-3" src="{{ asset($post->image) }}" alt="">
                                    @endif
                                    <input id="image" class="form-control @error('image') is-invalid @enderror"
                                        type="file" name="image" onchange="submitChangeImage()">
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </form> --}}
                        <form method="POST" action="{{ route('admin.post.update', $post->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="admin" value="{{ Auth::guard('admin')->user()->id }}">

                            <div class="row mb-3">
                                <label for="image"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>
                                <div class="col-md-6 image">
                                    @if ($post->image)
                                        <img class="mb-3" src="{{ asset($post->image) }}" alt="">
                                    @endif
                                    <input id="image" class="form-control @error('image') is-invalid @enderror"
                                        type="file" name="image">
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="title"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" name="title"
                                        value="{{ $post->title }}" autocomplete="title" autofocus>

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                        cols="30" rows="5" autocomplete="description" autofocus>{{ $post->description }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Edit') }}
                                    </button>

                                    <a href="{{ route('admin.post.index') }}" class="btn btn-warning ms-3">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pageScript')
    <script src="{{ asset('assets/js/post/post.js') }}"></script>
@endsection
