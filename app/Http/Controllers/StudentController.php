<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Get all students
    public function index()
    {
        $students = Student::with(['user', 'group', 'series'])->get();  // Eager load relationships
        return response()->json($students);
    }

    // Store a new student
    public function store(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'full_name' => 'required|string|max:255',
            'student_number' => 'required|string|max:255',
            'group_id' => 'required|exists:groups,id',  // Use group_id here
            'series_id' => 'required|exists:series,id', // Use series_id here
            'year' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:2',
            'faculty' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
        ]);


        // Create a new student
        $student = Student::create($validated);
        if (!$student) {
            return response()->json(['error' => 'Student was not created!.'], 404);
        }
        // Return the created student with a 201 status code
        return response()->json($student, 201);
    }

    // Get a single student by ID
    public function show($id)
    {
        // Find the student or return a 404 error
        $student = Student::with(['user', 'group', 'series'])->find($id);

        if (!$student) {
            return response()->json(['error' => 'Student not found.'], 404);
        }

        return response()->json($student);
    }
    public function showUserId($user_id)
    {
        // Find the student by user_id or return a 404 error
        $student = Student::with(['user', 'group', 'series'])->where('user_id', $user_id)->first();

        if (!$student) {
            return response()->json(['error' => 'Student not found.'], 404);
        }

        return response()->json($student);
    }


    // Update an existing student
    public function update(Request $request, $id)
    {
        // Find the student or return a 404 error
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['error' => 'Student not found.'], 404);
        }

        // Validate the request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'full_name' => 'required|string|max:255',
            'student_number' => 'required|string|max:255',
            'group_id' => 'required|exists:groups,id',  // Use group_id here
            'series_id' => 'required|exists:series,id', // Use series_id here
            'year' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:2',
            'faculty' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
        ]);


        // Update the student's details with validated data, only fields provided will be updated
        $student->update(array_filter($validated)); // array_filter ensures only filled values are updated

        return response()->json($student);
    }

    // Delete a student
    public function destroy($id)
    {
        // Find the student or return a 404 error
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['error' => 'Student not found.'], 404);
        }

        // Delete the student record
        $student->delete();

        return response()->json(['message' => 'Student deleted successfully']);
    }
}
