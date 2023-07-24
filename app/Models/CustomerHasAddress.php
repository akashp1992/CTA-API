<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerHasAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customer_has_addresses';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
