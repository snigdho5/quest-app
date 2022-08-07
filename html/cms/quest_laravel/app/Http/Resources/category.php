<?php

namespace App\Http\Resources;
header('Access-Control-Allow-Origin: *');
use Illuminate\Http\Resources\Json\JsonResource;

class category extends JsonResource
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
            'dept_id' => $this->dept_id,
            'dept_name' => $this->dept_name
        ];

    }
}
