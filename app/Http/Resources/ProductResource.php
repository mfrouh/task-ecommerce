<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
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
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'url' => route('product', [$this->id]),
            'image'=> Storage::url($this->image),

            $this->merge(Arr::except(parent::toArray($request), [
                'created_at', 'updated_at','image'
            ])),
        ];
    }
}
