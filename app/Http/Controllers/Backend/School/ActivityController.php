<?php

namespace App\Http\Controllers\Backend\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\School\ActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct()
    {
        //Middleware
        // $this->authorizeResource(Activity::class);
        $this->middleware(function() {
            return abort(404);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if($request->expectsJson()) return $this->jsonResponse($request);
        return view('backend.school.activities.index');
    }


    private function jsonResponse($request)
    {
        $activities = Activity::whereSchoolId(auth()->user()->school_id)->with(['students:id,name','teacher:id,name'])->search($request->search)->latest('activity_date')->paginate(15)->withQueryString();

        return ActivityResource::collection($activities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityRequest $request)
    {
        //
        $activityData = $request->only(['name', 'bg_image','class', 'activity_date', 'teacher_id']);

        //
        $activity = auth()->user()->school()->activities()->create($activityData);

        $activity->students()->attach($request->students);

        $activity->load(['teacher:id,name', 'students:id,name']);
        return response()->json([
            'status' => 200,
            'message' => __('Data created successfully'),
            'data' => new ActivityResource($activity)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        abort_if(!request()->expectsJson(), 404);

        $activity->load(['teacher:id,name', 'students:id,name']);

        return response()->json([
            'status' => 200,
            'data' => new ActivityResource($activity)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityRequest $request, Activity $activity)
    {
        //
        $activity->name = $request->name;
        $activity->bg_image = $request->bg_image;
        $activity->class = $request->class;
        $activity->activity_date = $request->activity_date;
        $activity->teacher_id = $request->teacher_id;
        $activity->save();

        $activity->students()->sync($request->students);

        $activity->load(['teacher:id,name', 'students:id,name']);

        return response()->json([
            'status' => 200,
            'message' => __('Data updated successfully'),
            'data' => new ActivityResource($activity)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();
        return response()->json([
            'status' => 200,
            'message' => __('Data deleted successfully')
        ]);
    }

}
