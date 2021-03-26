<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\ShiftWorkerRequest;
use App\Http\Requests\UsersArrayRequest;
use App\Http\Requests\WorkShiftRequest;
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

    public function open(WorkShift $workShift)
    {
        if (WorkShift::where(['active' => true])->count()) {
            throw new ApiException(403, 'Forbidden. There are open shifts!');
        }

        return new WorkShiftResource($workShift->open());
    }

    public function close(WorkShift $workShift)
    {
        if (!$workShift->active) {
            throw new ApiException(403, 'Forbidden. The shift is already closed!');
        }

        return new WorkShiftResource($workShift->close());
    }

    public function addUser(WorkShift $workShift, ShiftWorkerRequest $shiftWorkerRequest)
    {
        if ($workShift->hasUser($shiftWorkerRequest->user_id)) {
            throw new ApiException(403, 'Forbidden. The worker is already on shift!');
        }

        ShiftWorker::create([
            'work_shift_id' => $workShift->id,
            'user_id' => $shiftWorkerRequest->user_id
        ]);

        return response()->json([
            'data' => [
                'id_user' => $shiftWorkerRequest->user_id,
                'status' => 'added'
            ]
        ])->setStatusCode(201);

    }

    public function removeUser(WorkShift $workShift, User $user)
    {
        $workShift->removeUser($user->id);

        return response()->json([
            'data' => [
                'id_user' => $user->id,
                'status' => 'removed'
            ]
        ]);

    }

    public function orders(WorkShift $workShift)
    {
        return new WorkShiftOrdersResource($workShift);
    }
}
