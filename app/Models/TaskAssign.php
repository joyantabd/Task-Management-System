<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAssign extends Model
{
    use HasFactory;

    protected $fillable = ['task_id','team_id','member_id','dead_line','status','priority','description','file'];
    public const ACTIVE_STATUS = 1;
    const STATUS_ACTIVE = 1;
    public const ACTIVE_STATUS_TEXT = 'ACTIVE';
    public const APPROVED_TEXT = 'APPROVED';

    public const PRIORITY_URGENT_TEXT = 'URGENT';
    public const PRIORITY_HIGH_TEXT = 'HIGH';
    public const PRIORITY_MEDIUM_TEXT = 'MEDIUM';
    public const PRIORITY_LOW_TEXT = 'LOW';
    public const PENDING = 2;
    public const PENDING_TEXT = 'PENDING';
    const PHOTO_WIDTH = 800;
    const PHOTO_HEIGHT = 800;
    const PHOTO_THUMB_WIDTH = 200;
    const PHOTO_THUMB_HEIGHT = 200;
    const IMAGE_UPLOAD_PATH = 'images/uploads/task_assign/';
    const THUMB_IMAGE_UPLOAD_PATH = 'images/uploads/task_assign/thumb/';

    public function prepareData (array $input)
    {
        $info['task_id'] = $input['task_id'] ?? '';
        $info['team_id'] = $input['team_id'] ?? '';
        $info['member_id'] = $input['member_id'] ?? '';
        $info['dead_line'] = $input['dead_line'] ?? '';
        $info['status'] = $input['status'] ?? '';
        $info['priority'] = $input['priority'] ?? '';
        $info['description'] = $input['description'] ?? '';
        return $info;
    }

    public function getData(array $input)
    {
        $per_page = $input['per_page'] ?? 10;
        $query = self::query();
        if(!empty($input['search'])){
            $query->where('name','like','%'.$input['search'].'%');
        }
        if(!empty($input['order_by'])){
            $query->orderBy($input['order_by'],$input['dirrection'] ?? 'asc');
        }

       return $query->paginate($per_page);
    }

    public function getDataId(array $input,$id)
    {
        $per_page = $input['per_page'] ?? 10;
        $query = self::where('member_id',$id);

        if(!empty($input['order_by'])){
            $query->orderBy($input['order_by'],$input['dirrection'] ?? 'asc');
        }

       return $query->paginate($per_page);
    }

}
