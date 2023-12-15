<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccessLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' =>  User::whereId($this->user_id)->pluck('name')->first(),
            'subject' => $this->subject,
            'url' => $this->url,
            'ip' => $this->ip,
            'agent' => $this->agent,
            'created_at' =>$this->created_at->toDateTimeString(),
        ];
    }
}
