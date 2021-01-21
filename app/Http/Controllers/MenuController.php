<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Menu, UserMenu};
use Illuminate\Support\Facades\{DB, View, Auth};
use App\Helper\Helper;

class MenuController extends Controller
{
    /**
     * Setup default menu
     *
     * @return \Illuminate\Http\Response
     */
    public function setup()
    {

        DB::beginTransaction();
        try {

            // create default dashboard menu
            $route = 'home';
            $menu = new Menu;
            $menu->fill(
                [
                    'element_name' => 'dashboard',
                    'display_name' => 'Dashboard',
                    'route' => $route,
                    'link' => route($route),
                    'sequence' => 1,
                    'icon_class' => 'nc-icon nc-bank',
                    'restricted' => false
                ]
            );
            $menu->save();
            $menu->refresh();

            // user menu
            $user_menu = new UserMenu;
            $user_menu->fill(
                [
                    'user_id' => Auth::id(),
                    'menu_id' => $menu->id,
                    'sequence' => $menu->sequence,
                    'updated_by' => Auth::id()
                ]
            );
            $user_menu->save();

            

            // create default company menu
            $route = 'company.index';
            $menu = new Menu;
            $menu->fill(
                [
                    'element_name' => 'company',
                    'display_name' => 'Company',
                    'route' => $route,
                    'link' => route($route),
                    'sequence' => 2,
                    'icon_class' => 'nc-icon nc-shop',
                    'restricted' => false
                ]
            );
            $menu->save();
            $menu->refresh();

            // user menu
            $user_menu = new UserMenu;
            $user_menu->fill(
                [
                    'user_id' => Auth::id(),
                    'menu_id' => $menu->id,
                    'sequence' => $menu->sequence,
                    'updated_by' => Auth::id()
                ]
            );
            $user_menu->save();




            // create default member menu
            $route = 'member.index';
            $menu = new Menu;
            $menu->fill(
                [
                    'element_name' => 'members',
                    'display_name' => 'Members',
                    'route' => $route,
                    'link' => route($route),
                    'sequence' => 3,
                    'icon_class' => 'nc-icon nc-layout-11',
                    'restricted' => false
                ]
            );
            $menu->save();
            $menu->refresh();

            // user menu
            $user_menu = new UserMenu;
            $user_menu->fill(
                [
                    'user_id' => Auth::id(),
                    'menu_id' => $menu->id,
                    'sequence' => $menu->sequence,
                    'updated_by' => Auth::id()
                ]
            );
            $user_menu->save();



            // create default borrower menu
            $route = 'borrower.index';
            $menu = new Menu;
            $menu->fill(
                [
                    'element_name' => 'borrowers',
                    'display_name' => 'Borrowers',
                    'route' => $route,
                    'link' => route($route),
                    'sequence' => 4,
                    'icon_class' => 'nc-icon nc-badge',
                    'restricted' => false
                ]
            );
            $menu->save();
            $menu->refresh();

            // user menu
            $user_menu = new UserMenu;
            $user_menu->fill(
                [
                    'user_id' => Auth::id(),
                    'menu_id' => $menu->id,
                    'sequence' => $menu->sequence,
                    'updated_by' => Auth::id()
                ]
            );
            $user_menu->save();



            // create default contribution menu
            $route = 'contribution.index';
            $menu = new Menu;
            $menu->fill(
                [
                    'element_name' => 'contributions',
                    'display_name' => 'Contributions',
                    'route' => $route,
                    'link' => route($route),
                    'sequence' => 5,
                    'icon_class' => 'nc-icon nc-chart-pie-36',
                    'restricted' => false
                ]
            );
            $menu->save();
            $menu->refresh();

            // user menu
            $user_menu = new UserMenu;
            $user_menu->fill(
                [
                    'user_id' => Auth::id(),
                    'menu_id' => $menu->id,
                    'sequence' => $menu->sequence,
                    'updated_by' => Auth::id()
                ]
            );
            $user_menu->save();



            // create default loan menu
            $route = 'loan.index';
            $menu = new Menu;
            $menu->fill(
                [
                    'element_name' => 'loans',
                    'display_name' => 'Loans',
                    'route' => $route,
                    'link' => route($route),
                    'sequence' => 6,
                    'icon_class' => 'nc-icon nc-money-coins',
                    'restricted' => false
                ]
            );
            $menu->save();
            $menu->refresh();

            // user menu
            $user_menu = new UserMenu;
            $user_menu->fill(
                [
                    'user_id' => Auth::id(),
                    'menu_id' => $menu->id,
                    'sequence' => $menu->sequence,
                    'updated_by' => Auth::id()
                ]
            );
            $user_menu->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // change this later on to the user menu!
        $first_menu = Menu::orderBy('sequence','asc')->first();

        return redirect()->route($first_menu->route);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setup_view()
    {
        if ( Helper::hasMenu() ) {
            // change this later on to the user menu!
            $first_menu = Menu::orderBy('sequence','asc')->first();
            return redirect()->route($first_menu->route);
        }
        else {
            return view('pages.setup_menu');
        }

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
