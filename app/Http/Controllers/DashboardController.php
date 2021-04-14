<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Company, DashboardData};
use Illuminate\Support\Facades\DB;
use Session;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::firstOrFail();

        return view('pages.build_dashboard_data');
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

    
        $dashboard_data = DashboardData::first();

        DB::beginTransaction();
        try {

            if ($dashboard_data) {
                $dashboard_data->lockForUpdate();


                // get company totals
                $company = Company::firstOrFail();
                $dashboard_data->fund_total = $company->fund_total;
                $dashboard_data->fund_available = $company->fund_available;
                $dashboard_data->fund_lended = $company->fund_lended;
                $dashboard_data->fund_profit = $company->fund_profit;
                $dashboard_data->fund_reserved = $company->fund_reserved;

                // get loan counts
                $from = date( date("Y") . '-01-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->loans_01 = DB::table('loans')
                    ->where('loan_type', 'Loan')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-02-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->loans_02 = DB::table('loans')
                    ->where('loan_type', 'Loan')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-03-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->loans_03 = DB::table('loans')
                    ->where('loan_type', 'Loan')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-04-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->loans_04 = DB::table('loans')
                    ->where('loan_type', 'Loan')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-05-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->loans_05 = DB::table('loans')
                    ->where('loan_type', 'Loan')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-06-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->loans_05 = DB::table('loans')
                    ->where('loan_type', 'Loan')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-07-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->loans_07= DB::table('loans')
                    ->where('loan_type', 'Loan')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-08-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->loans_08 = DB::table('loans')
                    ->where('loan_type', 'Loan')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-09-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->loans_09 = DB::table('loans')
                    ->where('loan_type', 'Loan')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-010-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->loans_10 = DB::table('loans')
                    ->where('loan_type', 'Loan')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-011-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->loans_11 = DB::table('loans')
                    ->where('loan_type', 'Loan')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-012-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->loans_12 = DB::table('loans')
                    ->where('loan_type', 'Loan')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();




                // get quotes count
                $from = date( date("Y") . '-01-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->quote_01 = DB::table('loans')
                    ->where('loan_type', 'Quote')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-02-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->quote_02 = DB::table('loans')
                    ->where('loan_type', 'Quote')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-03-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->quote_03 = DB::table('loans')
                    ->where('loan_type', 'Quote')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-04-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->quote_04 = DB::table('loans')
                    ->where('loan_type', 'Quote')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-05-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->quote_05 = DB::table('loans')
                    ->where('loan_type', 'Quote')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-06-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->quote_06 = DB::table('loans')
                    ->where('loan_type', 'Quote')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-07-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->quote_07 = DB::table('loans')
                    ->where('loan_type', 'Quote')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-08-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->quote_08 = DB::table('loans')
                    ->where('loan_type', 'Quote')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-09-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->quote_09 = DB::table('loans')
                    ->where('loan_type', 'Quote')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-010-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->quote_10 = DB::table('loans')
                    ->where('loan_type', 'Quote')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-011-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->quote_11 = DB::table('loans')
                    ->where('loan_type', 'Quote')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-012-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->quote_12 = DB::table('loans')
                    ->where('loan_type', 'Quote')
                    ->whereBetween('date_loan', [$from, $to] )
                    ->count();


                // get loan counts based on status
                $dashboard_data->loan_settled_count = DB::table('loans')
                    ->where('is_settled', true)
                    ->count();
        
                $dashboard_data->loan_transferred_count = DB::table('loans')
                    ->where('is_settled', false)
                    ->where('is_approved', true)
                    ->count();
        
                $dashboard_data->loan_approved_count = DB::table('loans')
                    ->where('is_settled', false)
                    ->where('is_approved', false)
                    ->where('is_transferred', true)
                    ->count();
                
                $dashboard_data->loan_new_count = DB::table('loans')
                    ->where('is_settled', false)
                    ->where('is_approved', false)
                    ->where('is_transferred', false)
                    ->count();

                // get contributions count
                $from = date( date("Y") . '-01-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->contribution_01 = DB::table('contributions')
                    ->where('is_approved', true)
                    ->whereBetween('approved_at', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-02-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->contribution_02 = DB::table('contributions')
                    ->where('is_approved', true)
                    ->whereBetween('approved_at', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-03-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->contribution_03 = DB::table('contributions')
                    ->where('is_approved', true)
                    ->whereBetween('approved_at', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-04-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->contribution_04 = DB::table('contributions')
                    ->where('is_approved', true)
                    ->whereBetween('approved_at', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-05-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->contribution_05 = DB::table('contributions')
                    ->where('is_approved', true)
                    ->whereBetween('approved_at', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-06-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->contribution_06 = DB::table('contributions')
                    ->where('is_approved', true)
                    ->whereBetween('approved_at', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-07-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->contribution_07 = DB::table('contributions')
                    ->where('is_approved', true)
                    ->whereBetween('approved_at', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-08-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->contribution_08 = DB::table('contributions')
                    ->where('is_approved', true)
                    ->whereBetween('approved_at', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-09-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->contribution_09 = DB::table('contributions')
                    ->where('is_approved', true)
                    ->whereBetween('approved_at', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-010-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->contribution_10 = DB::table('contributions')
                    ->where('is_approved', true)
                    ->whereBetween('approved_at', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-011-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->contribution_11 = DB::table('contributions')
                    ->where('is_approved', true)
                    ->whereBetween('approved_at', [$from, $to] )
                    ->count();

                $from = date( date("Y") . '-012-01');
                $to = date('Y-m-t', strtotime($from));
                $dashboard_data->contribution_12 = DB::table('contributions')
                    ->where('is_approved', true)
                    ->whereBetween('approved_at', [$from, $to] )
                    ->count();

            }
            else {
                $dashboard_data = new DashboardData;
            }

            


            
            $dashboard_data->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        
        Session::flash('success_message', "Dashboard data has been updated!");

        return redirect()->route('dashboard_data.index');
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
