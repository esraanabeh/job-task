<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;
use App\Traits\FileUpload;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , FileUpload;
    protected $fillable = [
        'first_name', 'last_name' ,'phone' ,'email','password', 'country_id' ,'birthDate' , 'view'
    ];

   
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function image()
    {
        return $this->morphOne(File::class, 'fileable');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function posts() {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }
}
