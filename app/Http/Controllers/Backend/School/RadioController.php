<?php

namespace App\Http\Controllers\Backend\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\School\RadioRequest;
use App\Http\Resources\RadioResource;
use App\Models\Radio;
use App\Models\School;
use App\Rules\isSchoolStudent;
use App\Rules\isSchoolTeacher;
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
                          ->with(['schools' => fn($q) => $q->select('id')->where('school_id', auth()->user()->id)])
                          ->get()
                          ->each(function ($radio) {
                                $radio->hasCurrentSchool = !$radio->schools->isEmpty();
                          });

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

        return RadioResource::collection($radiosList)->additional([
            'weeks' => $weeks,
            'semesters' => getSemesters()
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

        $schoolId = auth()->user()->school_id;

        $radio->load(['schools' => fn($q) => $q->select('id')->where('school_id', $schoolId)]);
        $radio->load(['teachers' => fn($q) => $q->select('id' , 'school_id', 'name')->where('school_id', $schoolId)]);
        $radio->load(['students' => fn($q) => $q->select('id' , 'school_id', 'name')->where('school_id', $schoolId)]);
        $radio->load(['articles' => fn($q) => $q->whereIsPublic(true)->orWhereMorphRelation('author', School::class, 'id', $schoolId)]);

        $radio->hasCurrentSchool = !$radio->schools->isEmpty();

        return response()->json([
            'status' => 200,
            'data' => new RadioResource($radio)
        ]);
    }


    public function update(RadioRequest $request, Radio $radio)
    {
        $data = $request->validated();
        $schoolId = auth()->user()->school_id;

        $studentsList = [];
        foreach ($data['students'] as $student) {
            $articleId = $student['article_id'];
            if (!$student['article_id']) {
                $student['article']['radio_id'] = $radio->id;
                $article = auth()->user()->articles()->create($student['article']);
                $articleId = $article->id;
            }

            $studentsList[$student['student_id']] = ['article_id' => $articleId];
        }
        //

        $radio->students()->sync($studentsList);
        $radio->teachers()->sync($data['teacher_id']);

        $radio->load([
            'schools' => fn($q) => $q->select('id')->where('school_id', $schoolId),
            'teachers' => fn($q) => $q->select('id', 'school_id', 'name')->where('school_id', $schoolId),
            'students' => fn($q) => $q->select('id', 'school_id', 'name')->where('school_id', $schoolId),
            'articles' => fn($q) => $q->whereIsPublic(true)->orWhereMorphRelation('author', School::class, 'id', $schoolId),
        ]);

        if ($radio->schools->isEmpty()) {
            $radio->schools()->sync(auth()->user()->school_id);
        }

        $radio->hasCurrentSchool = true;

        return response()->json([
            'status' => 200,
            'message' => __('Data updated successfully'),
            'data' => new RadioResource($radio)
        ]);
    }

    public function storeRating(Request $request, Radio $radio)
    {
        $schoolId = auth()->user()->school_id;

        $radio->load([
            'schools' => fn($q) => $q->select('id')->where('school_id', $schoolId),
            'teachers' => fn($q) => $q->select('id', 'school_id', 'name')->where('school_id', $schoolId),
        ]);

        abort_if($radio->schools->isEmpty(), 403);

        $data = $request->validate([
            'teacher_rating' => ['required', 'integer', 'between:0,5'],
            'students' => ['required', 'array'],
            'students.*.student_id' => ['required', 'integer', new isSchoolStudent($schoolId)],
            'students.*.rating' => ['required', 'integer', 'between:0,5'],
        ]);


        if ($radio->teachers->count()) {
            $radio->teachers()->updateExistingPivot($radio->teachers->first()->id, ['rating' => $data['teacher_rating']]);
        }


        $pivotData = collect($data['students'])->mapWithKeys(function ($student) {
            return [$student['student_id'] => ['rating' => $student['rating']]];
        })->all();

        $radio->students()->syncWithoutDetaching($pivotData);

        $radio->load([
            'teachers' => fn($q) => $q->select('id', 'school_id', 'name')->where('school_id', $schoolId),
            'students' => fn($q) => $q->select('id', 'school_id', 'name')->where('school_id', $schoolId),
            'articles' => fn($q) => $q->whereIsPublic(true)->orWhereMorphRelation('author', School::class, 'id', $schoolId),
        ]);

        $radio->hasCurrentSchool = true;

        return response()->json([
            'status' => 200,
            'message' => __('Data updated successfully'),
            'data' => new RadioResource($radio)
        ]);
    }

}
