<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\{Loan};
use App\Helper\Helper;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        if (! Helper::hasMenu() ) {
            return redirect()->route('menu.setup_view');
        }
        
        $company = DB::table('company')->first();

        return view('pages.dashboard')
            ->with('company', $company);
    }

    /**
     * Get loans data
     *
     * @return \Illuminate\View\View
     */
    public function loan_chart_data()
    {

        $dashboard_data = DB::table('dashboard_data')
            ->first();

        if ($dashboard_data) {
            $loans = [];
            $loans[1] = $dashboard_data->loans_01;
            $loans[2] = $dashboard_data->loans_02;
            $loans[3] = $dashboard_data->loans_03;
            $loans[4] = $dashboard_data->loans_04;
            $loans[5] = $dashboard_data->loans_05;
            $loans[6] = $dashboard_data->loans_06;
            $loans[7] = $dashboard_data->loans_07;
            $loans[8] = $dashboard_data->loans_08;
            $loans[9] = $dashboard_data->loans_09;
            $loans[10] = $dashboard_data->loans_10;
            $loans[11] = $dashboard_data->loans_11;
            $loans[12] = $dashboard_data->loans_12;


            $quote = [];
            $quote[1] = $dashboard_data->quote_01;
            $quote[2] = $dashboard_data->quote_02;
            $quote[3] = $dashboard_data->quote_03;
            $quote[4] = $dashboard_data->quote_04;
            $quote[5] = $dashboard_data->quote_05;
            $quote[6] = $dashboard_data->quote_06;
            $quote[7] = $dashboard_data->quote_07;
            $quote[8] = $dashboard_data->quote_08;
            $quote[9] = $dashboard_data->quote_09;
            $quote[10] = $dashboard_data->quote_10;
            $quote[11] = $dashboard_data->quote_11;
            $quote[12] = $dashboard_data->quote_12;

            $loan_by_status = [];
            $loan_by_status[1] = $dashboard_data->loan_settled_count;
            $loan_by_status[2] = $dashboard_data->loan_transferred_count;
            $loan_by_status[3] = $dashboard_data->loan_approved_count;
            $loan_by_status[4] = $dashboard_data->loan_new_count;

            $contribution = [];
            // $contribution[1] = 0;
            // $contribution[2] = 0;
            // $contribution[3] = 0;
            // $contribution[4] = 0;
            // $contribution[5] = 0;
            // $contribution[6] = 0;
            // $contribution[7] = 0;
            // $contribution[8] = 0;
            // $contribution[9] = 0;
            // $contribution[10] = 0;
            // $contribution[11] = 0;
            // $contribution[12] = 0;
            $contribution[1] = $dashboard_data->contribution_01;
            $contribution[2] = $dashboard_data->contribution_02;
            $contribution[3] = $dashboard_data->contribution_03;
            $contribution[4] = $dashboard_data->contribution_04;
            $contribution[5] = $dashboard_data->contribution_05;
            $contribution[6] = $dashboard_data->contribution_06;
            $contribution[7] = $dashboard_data->contribution_07;
            $contribution[8] = $dashboard_data->contribution_08;
            $contribution[9] = $dashboard_data->contribution_09;
            $contribution[10] = $dashboard_data->contribution_10;
            $contribution[11] = $dashboard_data->contribution_11;
            $contribution[12] = $dashboard_data->contribution_12;

            
        }
        
        return [
            'loans' => $loans,
            'quotes' => $quote,
            'loan_by_status' => $loan_by_status,
            'contributions' => $contribution
            ];

    }

    // /**
    //  * Get loans data
    //  *
    //  * @return \Illuminate\View\View
    //  */
    // public function get_loans()
    // {
    //     $loans = [];

    //     $from = date( date("Y") . '-01-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $loans[1] = DB::table('loans')
    //         ->where('loan_type', 'Loan')
    //         ->whereBetween('date_loan', [$from, $to] )
    //         ->count();

    //     $from = date( date("Y") . '-02-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $loans[2] = DB::table('loans')
    //     ->where('loan_type', 'Loan')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-03-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $loans[3] = DB::table('loans')
    //     ->where('loan_type', 'Loan')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-04-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $loans[4] = DB::table('loans')
    //     ->where('loan_type', 'Loan')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-05-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $loans[5] = DB::table('loans')
    //     ->where('loan_type', 'Loan')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-06-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $loans[6] = DB::table('loans')
    //     ->where('loan_type', 'Loan')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-07-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $loans[7] = DB::table('loans')
    //     ->where('loan_type', 'Loan')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-08-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $loans[8] = DB::table('loans')
    //     ->where('loan_type', 'Loan')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-09-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $loans[9] = DB::table('loans')
    //     ->where('loan_type', 'Loan')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-010-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $loans[10] = DB::table('loans')
    //     ->where('loan_type', 'Loan')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-011-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $loans[11] = DB::table('loans')
    //     ->where('loan_type', 'Loan')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-012-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $loans[12] = DB::table('loans')
    //     ->where('loan_type', 'Loan')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     return $loans;

    // }

    // /**
    //  * Get loans data
    //  *
    //  * @return \Illuminate\View\View
    //  */
    // public function get_quotes()
    // {
    //     $quotes = [];

    //     $from = date( date("Y") . '-01-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $quotes[1] = DB::table('loans')
    //         ->where('loan_type', 'Quote')
    //         ->whereBetween('date_loan', [$from, $to] )
    //         ->count();

    //     $from = date( date("Y") . '-02-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $quotes[2] = DB::table('loans')
    //     ->where('loan_type', 'Quote')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-03-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $quotes[3] = DB::table('loans')
    //     ->where('loan_type', 'Quote')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-04-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $quotes[4] = DB::table('loans')
    //     ->where('loan_type', 'Quote')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-05-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $quotes[5] = DB::table('loans')
    //     ->where('loan_type', 'Quote')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-06-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $quotes[6] = DB::table('loans')
    //     ->where('loan_type', 'Quote')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-07-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $quotes[7] = DB::table('loans')
    //     ->where('loan_type', 'Quote')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-08-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $quotes[8] = DB::table('loans')
    //     ->where('loan_type', 'Quote')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-09-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $quotes[9] = DB::table('loans')
    //     ->where('loan_type', 'Quote')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-010-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $quotes[10] = DB::table('loans')
    //     ->where('loan_type', 'Quote')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-011-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $quotes[11] = DB::table('loans')
    //     ->where('loan_type', 'Quote')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-012-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $quotes[12] = DB::table('loans')
    //     ->where('loan_type', 'Quote')
    //     ->whereBetween('date_loan', [$from, $to] )
    //     ->count();


    //     return $quotes;

    // }

    // public function get_loans_based_status()
    // {
    //     $loans = [];

        
    //     $loans[1] = DB::table('loans')
    //         ->where('is_settled', true)
    //         ->count();

    //     $loans[2] = DB::table('loans')
    //         ->where('is_settled', false)
    //         ->where('is_approved', true)
    //         ->count();

    //     $loans[3] = DB::table('loans')
    //         ->where('is_settled', false)
    //         ->where('is_approved', false)
    //         ->where('is_transferred', true)
    //         ->count();
        
    //     $loans[4] = DB::table('loans')
    //         ->where('is_settled', false)
    //         ->where('is_approved', false)
    //         ->where('is_transferred', false)
    //         ->count();

    //     return $loans;

    // }

    // /**
    //  * Get loans data
    //  *
    //  * @return \Illuminate\View\View
    //  */
    // public function get_contributions()
    // {
    //     $contributions = [];

    //     $from = date( date("Y") . '-01-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $contributions[1] = DB::table('contributions')
    //         ->where('is_approved', true)
    //         ->whereBetween('approved_at', [$from, $to] )
    //         ->count();

    //     $from = date( date("Y") . '-02-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $contributions[2] = DB::table('contributions')
    //     ->where('is_approved', true)
    //     ->whereBetween('approved_at', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-03-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $contributions[3] = DB::table('contributions')
    //     ->where('is_approved', true)
    //     ->whereBetween('approved_at', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-04-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $contributions[4] = DB::table('contributions')
    //     ->where('is_approved', true)
    //     ->whereBetween('approved_at', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-05-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $contributions[5] = DB::table('contributions')
    //     ->where('is_approved', true)
    //     ->whereBetween('approved_at', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-06-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $contributions[6] = DB::table('contributions')
    //     ->where('is_approved', true)
    //     ->whereBetween('approved_at', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-07-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $contributions[7] = DB::table('contributions')
    //     ->where('is_approved', true)
    //     ->whereBetween('approved_at', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-08-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $contributions[8] = DB::table('contributions')
    //     ->where('is_approved', true)
    //     ->whereBetween('approved_at', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-09-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $contributions[9] = DB::table('contributions')
    //     ->where('is_approved', true)
    //     ->whereBetween('approved_at', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-010-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $contributions[10] = DB::table('contributions')
    //     ->where('is_approved', true)
    //     ->whereBetween('approved_at', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-011-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $contributions[11] = DB::table('contributions')
    //     ->where('is_approved', true)
    //     ->whereBetween('approved_at', [$from, $to] )
    //     ->count();

    //     $from = date( date("Y") . '-012-01');
    //     $to = date('Y-m-t', strtotime($from));
    //     $contributions[12] = DB::table('contributions')
    //     ->where('is_approved', true)
    //     ->whereBetween('approved_at', [$from, $to] )
    //     ->count();

    //     return $contributions;

    // }

}
