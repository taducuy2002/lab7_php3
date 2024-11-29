@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Manage Users</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->role == 'admin')
                                <span class="badge text-bg-success">Admin</span>
                            @else
                                <span class="badge text-bg-primary">User</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->active)
                                <span class="text-success">Active</span>
                            @else
                                <span class="text-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ url('/admin/users/' . $user->id . '/toggle') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-{{ $user->active ? 'warning' : 'success' }}">
                                    {{ $user->active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
