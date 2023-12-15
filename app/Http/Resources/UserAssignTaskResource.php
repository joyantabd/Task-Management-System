<?php

namespace App\Http\Resources;

use App\Manager\ImageManager;
use App\Models\Member;
use App\Models\Task;
use App\Models\TaskAssign;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAssignTaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $task  = Task::whereId($this->task_id)->first();
        if($task->priority == 1){$PRIORITY_TEXT = TaskAssign::PRIORITY_URGENT_TEXT;}
        elseif($task->priority == 2){$PRIORITY_TEXT = TaskAssign::PRIORITY_HIGH_TEXT;}
        elseif($task->priority == 3){$PRIORITY_TEXT = TaskAssign::PRIORITY_MEDIUM_TEXT;}
        else{$PRIORITY_TEXT = TaskAssign::PRIORITY_LOW_TEXT;}
        if($this->status ==1){$status = TaskAssign::ACTIVE_STATUS_TEXT;}
        elseif($this->status ==2){$status = TaskAssign::PENDING_TEXT;}
        else{$status = TaskAssign::APPROVED_TEXT;}

        return [
            'id' => $this->id,
            'task_info' => Task::whereId($this->task_id)->first(),
            'status' => $status,
            'priority' => $PRIORITY_TEXT,
            'instruction' => $this->description,
            'dead_line' => $this->dead_line,
            'created_at' =>$this->created_at->toDateTimeString(),
            'task_photo' => ImageManager::imageUrl(Task::THUMB_IMAGE_UPLOAD_PATH,$task->photo),
            'task_photo_full' => ImageManager::imageUrl(Task::IMAGE_UPLOAD_PATH,$task->photo),
            'updated_at' => $this->created_at != $this->updated_at ? $this->updated_at->format('d-M-y') : 'Not Updated',

        ];
    }
}
