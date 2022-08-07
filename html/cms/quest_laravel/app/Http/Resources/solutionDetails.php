<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class solutionDetails extends JsonResource
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
       'solution' => $this->solution,
       'solution_time' => $this->solution_time,
       'staff_id' => $this->staff_id,
       'status' => $this->status
      ];  

    }
}
