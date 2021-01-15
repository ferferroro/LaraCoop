<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Company;
use Session;

class CompanyController extends Controller
{
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
            'fund_profit' => 'required|numeric|min:0',
            'date_founded' => 'required|date',
            'mission' => 'required|string|max:255',
            'vision' => 'required|string|max:255',
        ]);

        $company_id = $request['id'] ?? 0;
        $company = Company::firstOrFail();

        $company->fill($validated);
        $company->search_text = "$company->name $company->address $company->primary_contact $company->interest_rate $company->penalty_rate $company->fund_total $company->fund_lended $company->fund_available $company->fund_profit $company->date_founded $company->mission $company->vission";
        $company->save();
        
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
