<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|min:3',
            'course' => 'required',
            'email'  => [
                'required',
                'email',
                Rule::unique('students', 'email')->whereNull('deleted_at'),
            ],
        ]);

        Student::create($data);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student added successfully!');
    }
}
