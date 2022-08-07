<?php

namespace App\Http\Resources;
header('Access-Control-Allow-Origin: *');

use Illuminate\Http\Resources\Json\JsonResource;

class Task extends JsonResource
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
            $this->docket_no,
            $this->subject,
           // $this->description,
           // $this->priority_desc,
            $this->comp_datetime,
            $this->issue_desc
        ];
    }
}
