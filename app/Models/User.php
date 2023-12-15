<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = ['name','email','phone','status','password','photo'];
    public const ACTIVE_STATUS = 1;
    public const ACTIVE_STATUS_TEXT = 'ACTIVE';
    public const INACTIVE_STATUS_TEXT = 'INACTIVE';
    const PHOTO_WIDTH = 800;
    const PHOTO_HEIGHT = 800;
    const PHOTO_THUMB_WIDTH = 150;
    const PHOTO_THUMB_HEIGHT = 150;
    const IMAGE_UPLOAD_PATH = 'images/uploads/user/full/';
    const THUMB_IMAGE_UPLOAD_PATH = 'images/uploads/user/thumb/';

    public function prepareData (array $input)
    {
        $info['name'] = $input['name'] ?? '';
        $info['email'] = $input['email'] ?? '';
        $info['phone'] = $input['phone'] ?? '';
        $info['photo'] = $input['photo'] ?? '';
        $info['description'] = $input['description'] ?? '';

        return $info;
    }

    public function getData(array $input)
    {
        $per_page = $input['per_page'] ?? 10;
        $query = self::query()->with('user:id,name','address','address.division:id,name','address.district:id,name','address.area:id,name');
        if(!empty($input['search'])){
            $query->where('name','like','%'.$input['search'].'%')
            ->orwhere('email','like','%'.$input['search'].'%')
            ->orwhere('phone','like','%'.$input['search'].'%');
        }
        if(!empty($input['order_by'])){
            $query->orderBy($input['order_by'],$input['dirrection'] ?? 'asc');
        }

       return $query->paginate($per_page);
    }




    public function branch() 
    {
        return $this->belongsTo(Branch::class);
    }

    public function address()
    {
        return $this->morphOne(Address::class,'addressable');
    }



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
