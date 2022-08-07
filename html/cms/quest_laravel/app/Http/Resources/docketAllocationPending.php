<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class docketAllocationPending extends JsonResource
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
