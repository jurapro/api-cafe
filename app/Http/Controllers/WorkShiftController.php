<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\GetOrdersRequest;
use App\Http\Requests\Shift\CloseWorkShiftRequest;
use App\Http\Requests\Shift\OpenWorkShiftRequest;
use App\Http\Requests\Shift\ShiftWorkerRequest;
use App\Http\Requests\Shift\WorkShiftRequest;
use App\Http\Resources\WorkShiftOrdersResource;
use App\Http\Resources\WorkShiftResource;
use App\Models\ShiftWorker;
use App\Models\User;
use App\Models\WorkShift;

class WorkShiftController extends Controller
{
    public function index()
    {
        return WorkShift::all();
    }

    public function store(WorkShiftRequest $request)
    {
        return WorkShift::create($request->all());
    }

    public function show(WorkShift $workShift)
    {
        return new WorkShiftResource($workShift);
    }

    public function open(WorkShift $workShift, OpenWorkShiftRequest $openWorkShiftRequest)
    {
        return new WorkShiftResource($workShift->open());
    }

    public function close(WorkShift $workShift, CloseWorkShiftRequest $closeWorkShiftRequest)
    {
        return new WorkShiftResource($workShift->close());
    }

    public function addUser(WorkShift $workShift, ShiftWorkerRequest $shiftWorkerRequest)
    {
        ShiftWorker::create([
            'work_shift_id' => $workShift->id,
            'user_id' => $shiftWorkerRequest->user_id
        ]);

        return response()->json([
            'data' => [
                'id_user' => $shiftWorkerRequest->user_id,
                'status' => 'added'
            ]
        ])->setStatusCode(201, 'Created');
    }

    public function removeUser(WorkShift $workShift, User $user)
    {
        $workShift->removeUser($user->id);

        return [
            'data' => [
                'id_user' => $user->id,
                'status' => 'removed'
            ]
        ];
    }

    public function orders(WorkShift $workShift, GetOrdersRequest $getOrdersRequest)
    {
        return new WorkShiftOrdersResource($workShift);
    }

    public function active()
    {
        return new WorkShiftResource(WorkShift::where('active', 1)->first());
    }
}
