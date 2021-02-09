<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\{Company, CompanyAdjustment};
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
        $company = Company::firstOrFail();

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
