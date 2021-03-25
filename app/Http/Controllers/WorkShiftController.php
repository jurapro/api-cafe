<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\WorkShiftRequest;
use App\Http\Resources\WorkShiftResource;
use App\Models\WorkShift;


class WorkShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return WorkShift[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return WorkShift::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkShiftRequest $request)
    {
        return WorkShift::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return WorkShiftResource
     */
    public function show($id)
    {
        $workShift = WorkShift::findOrFail($id);
        return new WorkShiftResource($workShift);
    }

    public function open($id)
    {
        $workShift = WorkShift::findOrFail($id);

        if (WorkShift::where(['active' => true])->count()) {
            throw new ApiException(403, 'Forbidden. There are open shifts!');
        }

        return new WorkShiftResource($workShift->open());
    }

    public function close($id)
    {
        $workShift = WorkShift::findOrFail($id);

        if (!$workShift->active) {
            throw new ApiException(403, 'Forbidden. The shift is already closed!');
        }

        return new WorkShiftResource($workShift->close());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
