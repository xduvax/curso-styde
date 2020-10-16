<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Models\UserProfile;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profession_id', 'age'
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

    public function profession()
    {
        return $this->belongsTo('App\Models\Profession');
    }

    public static function persistUser($data)
    {
        DB::transaction(function() use($data){

            $usuario = User::create([
                'name' => $data['name'],
                'profession_id' => $data['profession_id'],
                'age' => $data['age'],
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ]);
    
            UserProfile::create([
                'bio' => $data['bio'],
                'twitter' => $data['twitter'] ?? null,
                'user_id' => $usuario->id
            ]);
        });
    }

}
