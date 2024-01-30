<?php

namespace App\Http\Controllers\Backend\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\School\RadioRequest;
use App\Http\Resources\RadioResource;
use App\Models\Radio;
use Illuminate\Http\Request;

class RadioController extends Controller
{
    public function __construct()
    {
        //Middleware
        $this->authorizeResource(Radio::class);
    }
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
        $radios = Radio::whereSchoolId(auth()->user()->school_id)->with(['students:id,name','teacher:id,name'])->latest('radio_date')->paginate(15)->withQueryString();

        return RadioResource::collection($radios);
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
