<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function products(){
        return $this->belongsToMany('App\Product','user_product_reference','user_id','product_id');
    }
    public function getUrlAttribute($value)
    {
      //  return 'http://127.0.0.1:8000/storage/'.$value;
      if(isset($value) && $value != ''){
        return config('constants.IMAGE_PATH').$value;
      }
    }
}
