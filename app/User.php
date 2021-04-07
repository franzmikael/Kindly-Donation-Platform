<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    Use HasApiTokens, Notifiable;

    protected $table = 'm_user';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_name','user_mail','user_phone','user_foto','user_password'
    ];
    
    protected $hidden = [
        'user_password'
    ];

    public function getAuthPassword()
    {
        return $this->user_password;
    }
    
    public function setPasswordAttribute($password)
    {
        $this->attributes['user_password'] = bcrypt($password);
    }
}