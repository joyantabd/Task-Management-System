<?php

namespace App\Http\Resources;

use App\Manager\ImageManager;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->priority == 1){$PRIORITY_TEXT = Task::PRIORITY_URGENT_TEXT;}
        elseif($this->priority == 2){$PRIORITY_TEXT = Task::PRIORITY_HIGH_TEXT;}
        elseif($this->priority == 3){$PRIORITY_TEXT = Task::PRIORITY_MEDIUM_TEXT;}
        else{$PRIORITY_TEXT = Task::PRIORITY_LOW_TEXT;}

        return [
            'id' => $this->id,
            'name' =>$this->name,
            'slug' =>$this->slug,
            'description' =>$this->description,
            'original_status' =>$this->status,
            'status' =>$this->status == Task::ACTIVE_STATUS ? Task::ACTIVE_STATUS_TEXT : Task::INACTIVE_STATUS_TEXT,
            'original_priority' =>$this->priority,
            'priority' => $PRIORITY_TEXT,
            'photo' => ImageManager::imageUrl(Task::THUMB_IMAGE_UPLOAD_PATH,$this->photo),
            'photo_full' => ImageManager::imageUrl(Task::IMAGE_UPLOAD_PATH,$this->photo),
            'created_at' =>$this->created_at->toDateTimeString(),
            'updated_at' => $this->created_at != $this->updated_at ? $this->updated_at->format('d-M-y') : 'Not Updated',

        ];
    }
}
