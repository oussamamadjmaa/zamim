<?php

namespace App\Http\Controllers\Backend\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\School\StudentRequest;
use App\Http\Resources\StudentResource;
use App\Imports\StudentsImport;
use App\Models\Student;
use Excel;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        //Middleware
        $this->authorizeResource(Student::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if($request->expectsJson()) return $this->jsonResponse($request);
        return view('backend.school.students.index');
    }


    private function jsonResponse($request)
    {
        if ($request->dataType == 'select') {

            $students = Student::whereSchoolId(auth()->user()->school_id)->orderBy('name', 'ASC')->get(['id', 'name'])->pluck('name', 'id')->toArray();

            return response()->json(['data' => $students]);
        }

        $students = Student::whereSchoolId(auth()->user()->school_id)->search($request->search)->latest('id')->paginate(15)->withQueryString();

        return StudentResource::collection($students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        //
        $studentData = $request->only(['name', 'email','phone_number']);

        //
        $student = auth()->user()->school()->students()->create($studentData);

        $student->profile()->create([
            'parent_name' => $request->profile['parent_name'],
            'parent_email' => $request->profile['parent_email'],
            'level' => auth()->user()->level,
            'class' => $request->profile['class'],
            'division' => $request->profile['division'],
        ]);

        return response()->json([
            'status' => 200,
            'message' => __('Data created successfully'),
            'data' => new StudentResource($student)
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:20480'],
        ]);

        try {
            Excel::import(new StudentsImport(auth()->user()->school, auth()->user()->level), $request->file('file'));

            return response(['message' => __(':count Students has been imported successfully', ['count' => session()->pull('imported_students')])]);
        } catch (\Throwable $th) {
            return response(['message' => 'Failed to import file'], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        abort_if(!request()->expectsJson(), 404);

        return response()->json([
            'status' => 200,
            'data' => new StudentResource($student)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, Student $student)
    {
        //
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone_number = $request->phone_number;
        $student->save();

        $student->profile->parent_name = $request->profile['parent_name'];
        $student->profile->parent_email = $request->profile['parent_email'];
        $student->profile->class = $request->profile['class'];
        $student->profile->division = $request->profile['division'];
        $student->profile->save();

        return response()->json([
            'status' => 200,
            'message' => __('Data updated successfully'),
            'data' => new StudentResource($student)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json([
            'status' => 200,
            'message' => __('Data deleted successfully')
        ]);
    }

}
