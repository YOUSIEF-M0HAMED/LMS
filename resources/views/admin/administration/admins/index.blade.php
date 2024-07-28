@extends('admin.layouts.app')
@section('pageTitle')
    All Admins
@endsection
@section('pageStyle')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/admin/home.css') }}"> --}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 p-0 mt-2">
                <div class="text-center">
                    <a class="btn btn-success" href="{{ route('admin.admins.create') }}">{{ __('messages.create-admin') }}</a>
                </div>
            </div>
        </div>

        @if (count($allAdmins) > 0)
            <table class="table text-center mt-4">
                <thead>
                    <tr>
                        <th scope="col">Admin ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Last Seen</th>
                        <th scope= "col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allAdmins as $adminData)
                        <tr>
                            <td>{{ $adminData->admin_id }}</td>
                            <td>{{ $adminData->username }}</td>
                            <td>{{ $adminData->fname }}</td>
                            <td>{{ $adminData->lname }}</td>
                            <td>{{ Carbon\Carbon::parse($adminData->last_seen)->diffForHumans() }}</td>
                            <td>
                                @if ($adminData->last_seen >= now()->subMinutes(2))
                                    <button type="submit" class="btn btn-success">Online</button>
                                @else
                                    <span>

                                        <button type="submit" class="btn btn-danger">Offline</button>
                                    </span>
                                @endif

                            </td>
                            <td>
                                <a href="{{ route('admin.admins.show', $adminData->id) }}" class="btn btn-info">View</a>
                                <a href="{{ route('admin.admins.edit', $adminData->id) }}" class="btn btn-primary">Edit</a>
                                <form method="POST" action="{{ route('admin.admins.destroy', $adminData->id) }}"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="col-md-10 p-0 mt-5">
                <div class="text-center">
                    No admins
                </div>
            </div>
        @endif
    </div>
@endsection
@section('pageScript')
    {{-- <script src="{{ asset('assets/js/admin/home.js') }}"></script> --}}
@endsection
