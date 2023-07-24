<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerHasAdminOrganization extends Model
{
    use HasFactory;

    protected $table = 'customer_has_admin_organizations';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
