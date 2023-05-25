<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
        [
            "id" => $this->id,
            "username" => $this->username,
            "email" => $this->email,
            "password" => $this->password,
            "is_admin" => $this->is_admin,
            "remember_token" => $this->remember_token ?? "Data is not provided yet!",
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
