<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Menu, UserMenu};
use Illuminate\Support\Facades\{DB, View, Auth};
use App\Helper\Helper;
use Session;

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




            // create default menu
            $route = 'menu.index';
            $menu = new Menu;
            $menu->fill(
                [
                    'element_name' => 'menus',
                    'display_name' => 'Menus',
                    'route' => $route,
                    'link' => route($route),
                    'sequence' => 7,
                    'icon_class' => 'nc-icon nc-single-copy-04',
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
    public function index(Request $request)
    {
        
        $search_string = $request['search_string'] ?? '';

        $menus = Menu:: where('search_text', 'like', '%' . $search_string . '%' )
            ->paginate(15);

        return view('pages.menus')
            ->with('menus',  $menus)
            ->with('search_string', $search_string);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.menu_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'display_name' => 'required|string|max:255',
            'element_name' => 'required|string|max:255',
            'route' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'sequence' => 'required|numeric|min:0',
            'icon_class' => 'required|string|max:255',
        ]);

        $menu = new Menu;
        $menu->fill($validated);
        $menu->save();
        $menu->refresh();
        
        Session::flash('success_message', "Menu ID [' $menu->id '] has been added!");

        return redirect()->route('menu.index');
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
    public function edit(Request $request)
    {
        $menu_id = $request['id'] ?? 0;

        $menu = Menu::findOrFail($menu_id);

        return view('pages.menu_edit')
            ->with('menu',  $menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'display_name' => 'required|string|max:255',
            'element_name' => 'required|string|max:255',
            'route' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'sequence' => 'required|numeric|min:0',
            'icon_class' => 'required|string|max:255',
        ]);

        $menu_id = $request['id'] ?? 0;
        $menu = Menu::findOrFail($menu_id);

        $menu->fill($validated);
        $menu->save();
        
        Session::flash('success_message', "Menu ID [' $menu_id '] has been updated!");

        return redirect()->route('menu.edit', ['id' => $menu_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // find the record and delete it
        $menu_id = $request['id'] ?? 0;
        $menu = Menu::findOrFail($menu_id);
        $menu->delete();

        // create success message 
        Session::flash('success_message', "menu ID [' $menu_id '] has been deleted!");

        // go back to the menu lists
        return redirect()->route('menu.index');
    }
}
