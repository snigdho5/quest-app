<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class subproblemType extends JsonResource
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
            'subproblem_code' => $this->subproblem_code,
            'subproblem_description' => $this->subproblem_description
        ];
    }
}
