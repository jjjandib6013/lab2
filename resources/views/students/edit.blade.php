<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>
    <h1>Edit Student</h1>

    @if ($errors->any())
        <ul style="color:red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('students.update', $student->id) }}">
        @csrf

        <label>Name:</label><br>
        <input type="text" name="name" value="{{ old('name', $student->name) }}"><br><br>

        <label>Course:</label><br>
        <input type="text" name="course" value="{{ old('course', $student->course) }}"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email', $student->email) }}"><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>