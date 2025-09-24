<!doctype html>
<html>
<head>
    <title>Student List</title>
</head>
<body>
    <h1>Student List</h1>

    {{-- Success Flash Message --}}
    @if (session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    <p>
        <a href="{{ route('students.create') }}">+ Add Student</a>
    </p>

    @if($students->count())
        <ul>
            @foreach($students as $s)
                <li>
                    {{ $s->name }} — {{ $s->course }} — {{ $s->email }}
                    @if($s->deleted_at)
                        (deleted)
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>No students yet.</p>
    @endif
</body>
</html>
