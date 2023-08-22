<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
[
            'name' => $this->name,
            'age' => $this->age,
            'blood_type' => $this->blood_type,
            'city' => $this->city,
            
]  ;
  }
}
