<?php

namespace App\Http\Resources;
header('Access-Control-Allow-Origin: *');

use Illuminate\Http\Resources\Json\JsonResource;

class docketAllocation extends JsonResource
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
             $this->email,
             $this->mobile
            //  $this->location_name
        ];
    }
}
