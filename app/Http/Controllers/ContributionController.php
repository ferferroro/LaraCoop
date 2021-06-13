<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\{Contribution, Company, Member, MemberAccount};
use Session;

class ContributionController extends Controller
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
        
        $contributions = Contribution::with('member')
            ->where('search_text', 'like', '%' . $search_string . '%' )
            ->paginate(15);

        return view('pages.contributions')
            ->with('contributions',  $contributions)
            ->with('search_string', $search_string);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $members = DB::table('members')->get();
        return view('pages.contribution_add')
            ->with('members',  $members);
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
            'member_id' => 'required|exists:members,id',
            'period' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'fund_collector' => 'required|exists:members,id',
            'fund_collector_account_id' => 'required|exists:member_accounts,id',
            'remarks' => 'sometimes|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $contribution = new Contribution;
            $contribution->fill($validated);
            $contribution->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Session::flash('success_message', "Contribution been added!");

        return redirect()->route('contribution.index');
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
        $contribution_id = $request['id'] ?? 0;

        $contribution = Contribution::findOrFail($contribution_id);        
        $members = Member::with('member_accounts')
            ->get();
        $member = Member::with('member_accounts')
            ->findOrFail($contribution->fund_collector);

        return view('pages.contribution_edit')
            ->with('contribution',  $contribution)
            ->with('members',  $members)
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
            'id' => 'required|exists:contributions,id',
            'member_id' => 'required|exists:members,id',
            'period' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'fund_collector' => 'required|exists:members,id',
            'fund_collector_account_id' => 'required|exists:member_accounts,id',
            'remarks' => 'sometimes|string|max:255',
        ]);

        $contribution_id = $request['id'] ?? 0;
        $contribution = Contribution::findOrFail($contribution_id);

        if ($contribution->is_approved == true) {
            Session::flash('error_message', "Contribution is already approved!");

            return redirect()->route('contribution.edit', ['id' => $contribution_id]);
        }

        DB::beginTransaction();
        try {
            
            // save the old contribution amount
            $old_contribution_amount = $contribution->amount;
            $contribution->fill($validated);
            $contribution->search_text = "$contribution->member_id $contribution->period $contribution->amount $contribution->remarks";
            $contribution->save();

            /** 
             *  get the new value to be added on company figures
             *      new - old
             *          0  - 50 = -50   | old is 50 and we changed it to 0 then SUBTRACT 50 to company funds
             *          50 - 50 = 0     | old is 50 and we changed it to 50 then ADD 0 to company funds
             *          50 - 0  = 50    | old is 0 and we changed it to 50 then ADD 50 to company funds
             */
            $new_contribution_amount = $contribution->amount - $old_contribution_amount;

            $company = Company::lockForUpdate()->firstOrFail();
            $company->fund_total += $new_contribution_amount;
            $company->fund_available += $new_contribution_amount;
            $company->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Session::flash('success_message', "Contribution has been updated!");

        return redirect()->route('contribution.edit', ['id' => $contribution_id]);
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
        $contribution_id = $request['id'] ?? 0;
        $contribution = Contribution::findOrFail($contribution_id);
        
        if ($contribution->is_approved == true) {
            Session::flash('error_message', "Contribution is already approved!");

            return redirect()->route('contribution.edit', ['id' => $contribution_id]);
        }

        DB::beginTransaction();
        try {
            
            $contribution->delete();

            // $company = Company::lockForUpdate()->firstOrFail();
            // $company->fund_total -= $contribution->amount;
            // $company->fund_available -= $contribution->amount;
            // $company->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // create success message 
        Session::flash('success_message', "contribution ID [' $contribution_id '] has been deleted!");

        // go back to the index page
        return redirect()->route('contribution.index');
    }

    /**
     * Approve contribution
     *
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request)
    {
        // update the contribution
        $contribution_id = $request['id'] ?? 0;
        $contribution = Contribution::lockForUpdate()
            ->findOrFail($contribution_id);

        if ($contribution->is_approved == true) {
            Session::flash('error_message', "Contribution is already approved!");

            return redirect()->route('contribution.edit', ['id' => $contribution_id]);
        }

        DB::beginTransaction();
        try {
            
            $contribution->is_approved = true;
            $contribution->save();

            // update members total contribution
            $member = Member::lockForUpdate()
                ->findOrFail($contribution->member_id);
            $member->total_contribution += $contribution->amount;
            $member->save();

            // update collector's fund
            $member = Member::lockForUpdate()
                ->findOrFail($contribution->fund_collector);
            $member->fund_on_hand += $contribution->amount;
            $member->save();

            // update collector's fund
            $member_account = MemberAccount::lockForUpdate()
                ->findOrFail($contribution->fund_collector_account_id);
            $member_account->amount += $contribution->amount;
            $member_account->save();

            $company = Company::lockForUpdate()->firstOrFail();
            $company->fund_total += $contribution->amount;
            $company->fund_available += $contribution->amount;
            $company->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // create success message 
        Session::flash('success_message', "contribution ID [' $contribution_id '] has been approved!");

        // go back to the index page
        return redirect()->route('contribution.edit', ['id' => $contribution_id]);
    }
}
