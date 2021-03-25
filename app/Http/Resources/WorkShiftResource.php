<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkShiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $collection = parent::toArray($request);

        foreach ($this->workers as $worker) {
            $collection['users'][] = [
                'id' => $worker->id,
                'name' => $worker->name,
                'group' => $worker->group,
            ];
        };
        return $collection;
    }
}
