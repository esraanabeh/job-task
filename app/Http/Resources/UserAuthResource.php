<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $success['token'] =  $this->createToken('MyApp')->accessToken;
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name ,
            'email' =>  $this->email,
            'phone' => $this->phone,
            'country_id' => $this->country_id,
            'image' => url($this->image->url) ?? '',
            'birth_date' => $this->birthDate	?? '',
            'token' => 'Bearer ' . $success['token'],
        ];
    
    }
}
