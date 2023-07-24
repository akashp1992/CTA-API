<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

class CheckForCustomerAccess
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
        $request->request->add(['token' => $request->header('Authorization')]);
        $data      = $request->all();
        $validator = Validator::make($data, ['customer_id' => 'required|integer', 'token' => 'required']);
        if ($validator->fails()) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => 201,
                    'message' => $validator->getMessageBag()->first()
                ]);
        }

        $user = validate_customer_and_session_token($data['customer_id'], $data['token']);
        if (!$user) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => 401,
                    'message' => 'Unauthorized.'
                ]);
        }

        return $next($request);
    }
}
