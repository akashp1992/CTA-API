<?php

namespace App\Observers;

use App\Models\Supplier;

class SupplierObserver
{
    /**
     * Handle the Supplier "created" event.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return void
     */
    public function creating(Supplier $supplier)
    {
        if (Auth::check()) {
            $supplier->created_by = Auth::user()->id;
            $supplier->updated_by = Auth::user()->id;
        }
    }

    /**
     * Handle the Supplier "updated" event.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return void
     */
    public function updating(Supplier $supplier)
    {
        if (Auth::check()) {
            $supplier->updated_by = Auth::user()->id;
        }
    }

    /**
     * Handle the Supplier "deleted" event.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return void
     */
    public function deleting(Supplier $supplier)
    {
        if (Auth::check()) {
            $supplier->deleted_by = Auth::user()->id;
        }
    }

    /**
     * Handle the Supplier "restored" event.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return void
     */
    public function restored(Supplier $supplier)
    {
        //
    }

    /**
     * Handle the Supplier "force deleted" event.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return void
     */
    public function forceDeleted(Supplier $supplier)
    {
        //
    }
}
