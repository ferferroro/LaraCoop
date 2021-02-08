<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\{Loan};

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
        
        return [
            'loans' => $this->get_loans(),
            'quotes' => $this->get_quotes(),
            'loan_by_status' => $this->get_loans_based_status(),
            'contributions' => $this->get_contributions()
            ];

    }

    /**
     * Get loans data
     *
     * @return \Illuminate\View\View
     */
    public function get_loans()
    {
        $loans = [];

        $from = date( date("Y") . '-01-01');
        $to = date('Y-m-t', strtotime($from));
        $loans[1] = DB::table('loans')
            ->where('loan_type', 'Loan')
            ->whereBetween('date_loan', [$from, $to] )
            ->count();

        $from = date( date("Y") . '-02-01');
        $to = date('Y-m-t', strtotime($from));
        $loans[2] = DB::table('loans')
        ->where('loan_type', 'Loan')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-03-01');
        $to = date('Y-m-t', strtotime($from));
        $loans[3] = DB::table('loans')
        ->where('loan_type', 'Loan')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-04-01');
        $to = date('Y-m-t', strtotime($from));
        $loans[4] = DB::table('loans')
        ->where('loan_type', 'Loan')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-05-01');
        $to = date('Y-m-t', strtotime($from));
        $loans[5] = DB::table('loans')
        ->where('loan_type', 'Loan')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-06-01');
        $to = date('Y-m-t', strtotime($from));
        $loans[6] = DB::table('loans')
        ->where('loan_type', 'Loan')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-07-01');
        $to = date('Y-m-t', strtotime($from));
        $loans[7] = DB::table('loans')
        ->where('loan_type', 'Loan')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-08-01');
        $to = date('Y-m-t', strtotime($from));
        $loans[8] = DB::table('loans')
        ->where('loan_type', 'Loan')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-09-01');
        $to = date('Y-m-t', strtotime($from));
        $loans[9] = DB::table('loans')
        ->where('loan_type', 'Loan')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-010-01');
        $to = date('Y-m-t', strtotime($from));
        $loans[10] = DB::table('loans')
        ->where('loan_type', 'Loan')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-011-01');
        $to = date('Y-m-t', strtotime($from));
        $loans[11] = DB::table('loans')
        ->where('loan_type', 'Loan')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-012-01');
        $to = date('Y-m-t', strtotime($from));
        $loans[12] = DB::table('loans')
        ->where('loan_type', 'Loan')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        return $loans;

    }

    /**
     * Get loans data
     *
     * @return \Illuminate\View\View
     */
    public function get_quotes()
    {
        $quotes = [];

        $from = date( date("Y") . '-01-01');
        $to = date('Y-m-t', strtotime($from));
        $quotes[1] = DB::table('loans')
            ->where('loan_type', 'Quote')
            ->whereBetween('date_loan', [$from, $to] )
            ->count();

        $from = date( date("Y") . '-02-01');
        $to = date('Y-m-t', strtotime($from));
        $quotes[2] = DB::table('loans')
        ->where('loan_type', 'Quote')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-03-01');
        $to = date('Y-m-t', strtotime($from));
        $quotes[3] = DB::table('loans')
        ->where('loan_type', 'Quote')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-04-01');
        $to = date('Y-m-t', strtotime($from));
        $quotes[4] = DB::table('loans')
        ->where('loan_type', 'Quote')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-05-01');
        $to = date('Y-m-t', strtotime($from));
        $quotes[5] = DB::table('loans')
        ->where('loan_type', 'Quote')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-06-01');
        $to = date('Y-m-t', strtotime($from));
        $quotes[6] = DB::table('loans')
        ->where('loan_type', 'Quote')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-07-01');
        $to = date('Y-m-t', strtotime($from));
        $quotes[7] = DB::table('loans')
        ->where('loan_type', 'Quote')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-08-01');
        $to = date('Y-m-t', strtotime($from));
        $quotes[8] = DB::table('loans')
        ->where('loan_type', 'Quote')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-09-01');
        $to = date('Y-m-t', strtotime($from));
        $quotes[9] = DB::table('loans')
        ->where('loan_type', 'Quote')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-010-01');
        $to = date('Y-m-t', strtotime($from));
        $quotes[10] = DB::table('loans')
        ->where('loan_type', 'Quote')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-011-01');
        $to = date('Y-m-t', strtotime($from));
        $quotes[11] = DB::table('loans')
        ->where('loan_type', 'Quote')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-012-01');
        $to = date('Y-m-t', strtotime($from));
        $quotes[12] = DB::table('loans')
        ->where('loan_type', 'Quote')
        ->whereBetween('date_loan', [$from, $to] )
        ->count();


        return $quotes;

    }

    public function get_loans_based_status()
    {
        $loans = [];

        
        $loans[1] = DB::table('loans')
            ->where('is_settled', true)
            ->count();

        $loans[2] = DB::table('loans')
            ->where('is_settled', false)
            ->where('is_approved', true)
            ->count();

        $loans[3] = DB::table('loans')
            ->where('is_settled', false)
            ->where('is_approved', false)
            ->where('is_transferred', true)
            ->count();
        
        $loans[4] = DB::table('loans')
            ->where('is_settled', false)
            ->where('is_approved', false)
            ->where('is_transferred', false)
            ->count();

        return $loans;

    }

    /**
     * Get loans data
     *
     * @return \Illuminate\View\View
     */
    public function get_contributions()
    {
        $contributions = [];

        $from = date( date("Y") . '-01-01');
        $to = date('Y-m-t', strtotime($from));
        $contributions[1] = DB::table('contributions')
            ->where('is_approved', true)
            ->whereBetween('approved_at', [$from, $to] )
            ->count();

        $from = date( date("Y") . '-02-01');
        $to = date('Y-m-t', strtotime($from));
        $contributions[2] = DB::table('contributions')
        ->where('is_approved', true)
        ->whereBetween('approved_at', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-03-01');
        $to = date('Y-m-t', strtotime($from));
        $contributions[3] = DB::table('contributions')
        ->where('is_approved', true)
        ->whereBetween('approved_at', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-04-01');
        $to = date('Y-m-t', strtotime($from));
        $contributions[4] = DB::table('contributions')
        ->where('is_approved', true)
        ->whereBetween('approved_at', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-05-01');
        $to = date('Y-m-t', strtotime($from));
        $contributions[5] = DB::table('contributions')
        ->where('is_approved', true)
        ->whereBetween('approved_at', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-06-01');
        $to = date('Y-m-t', strtotime($from));
        $contributions[6] = DB::table('contributions')
        ->where('is_approved', true)
        ->whereBetween('approved_at', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-07-01');
        $to = date('Y-m-t', strtotime($from));
        $contributions[7] = DB::table('contributions')
        ->where('is_approved', true)
        ->whereBetween('approved_at', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-08-01');
        $to = date('Y-m-t', strtotime($from));
        $contributions[8] = DB::table('contributions')
        ->where('is_approved', true)
        ->whereBetween('approved_at', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-09-01');
        $to = date('Y-m-t', strtotime($from));
        $contributions[9] = DB::table('contributions')
        ->where('is_approved', true)
        ->whereBetween('approved_at', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-010-01');
        $to = date('Y-m-t', strtotime($from));
        $contributions[10] = DB::table('contributions')
        ->where('is_approved', true)
        ->whereBetween('approved_at', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-011-01');
        $to = date('Y-m-t', strtotime($from));
        $contributions[11] = DB::table('contributions')
        ->where('is_approved', true)
        ->whereBetween('approved_at', [$from, $to] )
        ->count();

        $from = date( date("Y") . '-012-01');
        $to = date('Y-m-t', strtotime($from));
        $contributions[12] = DB::table('contributions')
        ->where('is_approved', true)
        ->whereBetween('approved_at', [$from, $to] )
        ->count();

        return $contributions;

    }

}
