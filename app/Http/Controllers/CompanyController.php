<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\{Company, CompanyAdjustment, CompanyAccount};
use Session;

class CompanyController extends Controller
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
        $company = Company::with('company_accounts')
        ->firstOrFail();

        return view('pages.company')
            ->with('company',  $company);
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
       return 'asdf';
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
            'primary_contact' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'percent_interest' => 'required|numeric|min:1',
            'percent_penalty' => 'required|numeric|min:1',
            'fund_total' => 'required|numeric|min:0',
            'fund_lended' => 'required|numeric|min:0',
            'fund_available' => 'required|numeric|min:0',
            'fund_reserved' => 'required|numeric|min:0',
            'fund_profit' => 'required|numeric|min:0',
            'date_founded' => 'required|date',
            'mission' => 'required|string|max:255',
            'vision' => 'required|string|max:255',
            // 'bank' => 'required|string|max:255',
            // 'account_number' => 'required|string|max:255',
        ]);

        
        DB::beginTransaction();
        try {
            $company_id = $request['id'] ?? 0;
            $company = Company::firstOrFail();


            // log adjustments
            if ($company->percent_interest != $validated['percent_interest']) {
                $company_adj = new CompanyAdjustment;
                $company_adj->company_id = $company->id;
                $company_adj->type = 'percent_interest';
                $company_adj->amount_from = $company->percent_interest;
                $company_adj->amount_to = $validated['percent_interest'];
                $company_adj->variance = $company->percent_interest - $validated['percent_interest'];
                $company_adj->save();
            }

            // log adjustments
            if ($company->percent_penalty != $validated['percent_penalty']) {
                $company_adj = new CompanyAdjustment;
                $company_adj->company_id = $company->id;
                $company_adj->type = 'percent_penalty';
                $company_adj->amount_from = $company->percent_penalty;
                $company_adj->amount_to = $validated['percent_penalty'];
                $company_adj->variance = $company->percent_penalty - $validated['percent_penalty'];
                $company_adj->save();
            }

            // log adjustments
            if ($company->fund_total != $validated['fund_total']) {
                $company_adj = new CompanyAdjustment;
                $company_adj->company_id = $company->id;
                $company_adj->type = 'fund_total';
                $company_adj->amount_from = $company->fund_total;
                $company_adj->amount_to = $validated['fund_total'];
                $company_adj->variance = $company->fund_total - $validated['fund_total'];
                $company_adj->save();
            }

            // log adjustments
            if ($company->fund_available != $validated['fund_available']) {
                $company_adj = new CompanyAdjustment;
                $company_adj->company_id = $company->id;
                $company_adj->type = 'fund_available';
                $company_adj->amount_from = $company->fund_available;
                $company_adj->amount_to = $validated['fund_available'];
                $company_adj->variance = $company->fund_available - $validated['fund_available'];
                $company_adj->save();
            }

            // log adjustments
            if ($company->fund_lended != $validated['fund_lended']) {
                $company_adj = new CompanyAdjustment;
                $company_adj->company_id = $company->id;
                $company_adj->type = 'fund_lended';
                $company_adj->amount_from = $company->fund_lended;
                $company_adj->amount_to = $validated['fund_lended'];
                $company_adj->variance = $company->fund_lended - $validated['fund_lended'];
                $company_adj->save();
            }

            // log adjustments
            if ($company->fund_profit != $validated['fund_profit']) {
                $company_adj = new CompanyAdjustment;
                $company_adj->company_id = $company->id;
                $company_adj->type = 'fund_profit';
                $company_adj->amount_from = $company->fund_profit;
                $company_adj->amount_to = $validated['fund_profit'];
                $company_adj->variance = $company->fund_profit - $validated['fund_profit'];
                $company_adj->save();
            }

            // log adjustments
            if ($company->fund_reserved != $validated['fund_reserved']) {
                $company_adj = new CompanyAdjustment;
                $company_adj->company_id = $company->id;
                $company_adj->type = 'fund_reserved';
                $company_adj->amount_from = $company->fund_reserved;
                $company_adj->amount_to = $validated['fund_reserved'];
                $company_adj->variance = $company->fund_reserved - $validated['fund_reserved'];
                $company_adj->save();
            }

            $company->fill($validated);
            $company->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        
        Session::flash('success_message', "Company record has been updated!");

        return redirect()->route('company.index');
    }

    /**
     * Add account view
     */
    public function add_account(Request $request)
    {
        // find the record and delete it
        $company_id = $request['company_id'] ?? 0;
        $company = Company::findOrFail($company_id);

        return view('pages.company_account_add')
            ->with('company', $company);
    }

    /**
     * Store account
     */
    public function store_account(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:company,id',
            'bank' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'account' => 'required|string|max:255'
        ]);

        $company_account = new CompanyAccount;
        $company_account->fill($validated);
        $company_account->save();
        $company_account->refresh();

        Session::flash('success_message', "company Account [' $company_account->id '] has been added!");
      
        return redirect()->route('company.index');
    }


    /**
     * Edit account
     */
    public function edit_account(Request $request)
    {

        $company_account_id = $request['id'] ?? 0;

        $company_account = CompanyAccount::with('company')
            ->findOrFail($company_account_id);
        
        return view('pages.company_account_edit')
            ->with('company_account', $company_account);
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

        $company_account_id = $request['id'] ?? 0;
        $company_account = CompanyAccount::findOrFail($company_account_id);

        $company_account->fill($validated);
        $company_account->save();
        
        Session::flash('success_message', "Company Account [' $company_account_id '] has been updated!");

        return redirect()->route('company.edit_account', ['id' => $company_account_id]);
    }

    /**
     * destrong account
     */
    public function destroy_account(Request $request)
    {

        // find the record and delete it
        $company_account_id = $request['id'] ?? 0;
        $company_account = CompanyAccount::findOrFail($company_account_id);
        $company_id = $company_account->company_id;

        if ($company_account->amount != 0) {
            Session::flash('error_message', "Unable to delete! company Account ID [' $company_account_id '] has amount stored on it!");

            return redirect()->route('company.edit_account', ['id' => $company_account_id]);
        }

        $company_account->delete();

        // create success message 
        Session::flash('success_message', "company Account ID [' $company_account_id '] has been deleted!");

        // go back to the company lists
        return redirect()->route('company.index');

    }
}
