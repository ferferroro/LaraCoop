<?php

namespace App\Http\Middleware;

use Closure;
use App\{Menu, UserMenu};
use Illuminate\Support\Facades\Auth;

class MenuAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd($request->fullUrl());
        $user = Auth::user();

        if ($user->is_master_account) {
            return $next($request);
        }

        $prefix = $request->route()->getPrefix();

        if (!$prefix) {
            $prefix = $request->route()->getName();
        }

        $prefix = str_replace("/","", $prefix);

        $menu = Menu::where('route', 'like', '%' . $prefix . '%')
            ->first();

        if ($menu) {
            
            $user_menu = UserMenu::where(
                [
                    [ 'user_id', $user->id],
                    [ 'menu_id', $menu->id]
                ]
                )->first();
            
            if ($user_menu) {
                return $next($request);
            }
            else {
                return abort(404);
            }
        }
        else {
            return abort(404);
        }
    }
}
