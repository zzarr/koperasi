@extends('layout.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h3>Manage Users</h3>
    </div>
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><span>Manage Users</span></li>
        </ol>
    </nav>
</div>

<!-- Add User Button -->
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#userModal" onclick="resetForm()">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
        <line x1="12" y1="5" x2="12" y2="19"></line>
        <line x1="5" y1="12" x2="19" y2="12"></line>
    </svg> Tambah User
</button>

<!-- Export PDF Button -->
<a href="{{ route('manage-user.export.pdf') }}" class="btn btn-danger mb-3">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
        <polyline points="14 2 14 8 20 8"></polyline>
        <line x1="16" y1="13" x2="8" y2="13"></line>
        <line x1="16" y1="17" x2="8" y2="17"></line>
        <polyline points="10 9 9 9 8 9"></polyline>
    </svg> Export PDF
</a>

<!-- Users Table -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr id="user-row-{{ $user->id }}">
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->phone_number ?? '-' }}</td>
            <td>{{ $user->address ?? '-' }}</td>
            <td>{{ $user->roles->pluck('name')->first() ?? 'No Role' }}</td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="editUser({{ $user }})">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="deleteUser('{{ $user->id }}')">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="userForm" method="POST">
                @csrf
                <input type="hidden" name="id" id="userId">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role_id" id="role" class="form-control" required>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function resetForm() {
        document.getElementById('userForm').reset();
        document.getElementById('userForm').action = '{{ route("manage-user.store") }}';
        document.getElementById('userModalLabel').innerText = 'Tambah User';
    }

    function editUser(user) {
        resetForm();
        document.getElementById('userId').value = user.id;
        document.getElementById('name').value = user.name;
        document.getElementById('email').value = user.email;
        document.getElementById('username').value = user.username;
        document.getElementById('phone_number').value = user.phone_number;
        document.getElementById('address').value = user.address;
        document.getElementById('role').value = user.roles.length ? user.roles[0].id : '';
        document.getElementById('password').value = '';
        document.getElementById('userForm').action = '{{ route("manage-user.store") }}';
        document.getElementById('userModalLabel').innerText = 'Edit User';
        $('#userModal').modal('show');
    }

    function deleteUser(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            fetch(`/manage-user/${userId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    alert(data.message);
                    document.getElementById(`user-row-${userId}`).remove();
                } else {
                    alert('Failed to delete user: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
</script>
@endsection