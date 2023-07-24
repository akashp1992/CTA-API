<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        $subdomain = count(explode('.', request()->getHost())) == 3 ? explode('.', request()->getHost())[0] : 'console';
        if (in_array($subdomain, ['console', 'staging'])) {
            return $request->only($this->username(), 'password');
        }

        $organization_id                     = Organization::where('identifier', $subdomain)->value('id');
        $login_attributes                    = $request->only($this->username(), 'password');
        $login_attributes['organization_id'] = $organization_id;
        return $login_attributes;
    }
}
