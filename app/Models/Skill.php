<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_skill');
    }
}
