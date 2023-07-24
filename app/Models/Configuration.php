<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use \App\Traits\AuditLog;

    protected $table = 'configurations';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        // static::addGlobalScope(new OrganizationScope());

        static::updating(function ($eloquent) {
            $eloquent->adjust(auth()->user()->id);
        });
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'added_by');
    }

    public function child_configurations()
    {
        return $this->hasMany(Configuration::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne(Configuration::class, 'id', 'parent_id');
    }
}
