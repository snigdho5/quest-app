<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class locationName extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      
        return [
            'location_id' => $this->location_id,
            'location' => $this->location_name
        ];
    }
}
