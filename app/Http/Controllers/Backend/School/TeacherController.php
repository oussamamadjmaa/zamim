<?php

namespace App\Http\Controllers\Backend\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\School\TeacherRequest;
use App\Http\Resources\TeacherCollection;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Str;

class TeacherController extends Controller
{
    public function __construct()
    {
        //Middleware
        // $this->authorizeResource(Teacher::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if($request->expectsJson()) return $this->jsonResponse($request);
        return view('backend.school.teachers.index');
    }


    private function jsonResponse($request)
    {
        if ($request->data_type == 'select') {
            $teachers = Teacher::whereSchoolId(auth()->user()->school_id)->latest('name')->get(['id', 'name'])->pluck('name', 'id')->toArray();

            return response()->json(['data' => $teachers]);
        }
        $teachers = Teacher::whereSchoolId(auth()->user()->school_id)->search($request->search)->latest('id')->paginate(15)->withQueryString();

        return new TeacherCollection($teachers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeacherRequest $request)
    {
        //
        $teacherData = $request->only(['name', 'email','mobile']);
        $password = Str::random(9);
        $teacherData['password'] = bcrypt($password);

        //
        $teacher = auth()->user()->school()->teachers()->create($teacherData);

        return response()->json([
            'status' => 200,
            'message' => __('Data created successfully'),
            'data' => new TeacherResource($teacher)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        return response()->json([
            'status' => 200,
            'data' => new TeacherResource($teacher)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(TeacherRequest $request, Teacher $teacher)
    {
        //
        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->mobile = $request->mobile;
        $teacher->save();

        return response()->json([
            'status' => 200,
            'message' => __('Data updated successfully'),
            'data' => new TeacherResource($teacher)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return response()->json([
            'status' => 200,
            'message' => __('Data deleted successfully')
        ]);
    }

}
