<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use CreateAndUpdateTrait, SoftDeletes;

    protected $table = 'branches';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function organization()
    {
        return $this->hasOne(Organization::class, 'id', 'organization_id');
    }

    public function categories()
    {
        return $this->hasMany(ServiceCategory::class, 'branch_id', 'id');
    }
}
