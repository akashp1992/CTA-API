<?php

namespace App;

use App\Models\Booking;
use App\Models\Group;
use App\Models\Organization;
use App\Models\UserHasWorkingHour;
use App\Traits\CreateAndUpdateTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, CreateAndUpdateTrait;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime',];

    const GENDER = ['male', 'female'];

    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function organization()
    {
        return $this->hasOne(Organization::class, 'id', 'organization_id');
    }

    public function working_hours()
    {
        return $this->hasMany(UserHasWorkingHour::class, 'user_id', 'id');
    }
}
