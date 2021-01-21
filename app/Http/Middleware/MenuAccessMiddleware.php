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

        $menu = Menu::where('link', $request->fullUrl())
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
                return redirect()->route('page.not_found');
            }
        }
        else {
            return redirect()->route('page.not_found');
        }
        // return $next($request);
    }
}
