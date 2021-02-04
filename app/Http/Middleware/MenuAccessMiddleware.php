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

                $route_name = $request->route()->getName();

                // user does not have access to approve contributions throw an error
                if ($user->can_approve_contributions == false && $route_name == 'contribution.approve') {
                    return abort(404);
                }

                // user does not have access to approve loans throw an error
                if ($user->can_approve_loans == false && $route_name == 'loan.approve') {
                    return abort(404);
                }

                return $next($request);
            }
            else {

                // anything that request home - redirect to first user menu
                if ($prefix == 'home') {
                    $user_menu = UserMenu::where('user_id', $user->id)
                        ->orderBy('sequence', 'asc')
                        ->first();

                    
                    if ($user_menu) {
                        $menu = Menu::where('id', $user_menu->menu_id)
                            ->first();

                        if ($menu) {
                            // if this is home then we will be stuck un a loop calling its own route
                            if ($menu->route == 'home') {
                                return view('pages.dashboard');
                            }
                            else {
                                return redirect()->route($menu->route);
                            }
                            
                        }   
                        else {
                            return abort(404);
                        } 
                    }
                }

                return abort(404);
            }
        }
        else {

            // case no menu , then allow the setup menu to be accessed
            if ($request->route()->getName() == 'menu.setup_view' || $request->route()->getName() == 'menu.setup') {
                return $next($request);
            }

            return abort(404);
        }
    }
}
