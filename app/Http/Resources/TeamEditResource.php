<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Manager\ImageManager;
use App\Models\Team;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamEditResource extends JsonResource
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
            'status' =>$this->status,
            'photo_preview' => ImageManager::prepareImageUrl(Team::THUMB_IMAGE_UPLOAD_PATH,$this->photo),
            'created_at' =>$this->created_at->toDateTimeString(),
            'updated_at' => $this->created_at != $this->updated_at ? $this->updated_at->format('d-M-y') : 'Not Updated',

        ];
    }
}
