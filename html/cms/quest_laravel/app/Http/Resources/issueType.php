<?php

namespace App\Http\Resources;
header('Access-Control-Allow-Origin: *');
use Illuminate\Http\Resources\Json\JsonResource;

class issueType extends JsonResource
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
            'issue_id' => $this->issue_id,
            'issue_desc' => $this->issue_desc
        ];

    }
}
