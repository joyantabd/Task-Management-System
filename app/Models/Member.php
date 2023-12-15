<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Member extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name','phone','password','team_id','email','status','photo'];
    public const ACTIVE_STATUS = 1;
    public const ACTIVE_STATUS_TEXT = 'ACTIVE';
    public const INACTIVE_STATUS_TEXT = 'INACTIVE';
    const PHOTO_WIDTH = 800;
    const PHOTO_HEIGHT = 800;
    const PHOTO_THUMB_WIDTH = 200;
    const PHOTO_THUMB_HEIGHT = 200;
    const IMAGE_UPLOAD_PATH = 'images/uploads/member/';
    const THUMB_IMAGE_UPLOAD_PATH = 'images/uploads/member/thumb/';

    public function prepareData (array $input)
    {
        $info['name'] = $input['name'] ?? '';
        $info['phone'] = $input['phone'] ?? '';
        $info['email'] = $input['email'] ?? '';
        $info['status'] = $input['status'] ?? '';
        $info['team_id'] = $input['team_id'] ?? '';
        
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

    public function team() 
    {
        return $this->belongsTo(Team::class);
    }

    public function getDataIdName(){
        return self::query()->select('id','name')->where('status',self::ACTIVE_STATUS)->orderBy('name','asc')->get();
    }

    public function getMemberByTeamId($id){
        return self::query()->where('team_id',$id)->select('id','name','phone','email')->get();
    }
}
