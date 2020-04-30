<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Phonebooks extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'parent_id'   => $this->parent_id,
            'title'       => $this->title,
            'full_name'   => $this->full_name,
            'description' => $this->description,
            'site'        => $this->site,
            'address'     => $this->address,
            'email'       => $this->email,
            'phonebooks'  => Phonebooks::collection($this->phonebooks),
            'contacts'    => $this->contacts,
        ];
    }
}
