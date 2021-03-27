<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdersDetailResource extends OrderResource
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
        $collection['positions']= PositionResource::collection($this->positions);
        $collection['price_all'] = $this->getPrice();
        return $collection;
    }
}
