<?php

namespace App\Http\Resources;

use App\Manager\ImageManager;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            'slug' =>$this->slug,
            'description' =>$this->description,
            'original_status' =>$this->status,
            'status' =>$this->status == Team::ACTIVE_STATUS ? Team::ACTIVE_STATUS_TEXT : Team::INACTIVE_STATUS_TEXT,
            'photo' => ImageManager::imageUrl(Team::THUMB_IMAGE_UPLOAD_PATH,$this->photo),
            'photo_full' => ImageManager::imageUrl(Team::IMAGE_UPLOAD_PATH,$this->photo),
            'created_at' =>$this->created_at->toDateTimeString(),
            'updated_at' => $this->created_at != $this->updated_at ? $this->updated_at->format('d-M-y') : 'Not Updated',

        ];
    }
}
