<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupHasAccess extends Model
{
    protected $table = 'group_has_accesses';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
