<a href="{{ route('manage-user.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
<form action="{{ route('manage-user.destroy', $user->id) }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
</form>
