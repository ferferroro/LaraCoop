<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\{Member, Transfer};
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
        
        $transfers = Transfer::with('member_from_info')
            ->with('member_to_info')
            ->with('accepted_by_info')
            ->where('search_text', 'like', '%' . $search_string . '%' )
            ->paginate(15);

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
        $members = DB::table('members')->get();

        return view('pages.transfer_add')
            ->with('members', $members);
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
            'member_from' => 'required|exists:members,id',
            'transferred_at' => 'required|date',
            'bank_from' => 'required|string',
            'account_number_from' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'remarks' => 'sometimes|string|max:255',
            // to
            'member_to' => 'required|exists:members,id',
            'bank_to' => 'required|string',
            'account_number_to' => 'required|string',
        ]);

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

        $members = DB::table('members')->get();

        return view('pages.transfer_edit')
            ->with('transfer',  $transfer)
            ->with('members', $members);
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
            'member_from' => 'required|exists:members,id',
            'transferred_at' => 'required|date',
            'bank_from' => 'required|string',
            'account_number_from' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'remarks' => 'sometimes|string|max:255',
            // to
            'member_to' => 'required|exists:members,id',
            'bank_to' => 'required|string',
            'account_number_to' => 'required|string',
        ]);

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

            // subtract fund on hand to sending member
            $member_from = Member::findOrFail($transfer->member_from);


            if ($transfer->amount > $member_from->fund_on_hand ) {
                Session::flash('error_message', "Sender does not have enough fund!");
                return redirect()->route('transfer.edit', ['id' => $transfer_id]);
            }
            
            $member_from->fund_on_hand -= $transfer->amount;
            $member_from->lockForUpdate();
            $member_from->save();


            // add fund on hand to receiving member
            $member_to = Member::findOrFail($transfer->member_to);
            $member_to->fund_on_hand += $transfer->amount;
            $member_to->lockForUpdate();
            $member_to->save();


            $transfer->is_accepted = true;
            $transfer->lockForUpdate();
            $transfer->save();



            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Session::flash('success_message', "Transfer has been accepted!");

        return redirect()->route('transfer.edit', ['id' => $transfer_id]);
    }
}
