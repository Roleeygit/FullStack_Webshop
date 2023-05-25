<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Profile extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
    [
        "id" => $this->id,
        "surname" => $this->surname ?? "Data is not provided yet!",
        "lastname" => $this->lastname ?? "Data is not provided yet!",
        "country" => $this->country ?? "Data is not provided yet!",
        "city" => $this->city ?? "Data is not provided yet!",
        "address" => $this->address ?? "Data is not provided yet!",
        "order_date" => $this->order_date ?? "Data is not provided yet!",
        "cardnumber" => $this->cardnumber ?? "Data is not provided yet!",
        "payment_mode" => $this->payment_mode->payment_mode ?? "Data is not provided yet!",
        "delivery_mode" => $this->delivery_mode->delivery_mode ?? "Data is not provided yet!"
    ];
    }
}