<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','description','status','priority','photo'];
    public const ACTIVE_STATUS = 1;
    const STATUS_ACTIVE = 1;
    public const ACTIVE_STATUS_TEXT = 'ACTIVE';
    public const INACTIVE_STATUS_TEXT = 'INACTIVE';

    public const PRIORITY_URGENT_TEXT = 'URGENT';
    public const PRIORITY_HIGH_TEXT = 'HIGH';
    public const PRIORITY_MEDIUM_TEXT = 'MEDIUM';
    public const PRIORITY_LOW_TEXT = 'LOW';
    const PHOTO_WIDTH = 800;
    const PHOTO_HEIGHT = 800;
    const PHOTO_THUMB_WIDTH = 200;
    const PHOTO_THUMB_HEIGHT = 200;
    const IMAGE_UPLOAD_PATH = 'images/uploads/task/';
    const THUMB_IMAGE_UPLOAD_PATH = 'images/uploads/task/thumb/';

    public function prepareData (array $input)
    {
        $info['name'] = $input['name'] ?? '';
        $info['slug'] = $input['slug'] ?? '';
        $info['description'] = $input['description'] ?? '';
        $info['status'] = $input['status'] ?? '';
        $info['priority'] = $input['priority'] ?? '';
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

    public function getDataIdName(){
        return self::query()->select('id','name')->where('status',self::STATUS_ACTIVE)->orderBy('name','asc')->get();
    }
}
