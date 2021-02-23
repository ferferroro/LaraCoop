<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Member ,Contribution, MemberAccount};
use Illuminate\Support\Facades\{DB, Auth};
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

        $user = Auth::user();

        // initilize query
        $members = (new Member)->newQuery();

        // initialize null match these arrays
        $match_these = [];
        $match_these[] =  [ 'search_text', 'like' , '%'. $search_string .'%' ];
        
        if($user->can_view_other_records == false) {
            $match_these[] =  [ 'id', '=' , $user->member_id ];
        }

        // add where clause
        $members = $members->where($match_these);
        $members = $members->paginate(15);

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
        $member->can_hold_fund = $request->has('can_hold_fund');
        $member->save();
        $member->refresh();
        
        Session::flash('success_message', "Member ID [' $member->id '] has been added!");

        return redirect()->route('member.index');

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

        $member = Member::with('member_accounts')
            ->findOrFail($member_id);
        
        return view('pages.member_edit')
            ->with('member',  $member)
            ->with('member_accounts', $member->member_accounts);

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
            // 'total_contribution' => 'required|numeric|min:0',
            'distribution_schedule' => 'required|date',
            'primary_contact' => 'required|string|max:255',

        ]);

        $member_id = $request['id'] ?? 0;
        $member = Member::findOrFail($member_id);

        $member->fill($validated);
        $member->can_hold_fund = $request->has('can_hold_fund');
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

        if ($member->total_contribution != 0 || $member->fund_on_hand != 0) {
            Session::flash('error_message', "Unable to delete! Member ID [' $member_id '] has Contributions or Fund on Hand!");

            return redirect()->route('member.edit', ['id' => $member_id]);
        }

        $member->delete();

        // create success message 
        Session::flash('success_message', "Member ID [' $member_id '] has been deleted!");

        // go back to the member lists
        return redirect()->route('member.index');

    }

    /**
     * Display a list of member's contributions
     *
     * @return \Illuminate\Http\Response
     */
    public function contributions(Request $request)
    {
        $search_string = $request['search_string'] ?? '';
        $member_id = $request['member_id'] ?? 0;

        // retrict viewing other records
        $user = Auth::user();
        if($user->can_view_other_records == false) {
            $member_id = $user->member_id;
        }
        
        $member = Member::where('id', $member_id)
            ->findOrFail($member_id);

        $member_contributions = Contribution::where('member_id', '=', $member_id )
            ->where('search_text', 'like', '%' . $search_string . '%' )
            ->paginate(15);

        return view('pages.member_contributions')
            ->with('member',  $member)
            ->with('member_contributions',  $member_contributions)
            ->with('search_string', $search_string);
    }

    /**
     * Get member interest percentage
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_member(Request $request)
    {
        // find the record and delete it
        $member_id = $request['id'] ?? 0;
        $member = Member::findOrFail($member_id);

        // go back to the index page
        return $member;
    }

    /**
     * Display  member's contribution detail
     *
     * @return \Illuminate\Http\Response
     */
    public function contribution_view(Request $request)
    {
        $contribution_id = $request['id'] ?? 0;

        $contribution = Contribution::findOrFail($contribution_id);
        $members = DB::table('members')->get();

        return view('pages.member_contribution_view')
            ->with('contribution',  $contribution)
            ->with('members',  $members);
    }

    /**
     * Add account view
     */
    public function add_account(Request $request)
    {
        // find the record and delete it
        $member_id = $request['member_id'] ?? 0;
        $member = Member::findOrFail($member_id);

        return view('pages.member_account_add')
            ->with('member', $member);
    }

    /**
     * Store account
     */
    public function store_account(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'bank' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'account' => 'required|string|max:255'
        ]);

        $member_account = new MemberAccount;
        $member_account->fill($validated);
        $member_account->save();
        $member_account->refresh();

        Session::flash('success_message', "Member Account [' $member_account->id '] has been added!");
      
        return redirect()->route('member.edit', ['id' => $member_account->member_id]);
    }

    /**
     * Edit account
     */
    public function edit_account(Request $request)
    {

        $member_account_id = $request['id'] ?? 0;

        $member_account = MemberAccount::with('member')
            ->findOrFail($member_account_id);
        
        return view('pages.member_account_edit')
            ->with('member_account', $member_account);
    }

    /**
     * Edit account
     */
    public function update_account(Request $request)
    {

        $validated = $request->validate([
            'bank' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'account' => 'required|string|max:255'
        ]);

        $member_account_id = $request['id'] ?? 0;
        $member_account = MemberAccount::findOrFail($member_account_id);

        $member_account->fill($validated);
        $member_account->save();
        
        Session::flash('success_message', "Member Account [' $member_account_id '] has been updated!");

        return redirect()->route('member.edit_account', ['id' => $member_account_id]);
    }

    /**
     * destrong account
     */
    public function destroy_account(Request $request)
    {

        // find the record and delete it
        $member_account_id = $request['id'] ?? 0;
        $member_account = MemberAccount::findOrFail($member_account_id);
        $member_id = $member_account->member_id;

        if ($member_account->amount != 0) {
            Session::flash('error_message', "Unable to delete! Member Account ID [' $member_account_id '] has amount stored on it!");

            return redirect()->route('member.edit_account', ['id' => $member_account_id]);
        }

        $member_account->delete();

        // create success message 
        Session::flash('success_message', "Member Account ID [' $member_account_id '] has been deleted!");

        // go back to the member lists
        return redirect()->route('member.edit', ['id' => $member_id]);

    }
}
