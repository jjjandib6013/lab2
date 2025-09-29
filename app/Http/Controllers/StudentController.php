<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::withTrashed()->latest()->get()->sort();


        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3',
            'course' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('students', 'email')->whereNull('deleted_at'),
            ],
        ]);

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, $id) {
        $student = Student::findOrFail($id); // 

        $student->name = $request->input('name');
        $student->course = $request->input('course');
        $student->email = $request->input('email'); 

        $student->save();  

        return redirect('/students');      
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted (soft delete).');
    }

    public function restore($id)
    {
        $student = Student::withTrashed()->findOrFail($id);
        $student->restore();

        return redirect()->route('students.index')->with('success', 'Student restored successfully!');
    }
}
