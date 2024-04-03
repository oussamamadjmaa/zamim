<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Admin\SemesterRequest;
use App\Http\Resources\SemesterResource;
use App\Models\Semester;
use Cache;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if($request->expectsJson()) return $this->jsonResponse($request);
        return view('backend.admin.semesters.index');
    }


    private function jsonResponse($request)
    {
        if ($request->data_type == 'select') {
            $semesters = Semester::latest('start_date')->get(['id', 'name', 'start_date', 'end_date'])
            ->map(fn($sem) => [
                    'id' => $sem->id,
                    'name' => $sem->name . '(' . (hijriDate($sem->start_date, 'Y/m/d')) . ' - ' . (hijriDate($sem->end_date, 'Y/m/d')) . ')'
                    ])->pluck('name', 'id')->toArray();

            return response()->json(['data' => $semesters]);
        }
        $semesters = Semester::latest('start_date')->paginate(15)->withQueryString();

        return SemesterResource::collection($semesters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SemesterRequest $request)
    {
        //
        $semesterData = $request->only(['name', 'start_date','end_date']);

        //
        $semester = Semester::create($semesterData);

        Cache::forget('semesters');

        return response()->json([
            'status' => 200,
            'message' => __('Data created successfully'),
            'data' => new SemesterResource($semester)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function show(Semester $semester)
    {
        abort_if(!request()->expectsJson(), 404);

        return response()->json([
            'status' => 200,
            'data' => new SemesterResource($semester)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function update(SemesterRequest $request, Semester $semester)
    {
        //
        $semester->name = $request->name;
        $semester->start_date = $request->start_date;
        $semester->end_date = $request->end_date;
        $semester->save();

        Cache::forget('semesters');

        return response()->json([
            'status' => 200,
            'message' => __('Data updated successfully'),
            'data' => new SemesterResource($semester)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function destroy(Semester $semester)
    {
        $semester->delete();

        Cache::forget('semesters');

        return response()->json([
            'status' => 200,
            'message' => __('Data deleted successfully')
        ]);
    }

}
