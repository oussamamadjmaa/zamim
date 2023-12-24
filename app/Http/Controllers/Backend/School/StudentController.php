<?php

namespace App\Http\Controllers\Backend\School;

use App\Http\Controllers\SchoolBaseController;
use App\Http\Requests\Backend\School\StudentRequest;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Str;

class StudentController extends SchoolBaseController
{
    public function __construct()
    {
        parent::__construct();

        //Middleware
        // $this->authorizeResource(Student::class);
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
        $students = Student::whereSchoolId(auth()->user()->school_id)->latest('id')->paginate(15)->withQueryString();

        return new StudentCollection($students);
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
        $studentData = $request->only(['name', 'email','phone', 'mobile']);
        $password = Str::random(9);
        $studentData['password'] = bcrypt($password);

        //
        $student = auth()->user()->school()->students()->create($studentData);

        $student->profile()->create([
            'parent_name' => $request->profile['parent_name'],
            'level' => $request->profile['level'],
            'class' => $request->profile['class'],
            'division' => $request->profile['division'],
        ]);

        return response()->json([
            'status' => 200,
            'message' => __('Data created successfully'),
            'data' => new StudentResource($student)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
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
        $student->phone = $request->phone;
        $student->mobile = $request->mobile;
        $student->save();

        $student->profile->parent_name = $request->profile['parent_name'];
        $student->profile->level = $request->profile['level'];
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
