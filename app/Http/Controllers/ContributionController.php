<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\{Contribution, Company};
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
    public function index()
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
        return view('pages.contribution_add');
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
            'remarks' => 'sometimes|string|max:255',
        ]);


        DB::beginTransaction();
        try {
            $contribution = new Contribution;
            $contribution->fill($validated);
            $contribution->search_text = "$contribution->member_id $contribution->period $contribution->amount $contribution->remarks";
            $contribution->save();

            $company = Company::lockForUpdate()->firstOrFail();
            $company->fund_total += $contribution->amount;
            $company->fund_available += $contribution->amount;
            $company->save();

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

        return view('pages.contribution_edit')
            ->with('contribution',  $contribution);
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
            'remarks' => 'sometimes|string|max:255'
        ]);

        

        DB::beginTransaction();
        try {
            $contribution_id = $request['id'] ?? 0;
            $contribution = Contribution::findOrFail($contribution_id);
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
        DB::beginTransaction();
        try {
            // find the record and delete it
            $contribution_id = $request['id'] ?? 0;
            $contribution = Contribution::findOrFail($contribution_id);
            $contribution->delete();

            $company = Company::lockForUpdate()->firstOrFail();
            $company->fund_total -= $contribution->amount;
            $company->fund_available -= $contribution->amount;
            $company->save();

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
}
