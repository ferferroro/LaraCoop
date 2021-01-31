<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{SystemUser, UserMenu};
use Illuminate\Support\Facades\{DB, View, Auth, Hash};
use Session;

class SystemUserController extends Controller
{
    /**
     * Require AUth and menu access
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'menu_access']); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_string = $request['search_string'] ?? '';

        $system_users = SystemUser:: where('search_text', 'like', '%' . $search_string . '%' )
            ->paginate(15);

        return view('pages.system_users')
            ->with('system_users',  $system_users)
            ->with('search_string', $search_string);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $borrowers = DB::table('borrowers')->get();
        $members = DB::table('members')->get();
        $menus = DB::table('menus')->get();

        return view('pages.system_user_add')
            ->with('members', $members)
            ->with('borrowers', $borrowers)
            ->with('menus', $menus);
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
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'contact' => 'required|string|max:255',
            'borrower_id' => 'nullable|exists:borrowers,id',
            'member_id' => 'nullable|exists:members,id',
            'side_bg_color' => 'required|string|max:255',
            'side_active_color' => 'required|string|max:255',
            // 'can_approve_loans' => 'required|boolean',
            // 'can_apprrove_contributions' => 'required|boolean',
            // 'can_transfer_funds' => 'required|boolean',
            // 'can_view_other_records' => 'required|boolean',
            // 'can_update_records' => 'required|boolean',
            'menus' => 'required|array'
        ]);

        // return $validated;
        

        DB::beginTransaction();
        try {
            $system_user = new SystemUser;
            $system_user->fill($validated);
            $system_user->password = Hash::make($system_user->password);
            $system_user->can_approve_loans = $request->has('can_approve_loans');
            $system_user->can_apprrove_contributions = $request->has('can_apprrove_contributions');
            $system_user->can_transfer_funds = $request->has('can_transfer_funds');
            $system_user->can_view_other_records = $request->has('can_view_other_records');
            $system_user->can_update_records = $request->has('can_update_records');
            $system_user->save();
            $system_user->refresh();

            $sequence = 1;
            foreach ($validated['menus'] as $menu) {
                $user_menu = new UserMenu;
                $user_menu->user_id = $system_user->id;
                $user_menu->menu_id = $menu;
                $user_menu->sequence = $sequence;

                $user_menu->save();
                $sequence += 1;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Session::flash('success_message', "System User has been added!");

        return redirect()->route('system_user.index');
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
        $system_user_id = $request['id'] ?? 0;
        $system_user = SystemUser::findOrFail($system_user_id);

        $borrowers = DB::table('borrowers')->get();
        $members = DB::table('members')->get();
        $menus = DB::table('menus')->get();
        $user_menus = DB::table('user_menus')
            ->select('menu_id')
            ->where('user_id', $system_user_id )    
            ->get();

        return view('pages.system_user_edit')
            ->with('system_user',  $system_user)
            ->with('members', $members)
            ->with('borrowers', $borrowers)
            ->with('menus', $menus)
            ->with('user_menus', $user_menus);
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
            
            'borrower_id' => 'nullable|exists:borrowers,id',
            'member_id' => 'nullable|exists:members,id',
            'menus' => 'required|array'
        ]);

        $system_user_id = $request['id'] ?? 0;
        $system_user = SystemUser::findOrFail($system_user_id);
        $system_user->fill($validated);

        DB::beginTransaction();
        try {
            $system_user->can_approve_loans = $request->has('can_approve_loans');
            $system_user->can_apprrove_contributions = $request->has('can_apprrove_contributions');
            $system_user->can_transfer_funds = $request->has('can_transfer_funds');
            $system_user->can_view_other_records = $request->has('can_view_other_records');
            $system_user->can_update_records = $request->has('can_update_records');
            $system_user->save();
            $system_user->refresh();

            // get old user menus
            $old_user_menus = UserMenu::where('user_id', $system_user_id)->get();
            foreach($old_user_menus as $old_user_menu) {
                
                // filter what needs to stay 
                $delete_user_menu = true;
                foreach ($validated['menus'] as $menu) {
                    // keep the existing menu
                    if ($old_user_menu->menu_id == $menu) {
                        $delete_user_menu = false;
                        break;
                    }
                }

                // delete all existing menu that is not part of the update
                if($delete_user_menu == true) {
                    UserMenu::find($old_user_menu->id)->delete();
                }

                // save the last sequence number
                $sequence = $old_user_menu->sequence;
            }
            
            $sequence += 1;
            foreach ($validated['menus'] as $menu) {

                $existing_user_menu = UserMenu::where('user_id', $system_user_id)
                    ->where('menu_id', $menu)
                    ->first();
                
                if(!$existing_user_menu) {
                    $user_menu = new UserMenu;
                    $user_menu->user_id = $system_user->id;
                    $user_menu->menu_id = $menu;
                    $user_menu->sequence = $sequence;

                    $user_menu->save();
                    $sequence += 1;
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        
        Session::flash('success_message', "System User ID [' $system_user_id '] has been updated!");

        return redirect()->route('system_user.edit', ['id' => $system_user_id]);

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
