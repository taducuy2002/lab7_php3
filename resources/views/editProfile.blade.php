@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Update Profile</h2>
    @session('message')
        <div class="alert alert-success text-center">
            {{ session('message') }}
        </div>
    @endsession
    <form action="{{ route('profile.edit', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" class="form-control" value="{{ $user->fullname }}" required>
        </div>
        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="mb-3">
            <label for="avatar">Avatar:</label>
            <input type="file" name="avatar" class="form-control">
            <img src="{{ Storage::url($user->avatar) }}" alt="Ảnh lỗi" width="100">
        </div>
        <a href="{{route('profile.show')}}" class="btn btn-outline-primary me-3">Back</a>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
