<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\{Transfer, Member, MemberAccount, Company, CompanyAccount};
use Illuminate\Validation\Rule;
use Session;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_string = $request['search_string'] ?? '';
        
        $transfers = Transfer::with('account_from_info')
            // ->with('transfer_to_info')
            ->with('accepted_by_info')
            ->where('search_text', 'like', '%' . $search_string . '%' )
            ->paginate(15);

            // return $transfers;

        return view('pages.transfers')
            ->with('transfers',  $transfers)
            ->with('search_string', $search_string);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $members = DB::table('members')->get();
        $members = Member::with('member_accounts')
            ->where('can_hold_fund', true)
            ->get();
        $company = Company::with('company_accounts')
            ->firstOrFail();

        return view('pages.transfer_add')
            ->with('members', $members)
            ->with('company', $company);
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
            // from
            'transfer_from' => 'required|integer',
            'transferred_at' => 'required|date',
            'account_from' => 'required|integer',
            'amount' => 'required|numeric|min:1',
            'remarks' => 'sometimes|string|max:255',
            // to
            'transfer_to' => 'required|integer',
            'account_to' => 'required|integer',
        ]);

        if ($validated['transfer_from'] != 0) {
            $member_from = Member::find($validated['transfer_from']);

            if (!$member_from) { 
                Session::flash('error_message', "Invalid Transfer From");
                return redirect()->route('transfer.add');
            }

            $account_from = MemberAccount::where('member_id', $member_from->id)
                ->where('id', $validated['account_from'])
                ->first();

            if (!$account_from) {
                Session::flash('error_message', "Invalid Account From");
                return redirect()->route('transfer.create');
            }
        }
        else {

            $company = Company::first();

            $account_from = CompanyAccount::where('company_id', $company->id)
                ->where('id', $validated['account_from'])
                ->first();

            if (!$account_from) {
                Session::flash('error_message', "Invalid Account From");
                return redirect()->route('transfer.create');
            }
        }

        if ($validated['transfer_to'] != 0) {
            $member_to = Member::find($validated['transfer_to']);

            if (!$member_to) { 
                Session::flash('error_message', "Invalid Transfer To");
                return redirect()->route('transfer.create');
            }

            $account_to = MemberAccount::where('member_id', $member_to->id)
                ->where('id', $validated['account_to'])
                ->first();

            if (!$account_to) {
                Session::flash('error_message', "Invalid Account To");
                return redirect()->route('transfer.create');
            }            
        }
        else {
            $company = Company::first();

            $account_to = CompanyAccount::where('company_id', $company->id)
                ->where('id', $validated['account_to'])
                ->first();

            if (!$account_to) {
                Session::flash('error_message', "Invalid Account to");
                return redirect()->route('transfer.create');
            }
        }

        if ($account_from->amount < $validated['amount']) {
            Session::flash('error_message', "Account From does not have enough funds!");
            return redirect()->route('transfer.create');
        }

        DB::beginTransaction();
        try {
            $transfer = new Transfer;
            $transfer->fill($validated);
            $transfer->save();
            $transfer->refresh();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Session::flash('success_message', "Fund Transfer has been added!");

        return redirect()->route('transfer.edit', ['id' => $transfer->id]);
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
        $transfer_id = $request['id'] ?? 0;

        $transfer = Transfer::findOrFail($transfer_id);

        $members = Member::get();
        $company = Company::with('company_accounts')
            ->firstOrFail();
        $init_member_accounts_from = MemberAccount::where('member_id', $transfer->transfer_from)->get();
        $init_member_accounts_to = MemberAccount::where('member_id', $transfer->transfer_to)->get();

        return view('pages.transfer_edit')
            ->with('transfer',  $transfer)
            ->with('members', $members)
            ->with('company', $company)
            ->with('init_member_accounts_from', $init_member_accounts_from)
            ->with('init_member_accounts_to', $init_member_accounts_to);
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
            // from
            'transfer_from' => 'required|integer',
            'transferred_at' => 'required|date',
            'account_from' => 'required|integer',
            'amount' => 'required|numeric|min:1',
            'remarks' => 'sometimes|string|max:255',
            // to
            'transfer_to' => 'required|integer',
            'account_to' => 'required|integer',
        ]);

        if ($validated['transfer_from'] != 0) {
            $member_from = Member::find($validated['transfer_from']);

            if (!$member_from) { 
                Session::flash('error_message', "Invalid Transfer From");
                return redirect()->route('transfer.add');
            }

            $account_from = MemberAccount::where('member_id', $member_from->id)
                ->where('id', $validated['account_from'])
                ->first();

            if (!$account_from) {
                Session::flash('error_message', "Invalid Account From");
                return redirect()->route('transfer.create');
            }
        }
        else {

            $company = Company::first();

            $account_from = CompanyAccount::where('company_id', $company->id)
                ->where('id', $validated['account_from'])
                ->first();

            if (!$account_from) {
                Session::flash('error_message', "Invalid Account From");
                return redirect()->route('transfer.create');
            }
        }

        if ($validated['transfer_to'] != 0) {
            $member_to = Member::find($validated['transfer_to']);

            if (!$member_to) { 
                Session::flash('error_message', "Invalid Transfer To");
                return redirect()->route('transfer.create');
            }

            $account_to = MemberAccount::where('member_id', $member_to->id)
                ->where('id', $validated['account_to'])
                ->first();

            if (!$account_to) {
                Session::flash('error_message', "Invalid Account To");
                return redirect()->route('transfer.create');
            }            
        }
        else {
            $company = Company::first();

            $account_to = CompanyAccount::where('company_id', $company->id)
                ->where('id', $validated['account_to'])
                ->first();

            if (!$account_to) {
                Session::flash('error_message', "Invalid Account to");
                return redirect()->route('transfer.create');
            }
        }

        if ($account_from->amount < $validated['amount']) {
            Session::flash('error_message', "Account From does not have enough funds!");
            return redirect()->route('transfer.create');
        }

        $transfer_id = $request['id'] ?? 0;
        $transfer = Transfer::findOrFail($transfer_id);

        // should not happen - but trap it incase
        if ($transfer->is_accepted) {
            Session::flash('error_message', "Unable to make changes to accepted fund transfers!");
            return redirect()->route('transfer.edit', ['id' => $transfer_id]);
        }
        
        DB::beginTransaction();
        try {
            $transfer->fill($validated);
            $transfer->lockForUpdate();
            $transfer->save();
            $transfer->refresh();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Session::flash('success_message', "Transfer has been updated!");

        return redirect()->route('transfer.edit', ['id' => $transfer_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            // find the record and delete it
            $transfer_id = $request['id'] ?? 0;
            $transfer = Transfer::findOrFail($transfer_id);

            // should not happen - but trap it incase
            if ($transfer->is_accepted) {
                Session::flash('error_message', "Unable to delete accepted fund transfers!");
                return redirect()->route('transfer.edit', ['id' => $transfer_id]);
            }

            $transfer->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // create success message 
        Session::flash('success_message', "Transfer ID [' $transfer_id '] has been deleted!");

        // go back to the index page
        return redirect()->route('transfer.index');
    }

    /**
     * Accept transfer
     */
    public function accept(Request $request)
    {
        $transfer_id = $request['id'] ?? 0;
        $transfer = Transfer::findOrFail($transfer_id);

        // should not happen - but trap it incase
        if ($transfer->is_accepted) {
            Session::flash('error_message', "Transfer is already accepted!");
            return redirect()->route('transfer.edit', ['id' => $transfer_id]);
        }
        
        DB::beginTransaction();
        try {
             

            /**
             * Amount update Start
             */

            // SUBTRACT FUND!
            if ($transfer->transfer_from != 0) {   
                // subtract fund to sending member
                $member_from = Member::findOrFail($transfer->transfer_from);

                // subtract fund from sending member account  
                $account_from = MemberAccount::where('member_id', $transfer->transfer_from)
                    ->where('id', $transfer->account_from)
                    ->first();

                if ($transfer->amount > $account_from->amount ) {
                    Session::flash('error_message', "Sender does not have enough fund!");
                    return redirect()->route('transfer.edit', ['id' => $transfer_id]);
                }
                
                $member_from->fund_on_hand -= $transfer->amount;
                $member_from->lockForUpdate();
                $member_from->save();


                $account_from->amount -= $transfer->amount;
                $account_from->lockForUpdate();
                $account_from->save();
                
            }
            else {
                // subtract fund to sending Company
                $company = Company::first();                

                // subtract fund from sending company account  
                $account_from = CompanyAccount::where('company_id', $company->id)
                    ->where('id', $transfer->account_from)
                    ->first();

                if ($transfer->amount > $account_from->amount ) {
                    Session::flash('error_message', "Company does not have enough fund!");
                    return redirect()->route('transfer.edit', ['id' => $transfer_id]);
                }

                // $company->fund_available -= $transfer->amount;
                // $company->lockForUpdate();
                // $company->save();
                
                $account_from->amount -= $transfer->amount;
                $account_from->lockForUpdate();
                $account_from->save();
                
            }

            // ADD FUND!

            // add fund on receiving member
            if ($transfer->transfer_to != 0) {  
                
                // add fund to receiving member
                $member_to = Member::findOrFail($transfer->transfer_to);
                $member_to->fund_on_hand += $transfer->amount;
                $member_to->lockForUpdate();
                $member_to->save();

                // add fund to receiving account
                $account_to = MemberAccount::where('member_id', $transfer->transfer_to)
                    ->where('id', $transfer->account_to)
                    ->first();
                $account_to->amount += $transfer->amount;
                $account_to->lockForUpdate();
                $account_to->save();
            }
            else {
                // add fund to receiving Company
                $company2 = Company::first();
                // $company2->fund_available += $transfer->amount;
                // $company2->lockForUpdate();
                // $company2->save();
                
                
                // add fund to receiving Company Account
                $account_to = CompanyAccount::where('company_id', $company2->id)
                    ->where('id', $transfer->account_to)
                    ->first();
                $account_to->amount += $transfer->amount;
                $account_to->lockForUpdate();
                $account_to->save();
            }

            /**
             * Amount update End
             */


            /**
             * Mark as accepted Start
             */
            $transfer->is_accepted = true;
            $transfer->lockForUpdate();
            $transfer->save();
            /**
             * Mark as accepted End
             */



            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Session::flash('success_message', "Transfer has been accepted!");

        return redirect()->route('transfer.edit', ['id' => $transfer_id]);
    }

    /**
     * Get account list
     */
    public function get_account_list(Request $request)
    {
        // find the record and delete it
        $tranfer_from_id = $request['id'] ?? 0;
        
        $account_list = [];

        if ($tranfer_from_id == 0 ) {
            $company = Company::with('company_accounts')
                ->findOrFail(1);

            foreach($company->company_accounts as $company_account) {
                $account_list[] = [
                    "id" => $company_account->id,
                    "bank" => $company_account->bank,
                    "name" => $company_account->name,
                    "account" => $company_account->account
                ];
            }
        }
        else {
            $member = Member::with('member_accounts')
                ->findOrFail($tranfer_from_id);

            foreach($member->member_accounts as $member_account) {
                $account_list[] = [
                    "id" => $member_account->id,
                    "bank" => $member_account->bank,
                    "name" => $member_account->name,
                    "account" => $member_account->account
                ];
            }
        }

        

        return $account_list;
    }
}
