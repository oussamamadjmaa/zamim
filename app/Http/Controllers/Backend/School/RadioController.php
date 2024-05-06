<?php

namespace App\Http\Controllers\Backend\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\School\RadioRequest;
use App\Http\Resources\RadioResource;
use App\Models\Radio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RadioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if($request->expectsJson()) return $this->jsonResponse($request);
        return view('backend.school.radios.index');
    }


    private function jsonResponse($request)
    {
        $currentSemester = getCurrentSemester($request->get('semester_id'));

        $radiosList =   $currentSemester->radios()
                          ->whereLevel(auth()->user()->level)
                          ->oldest('week_number')
                          ->oldest('radio_date')
                          ->get();

        // Available weeks
        $weeks = $radiosList->groupBy(fn ($radio) =>  $radio->semester_id . '-' . $radio->level . '-' . $radio->week_number)->map(function ($radios) {
            $rad = $radios->first();
            $weekStart = $rad->radio_date->format('Y-m-d');
            $weekEnd = $rad->radio_date->copy()->addDays(4)->format('Y-m-d');

            return [
                'title' => __('Week ') . transNumber($rad->week_number),
                'semesterId' => $rad->semester_id,
                'level' => $rad->level,
                'weekNumber' => $rad->week_number,
                'weekRange' => dateRangeFormatter($weekStart, $weekEnd),
                'weekRangeHijri' => dateRangeFormatter(hijriDate($weekStart, 'Y/m/d'), hijriDate($weekEnd, 'Y/m/d'), '/', 'ar'),
            ];
        })->filter();

        return response()->json([
            'data' => RadioResource::collection($radiosList),
            'weeks' => $weeks,
            'semesters' => getSemesters()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RadioRequest $request)
    {
        //
        $radioData = $request->only(['class', 'radio_date', 'teacher_id']);

        //
        $radio = auth()->user()->school()->radios()->create($radioData);

        $radio->students()->attach($request->students);

        $radio->load(['students:id,name','teacher:id,name']);

        return response()->json([
            'status' => 200,
            'message' => __('Data created successfully'),
            'data' => new RadioResource($radio)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Radio  $radio
     * @return \Illuminate\Http\Response
     */
    public function show(Radio $radio)
    {
        abort_if(!request()->expectsJson(), 404);

        $radio->load(['teacher:id,name', 'students:id,name']);

        return response()->json([
            'status' => 200,
            'data' => new RadioResource($radio)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Radio  $radio
     * @return \Illuminate\Http\Response
     */
    public function update(RadioRequest $request, Radio $radio)
    {
        //
        $radio->class = $request->class;
        $radio->radio_date = $request->radio_date;
        $radio->teacher_id = $request->teacher_id;
        $radio->save();

        $radio->students()->sync($request->students);

        $radio->load(['teacher:id,name', 'students:id,name']);

        return response()->json([
            'status' => 200,
            'message' => __('Data updated successfully'),
            'data' => new RadioResource($radio)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Radio  $radio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Radio $radio)
    {
        $radio->delete();
        return response()->json([
            'status' => 200,
            'message' => __('Data deleted successfully')
        ]);
    }

}
