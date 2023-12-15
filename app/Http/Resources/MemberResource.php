<?php

namespace App\Http\Resources;

use App\Manager\ImageManager;
use App\Models\Member;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'phone' =>$this->phone,
            'email' =>$this->email,
            'original_status' =>$this->status,
            'team_info' =>  Team::whereId($this->team_id)->first(),
            'status' =>$this->status == Member::ACTIVE_STATUS ? Member::ACTIVE_STATUS_TEXT : Member::INACTIVE_STATUS_TEXT,
            'photo' => ImageManager::imageUrl(Member::THUMB_IMAGE_UPLOAD_PATH,$this->photo),
            'photo_full' => ImageManager::imageUrl(Member::IMAGE_UPLOAD_PATH,$this->photo),
            'created_at' =>$this->created_at->toDateTimeString(),
            'updated_at' => $this->created_at != $this->updated_at ? $this->updated_at->format('d-M-y') : 'Not Updated',

        ];
    }
}
