<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class mainProblemType extends JsonResource
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
            'problem_code' => $this->problem_code,
            'problem_desc' => $this->problem_desc
        ];
    }
}
