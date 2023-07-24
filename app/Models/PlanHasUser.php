<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanHasUser extends Model
{
    use HasFactory,SoftDeletes;

    public function users()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function userList()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    public function planList()
    {
        return $this->hasMany(Plan::class, 'id', 'plan_id');
    }
}
