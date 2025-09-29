<!doctype html>
<html>
<head>
    <title>Student List</title>
</head>
<body>
    <h1>Student List</h1>

    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('students.create') }}">+ Add New Student</a>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $s)
                <tr>
                    <td>{{ $s->id }}</td>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->course }}</td>
                    <td>{{ $s->email }}</td>
                    <td>{{ $s->deleted_at ? 'Deleted' : 'Active' }}</td>
                    <td>
                        @if(!$s->deleted_at)
                            <a href="{{ route('students.edit', $s->id) }}">Edit</a> | 
                            <a href="{{ route('students.destroy', $s->id) }}">Delete</a>
                        @else
                            <a href="{{ route('students.restore', $s->id) }}">Restore</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
