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
        $price = 0;

        foreach ($this->positions as $item) {
            $price += $item->count * $item->product->price;
            $collection['positions'][] = [
                'id' => $item->id,
                'count' => $item->count,
                'position' => $item->product->name,
                'price' => $item->count * $item->product->price,
            ];
        };
        $collection['price_all'] = $price;
        return $collection;
    }
}
