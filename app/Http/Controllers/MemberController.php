<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use Illuminate\Support\Facades\DB;
use Session;

class MemberController extends Controller
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
        
        $members = DB::table('members')
                ->where('search_text', 'like', '%' . $search_string . '%' )
                ->paginate(15);

        return view('pages.members')
            ->with('members',  $members)
            ->with('search_string', $search_string);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.member_add');
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
            'order' => 'required|integer',
            'address' => 'required|string|max:255',
            'monthly_contribution' => 'required|numeric|min:1',
            'distribution_schedule' => 'required|date',
            'primary_contact' => 'required|string|max:255',

        ]);

        $member = new Member;
        $member->fill($validated);
        $member->search_text = $member->name . ' ' . $member->order . ' ' . $member->address . ' ' . $member->primary_contact; 
        $member->save();
        $member->refresh();

        // get back to members list and show only this record
        // $members = DB::table('members')
        //         ->where('id', '=', $member->id )
        //         ->paginate(15);

        // return view('pages.members')
        //     ->with('members',  $members)
        //     ->with('search_string', $member->search_text);
        
        Session::flash('success_message', "Member ID [' $member->id '] has been added!");

        return redirect()->route('member.index');

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

        $member_id = $request['id'] ?? 0;

        $member = Member::findOrFail($member_id);

        return view('pages.member_edit')
            ->with('member',  $member);

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
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'address' => 'required|string|max:255',
            'monthly_contribution' => 'required|numeric|min:1',
            'total_contribution' => 'required|numeric|min:1',
            'distribution_schedule' => 'required|date',
            'primary_contact' => 'required|string|max:255',

        ]);

        $member_id = $request['id'] ?? 0;
        $member = Member::findOrFail($member_id);

        $member->fill($validated);
        $member->search_text = $member->name . ' ' . $member->order . ' ' . $member->address . ' ' . $member->primary_contact; 
        $member->save();
        
        Session::flash('success_message', "Member ID [' $member_id '] has been updated!");

        return redirect()->route('member.edit', ['id' => $member_id]);
    
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
        $member_id = $request['id'] ?? 0;
        $member = Member::findOrFail($member_id);
        $member->delete();

        // create success message 
        Session::flash('success_message', "Member ID [' $member_id '] has been deleted!");

        // go back to the member lists
        return redirect()->route('member.index');

    }
}
