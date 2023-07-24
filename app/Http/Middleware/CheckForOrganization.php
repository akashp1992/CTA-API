<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use Closure;
use Illuminate\Support\Facades\Validator;

class CheckForOrganization
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    
    public function handle($request, Closure $next)
    {
        $request->request->add(['identifier' => $request->header('identifier')]);
        $validator = Validator::make($request->header(), ['identifier' => 'required']);
        if ($validator->fails()) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => 201,
                    'message' => $validator->getMessageBag()->first()
                ]);
        }

        $organization = Organization::where('identifier', $request->header('identifier'))->first();
        if (!isset($organization)) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => 401,
                    'message' => 'No record found for the given identifier.'
                ]);
        }

        if ($organization->is_active == 0) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => 401,
                    'message' => 'Organization is deactivated, Please contact support team.'
                ]);
        }

        // $request->request->add(['organization' => $organization->toArray()]);
         $request->request->add(['organization_id' => $organization->id]);
        return $next($request);
    }
}
