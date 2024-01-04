<?php

namespace App\Http\Resources;

use App\Models\User;
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
        return [
            'id' => $this->uuid,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'bvn' => $this->bvn,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'picture' => $this->photo,
            'is_pin_created' => !empty($this->pin),
            'is_account_suspended' => (bool) $this->is_active == User::IN_ACTIVE
        ];

    }
}
