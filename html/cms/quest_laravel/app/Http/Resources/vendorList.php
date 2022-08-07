<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class vendorList extends JsonResource
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
            'vendor_id' => $this->vendor_id,
            'vendor_name' => $this->vendor_name
        ];
    }
}
