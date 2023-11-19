<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "phone"=> $this->phone,
            "email"=> $this->email,
            "whatsapp_link"=> $this->whatsapp_link,
            "live_chat"=> $this->live_chat,
        ];
    }
}
