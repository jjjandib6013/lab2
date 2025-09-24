<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Models\Student;
use Illuminate\Http\Request;

Route::get('/hello', function () { 
    return 'Hello, Laravel!'; 
});

Route::get('/user/{id}', function ($id) {
     return "User ID: $id";
});

Route::get('/greet/{name?}', function ($name = 'Guest') {
     return "Hello, $name";
});

Route::get('/profile', function () { 
    return "This is your profile"; 
})->name('profile');

Route::prefix('admin')->group(function () { 
    Route::get('/dashboard', function () { 
        return 'Admin Dashboard'; 
    }); 
        Route::get('/settings', function () { 
            return 'Admin Settings'; 
        }); 
    });

Route::get('/students', function () { 
    $students = ['Ana', 'Ben', 'Cara', 'Dan']; return view('students.index', compact('students')); 
});

Route::get('/student/{id}', function ($id) { 
    $students = [ 
        1 => ['name' => 'Ana', 'course' => 'IT'], 
        2 => ['name' => 'Ben', 'course' => 'CS'], 
        3 => ['name' => 'Cara', 'course' => 'IS'],
        4 => ['name' => 'Dan', 'course' => 'SE'],
    ]; 
    
    if (!isset($students[$id])) { 
        abort(404); 
    } 

    return view('students.show', ['student' => $students[$id]]); 
});

Route::get('/students', [StudentController::class, 'index'])->name('students.index');   // list
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create'); // form
Route::post('/students', [StudentController::class, 'store'])->name('students.store');  // save


Route::get('/students/update/{id}', function ($id) {
    $student = Student::findOrFail($id);
    $student->course = 'Computer Science';
    $student->save();

    return "Updated student #{$id} to course: Computer Science";
});

// Soft delete a student
Route::get('/students/delete/{id}', function ($id) {
    $student = Student::findOrFail($id);
    $student->delete();

    return "Soft deleted student #{$id}";
});

// View only trashed (soft-deleted) students
Route::get('/students/trashed', function () {
    return Student::onlyTrashed()->get();
});

// Restore a soft-deleted student
Route::get('/students/restore/{id}', function ($id) {
    $student = Student::withTrashed()->findOrFail($id);
    $student->restore();

    return "Restored student #{$id}";
});

// Force delete permanently
Route::get('/students/force-delete/{id}', function ($id) {
    $student = Student::withTrashed()->findOrFail($id);
    $student->forceDelete();

    return "Permanently deleted student #{$id}";
});

// Count all students
Route::get('/students/count', function () {
    return Student::count();
});

Route::get('/students/course/{course}', function ($course) {
    return Student::where('course', $course)->get();
});

// Simple query-string search: /students/search?email=ana@example.com
Route::get('/students/search', function (Request $request) {
    $email = $request->query('email');

    return $email
        ? Student::where('email', $email)->first()
        : [];
})->middleware('web'); // ensure session/csrf middleware stack
