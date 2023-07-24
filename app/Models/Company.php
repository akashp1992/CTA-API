<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use CreateAndUpdateTrait, SoftDeletes;

    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $hidden = [''];
    protected $casts = [];

    public function organization()
    {
        return $this->hasOne(Organization::class, 'id', 'organization_id');
    }

    public function coupon()
    {
        return $this->hasMany(Coupon::class, 'company_id', 'id');
    }
}
