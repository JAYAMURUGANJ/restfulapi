<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_number',
        'device_name',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    //add dummy column 
   // protected $appends = ['avatar'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //adding gravatar in laravel for image url
   // public function getAvatarAttribute(){
   //     return "https://www.gravatar.com/avatar/". md5(strtolower(trim($this->email)));
   // }

    //relationship with posts table to the user table
   public function posts()
   {
       return $this->hasMany(Post::class,'user_id');
   }

}
