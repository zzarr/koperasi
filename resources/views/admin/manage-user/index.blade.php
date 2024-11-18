@extends('layout.app')

@section('content')
<div class="container">
    <h1>Manage Users</h1>
    <a href="{{ route('manage-user.create') }}" class="btn btn-primary mb-3">Add User</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Username</th>
                <th>Role</th>

                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->roles->pluck('name')->first() ?? 'No Role' }}</td>
                    <td>
                        @include('admin.manage-user.partials.action', ['user' => $user])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
