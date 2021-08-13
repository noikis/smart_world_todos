<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'attributes' => [
                'id' => $this->id,
                'name' => $this->name,
                'is_completed' => $this->is_completed,
                'is_closed' => $this->is_closed,
                'users' => $this->whenLoaded('users'),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]
        ];

    }


}
