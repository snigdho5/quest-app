<?php
namespace App\Http\Resources;
header('Access-Control-Allow-Origin: *');

use Illuminate\Http\Resources\Json\JsonResource;

class docketDetails extends JsonResource
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
       'docket_no' => $this->docket_no,
       'user' => $this->email,
       'mobile' => $this->mobile,
      // 'intercom' => $this->intercom,
       'subject' => $this->subject,
      // 'location' => $this->location_name,
       'category_desc' => $this->issue_desc,
      // 'other_category' => $this->other_category,
       'comp_datetime' => $this->comp_datetime,
       'staff_id' => $this->email_id,
       'staff_email' => $this->email_id,
       'status_desc' => $this->status_desc,
      // 'solution' => $this->solution,
      // 'solution_time' => $this->solution_time,
      // 'feedback' => $this->feedback,
       'attachment' => $this->attachment
      ];
    }
}
