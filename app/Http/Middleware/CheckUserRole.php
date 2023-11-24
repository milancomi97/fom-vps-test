<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user() !== null){
            $userData=Auth::user()->load(['permission']);
            $permissions  =$userData->permission;
            $path = $request->path();
            $parts = explode('/', $path);
            $requiredModule = $parts[0];

            if($requiredModule=='osnovnipodaci' && $permissions->osnovni_podaci == true){
                return $next($request);
             } else if ($requiredModule=='osnovnipodaci' && $permissions->osnovni_podaci == true){
                return $next($request);

            }else{
             return redirect()->route('noPermission');
            }
        } else{
            return $next($request);
        }
    }

}
