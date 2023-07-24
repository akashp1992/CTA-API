<?php

namespace App\Traits;

use App\Models\User;

trait AuditLog
{
    public function adjustments()
    {
        return $this->belongsToMany(User::class, 'audit_logs', 'reference_id', 'user_id')
            ->withTimestamps()
            ->withPivot(['before', 'after'])
            ->latest('pivot_updated_at');
    }

    public function adjust($user_id = null, $diff = null, $is_create = false)
    {
        $user_id = $user_id ?: 1;
        if (!$is_create) {
            $diff = $diff ?: $this->getDiff();
        } else {
            $diff = $this->getCreate();
        }

        return $this->adjustments()->attach($user_id, $diff);
    }

    protected function getDiff()
    {
        $changed = $this->getDirty();
        $module  = $this->table;
        $before  = json_encode(array_intersect_key($this->fresh()->toArray(), $changed));
        $after   = json_encode($changed);

        return compact('module', 'before', 'after');
    }

    protected function getCreate()
    {
        $module = $this->table;
        $before = json_encode([$module => null]);
        $after  = json_encode([$module => 'Created']);
        return compact('module', 'before', 'after');
    }
}
