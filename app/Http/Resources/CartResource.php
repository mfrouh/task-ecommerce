<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'product' => ProductResource::make($this->whenLoaded('product')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'total_price' => $this->total_price,

            $this->merge(Arr::except(parent::toArray($request), [
                'created_at', 'updated_at',
            ])),
        ];
    }
}
