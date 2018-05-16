<?php

namespace App\Http\Middleware;

use App\accounting\Role;
use App\accounting\rolerightsfield;
use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckGroup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$controller)
    {
        $result = Role::where('ID','=',$request->user()->is_permission)
            ->first();
        if ($controller == 'Main'){
            if ($result->name == 'client'){
                return redirect('ClientPortal');
            }

        }
        if ($controller == 'Client'){

            if ($result->name != 'client'){
                return redirect('home');
            }
        }



        return $next($request);
    }
}
