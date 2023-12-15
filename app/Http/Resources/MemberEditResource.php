<?php

namespace App\Http\Resources;

use App\Manager\ImageManager;
use App\Models\Member;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberEditResource extends JsonResource
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
            'name' =>$this->name,
            'email' =>$this->email,
            'phone' =>$this->phone,
            'status' =>$this->status,
            'team_id' =>$this->team_id,
            'photo_preview' => ImageManager::prepareImageUrl(Member::THUMB_IMAGE_UPLOAD_PATH,$this->photo),
            'created_at' =>$this->created_at->toDateTimeString(),
            'updated_at' => $this->created_at != $this->updated_at ? $this->updated_at->format('d-M-y') : 'Not Updated',

        ];
    }
}
