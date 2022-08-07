<?php

namespace App\Http\Resources;
header('Access-Control-Allow-Origin: *');

use Illuminate\Http\Resources\Json\JsonResource;

class solution extends JsonResource
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
            'dkt_no' => $this->docket_no,
            'solution_desc' => $this->solution_desc,
            'solution_time' => $this->solution_time,
            'solution_nature' => $this->solution_nature
        ];
    }
}
