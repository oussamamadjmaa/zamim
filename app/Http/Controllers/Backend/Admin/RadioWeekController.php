<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Admin\RadioWeekRequest;
use App\Http\Resources\RadioWeekResource;
use App\Models\Radio;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RadioWeekController extends Controller
{
    public function index(Request $request) {
        if($request->expectsJson()) return $this->jsonResponse($request);

        return view('backend.admin.semesters.radios.index');
    }

    private function jsonResponse(Request $request) {
        $semesterId = (int) $request->get('semester_id');
        $level = $request->get('level');

        $radios = Radio::when($semesterId, fn($q) => $q->where('semester_id', $semesterId))
                        ->when($level && in_array($level, ['primary', 'middle', 'secondary']), fn($q) => $q->where('level', $level))
                        ->weekly()
                        ->with('semester')
                        ->latest('semester_id')
                        ->latest('week_number')
                        ->paginate(15)->withQueryString();

        return RadioWeekResource::collection($radios);
    }

    public function store(RadioWeekRequest $request)
    {
        $semesterId = $request->semester_id;
        $semester = Semester::find($semesterId);

        $request->validate([
            'start_date' => ['required', 'date', 'radio_date_validation:'.$semester->start_date.','.$semester->end_date],
        ]);

        $radioDate = Carbon::parse($request->start_date);
        $weekNumber = $request->week_number;
        $level = $request->level;
        $radios = $request->radios;


        $radioDates = [];

        foreach ($radios as $radio) {
            $radioData = [
                'semester_id' => $semesterId,
                'week_number' => $weekNumber,
                'subject' => $radio['subject'] ?? null,
                'attachment' => $radio['attachment'] ?? null,
                'week_number' => $weekNumber,
            ];

            $radioDateFormatted = $radioDate->copy()->format('Y-m-d');

            Radio::updateOrCreate(['level' => $level, 'radio_date' => $radioDateFormatted], $radioData);

            $radioDates[] = $radioDateFormatted;

            $radioDate = $radioDate->addDay();
        }

        Radio::where('semester_id', $semesterId)->where('level', $level)->where('week_number', $weekNumber)->whereNotIn('radio_date', $radioDates)->delete();

        $radio = Radio::where('semester_id', $semesterId)
                        ->where('level', $level)
                        ->where('week_number', $weekNumber)
                        ->weekly()
                        ->with('semester')
                        ->first();

        return response()->json([
            'status' => 200,
            'message' => __('Data saved successfully'),
            'data' => new RadioWeekResource($radio)
        ]);
    }

    public function getRadioWeek(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'semester_id' => 'required|integer',
            'level' => 'required|string',
            'week_number' => 'required|integer',
        ]);

        // Destructure the validated data
        ['semester_id' => $semesterId, 'level' => $level, 'week_number' => $weekNumber] = $validated;

        $radios = Radio::where('semester_id', $semesterId)
                        ->where('level', $level)
                        ->where('week_number', $weekNumber)
                        ->oldest('radio_date')
                        ->get();

        // Throw 404 if no radios found
        abort_if(!$radios->count(), 404);

        // Prepare response data
        $data = [
            'semester_id' => $semesterId,
            'level' => $level,
            'week_number' => $weekNumber,
            'start_date' => $radios->first()->radio_date->format('Y-m-d'),
            'radios' =>  $radios->mapWithKeys(function ($radio) {
                return [$radio->radio_date->format('l') => ['subject' => $radio->subject]];
            })->all(),
        ];

        // Return JSON response
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function deleteRadioWeek(Request $request) {
        // Validate the incoming request
        $validated = $request->validate([
            'semester_id' => 'required|integer',
            'level' => 'required|string',
            'week_number' => 'required|integer',
        ]);

        // Destructure the validated data
        ['semester_id' => $semesterId, 'level' => $level, 'week_number' => $weekNumber] = $validated;

        Radio::where('semester_id', $semesterId)
                ->where('level', $level)
                ->where('week_number', $weekNumber)
                ->delete();

        return response()->json([
            'status' => 200,
            'message' => __('Data deleted successfully')
        ]);
    }

}
