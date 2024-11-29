@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Chi tiết tài khoản</h1>
        <div class="card">
            <div class="card-body">
                {{-- <div class="row mb-3">
                    <div class="col-md-3"><strong>ID:</strong></div>
                    <div class="col-md-9">{{ $user->id }}</div>
                </div> --}}

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Fullname:</strong></div>
                    <div class="col-md-9">{{ $user->fullname }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Username:</strong></div>
                    <div class="col-md-9">{{ $user->username }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Email:</strong></div>
                    <div class="col-md-9">{{ $user->email }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Password:</strong></div>
                    <div class="col-md-9">{{ str_repeat('*', strlen($user->password)) }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Avatar:</strong></div>
                    <div class="col-md-9">
                        @if ($user->avatar)
                            <img src="{{ asset('storage/app/public/' . $user->avatar) }}" alt="Avatar"
                                style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <span>Chưa có ảnh đại diện</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Vai trò:</strong></div>
                    <div class="col-md-9">{{ ucfirst($user->role) }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Trạng thái:</strong></div>
                    <div class="col-md-9">
                        @if ($user->active)
                            <span class="text-success">Kích hoạt</span>
                        @else
                            <span class="text-danger">Bỏ kích hoạt</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex m-3">
            <a href="{{route('profile.edit', $user->id)}}" class="btn btn-info me-3">Edit</a>
            <a href="{{route('password.change')}}" class="btn btn-info">Change Password</a>
        </div>
    </div>
@endsection
