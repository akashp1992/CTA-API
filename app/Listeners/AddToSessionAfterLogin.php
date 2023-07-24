<?php

namespace App\Listeners;

class AddToSessionAfterLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $auth_user = auth()->user();
        if (isset($auth_user->organization)) {
            session()->put('organization_id', $auth_user->organization->id);
            session()->put('organization_name', $auth_user->organization->name);
            session()->put('organization', $auth_user->organization);

            $organization_currency = !empty($auth_user->organization->currency_code) ? $auth_user->organization->currency_code : 'KWD';
            session()->put('organization_currency', $organization_currency);
        }
    }
}
