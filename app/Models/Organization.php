<?php

namespace App\Models;

use App\Traits\AuditLog;
use App\Traits\CreateAndUpdateTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes, CreateAndUpdateTrait, AuditLog;

    protected $table = 'organizations';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    const PAYMENT_GATEWAYS = [
        'fatoorah',
        'u-payments'
    ];

    const CURRENCIES = [
        'KD'  => 'Kuwait Dinar',
        'USD' => 'United States Dollar',
        'AED' => 'Emirati Dirham'
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($eloquent) {
            $eloquent->adjust(auth()->user()->id);
        });
    }

    public function users()
    {
        return $this->hasMany(User::class, 'organization_id', 'id');
    }

    public function audit_logs()
    {
        return $this->hasMany(AuditLogModal::class, 'reference_id', 'id')
            ->where('module', 'organizations');
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = !empty($value) ? Carbon::createFromTimestamp(strtotime($value)) : null;
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = !empty($value) ? Carbon::createFromTimestamp(strtotime($value)) : null;
    }
}
