<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    const GENDER = ['male', 'female'];
    const TYPE   = ['customer', 'admin'];

    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = !empty($value) ? Carbon::createFromTimestamp(strtotime($value)) : null;
    }

    public function addresses()
    {
        return $this->hasMany(CustomerHasAddress::class, 'customer_id', 'id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id', 'id');
    }

    public function admin_organizations()
    {
        return $this->hasMany(CustomerHasAdminOrganization::class, 'customer_id', 'id');
    }
}
