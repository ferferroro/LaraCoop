<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\{Company, Loan, LoanDetail};
use Illuminate\Validation\Rule;
use Session;
use Carbon\Carbon;
use App\Helper\Helper;

class LoanController extends Controller
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
        
        $loans = Loan::with('borrower')
            ->where('search_text', 'like', '%' . $search_string . '%' )
            ->paginate(15);

        return view('pages.loans')
            ->with('loans',  $loans)
            ->with('search_string', $search_string);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $borrowers = DB::table('borrowers')->get();
        $members = DB::table('members')->get();
        $company = DB::table('company')->first();

        return view('pages.loan_add')
            ->with('members', $members)
            ->with('borrowers', $borrowers)
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
            'borrower_id' => 'required|exists:borrowers,id',
            'loan_type' => [
                'required',
                Rule::in(['Loan', 'Quote']),
            ],
            'date_loan' => 'required|date',
            'date_start' => 'required|date',
            'terms' => 'required|numeric|min:1',
            'type_schedule' => [
                'required',
                Rule::in(['Monthly', 'Semi-Monthly']),
            ],
            'amount' => 'required|numeric|min:1',
            'percent_interest' => 'required|numeric|min:0',
            'percent_penalty' => 'required|numeric|min:0',
            'member_id' => 'required|exists:members,id',
            'remarks' => 'sometimes|string|max:255'
        ]);

        DB::beginTransaction();
        try {
            $loan = new Loan;
            $loan->fill($validated);
            $loan->save();
            $loan->refresh();

            $loan_detail_payment_due = Carbon::create($loan->date_start);
            $day = date('d', strtotime($loan_detail_payment_due)); 
            
            // create the loan details based on terms
            $term = 0;
            while($term < $loan->terms) {

                $term++;
                
                $loan_detail = new LoanDetail;
                $loan_detail->loan_id = $loan->id;
                $loan_detail->term_number = $term;
                $loan_detail->type_line = "Amortization";

                $loan_detail->date_payment_due = $loan_detail_payment_due;
                $loan_detail->amount_base = $loan->amount / $loan->terms;
                $loan_detail->interest_amount = ($loan->percent_interest / 100) * $loan_detail->amount_base;
                $loan_detail->amount_due = $loan_detail->amount_base + $loan_detail->interest_amount;
                
                $loan_detail->save();

                $loan_detail_payment_due = Helper::incrementDate($day, $loan_detail_payment_due, $loan->type_schedule);
            }

            $loan->date_end = $loan_detail_payment_due;
            $loan->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Session::flash('success_message', "Loan has been added!");

        // return redirect()->route('loan.index');
        return redirect()->route('loan.edit', ['id' => $loan->id]);
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
        $loan_id = $request['id'] ?? 0;

        $loan = Loan::with('loan_details')
            ->findOrFail($loan_id);

        $borrowers = DB::table('borrowers')->get();
        $members = DB::table('members')->get();
        $company = DB::table('company')->first();

        $show_button = [
            'approve' => true,
            'settle' => true,
            'save' => true,
            'penalty' => false,
            'delete' => true
        ];

        return view('pages.loan_edit')
            ->with('loan',  $loan)
            ->with('members', $members)
            ->with('borrowers', $borrowers)
            ->with('company', $company);
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
            'id' => 'required|exists:loans,id',
            'borrower_id' => 'required|exists:borrowers,id',
            'loan_type' => [
                'required',
                Rule::in(['Loan', 'Quote']),
            ],
            'date_loan' => 'required|date',
            'date_start' => 'required|date',
            'terms' => 'required|numeric|min:1',
            'type_schedule' => [
                'required',
                Rule::in(['Monthly', 'Semi-Monthly']),
            ],
            'amount' => 'required|numeric|min:1',
            'percent_interest' => 'required|numeric|min:0',
            'percent_penalty' => 'required|numeric|min:0',
            'member_id' => 'required|exists:members,id',
            'remarks' => 'sometimes|string|max:255'
        ]);

        $loan_id = $request['id'] ?? 0;
        $loan = Loan::findOrFail($loan_id);

        // should not happen - but trap it incase
        if ($loan->is_approved || $loan->is_settled || $loan->is_transferred) {
            Session::flash('error_message', "Unable to make changes to Approved, Settled Loan or Transferred!");
            return redirect()->route('loan.edit', ['id' => $loan_id]);
        }
        
        DB::beginTransaction();
        try {
            
            $loan->fill($validated);
            $loan->save();
            $loan->refresh();

            $loan_detail_payment_due = Carbon::create($loan->date_start);
            $day = date('d', strtotime($loan_detail_payment_due)); 
            
            // delete and recreate new loan lines
            $loan->loan_details()->delete();

            // create the loan details based on terms
            for ($term = 1; $term <= $loan->terms; $term++) {
                
                $loan_detail = new LoanDetail;
                $loan_detail->loan_id = $loan->id;
                $loan_detail->term_number = $term;
                $loan_detail->type_line = "Amortization";

                $loan_detail->date_payment_due = $loan_detail_payment_due;
                $loan_detail->amount_base = $loan->amount / $loan->terms;
                $loan_detail->interest_amount = ($loan->percent_interest / 100) * $loan_detail->amount_base;
                $loan_detail->amount_due = $loan_detail->amount_base + $loan_detail->interest_amount;
                $loan_detail->save();

                $loan_detail_payment_due = Helper::incrementDate($day, $loan_detail_payment_due, $loan->type_schedule);
            }

            $loan->date_end = $loan_detail_payment_due;
            $loan->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        Session::flash('success_message', "Loan has been updated!");

        return redirect()->route('loan.edit', ['id' => $loan_id]);
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
            $loan_id = $request['id'] ?? 0;
            $loan = Loan::findOrFail($loan_id);

            // should not happen - but trap it incase
            if ($loan->is_approved || $loan->is_settled || $loan->is_transferred) {
                Session::flash('error_message', "Unable to delete record that is Approved, Settled Loan or Transferred!");
                return redirect()->route('loan.edit', ['id' => $loan_id]);
            }
            
            $loan->delete();
            $loan->loan_details()->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // create success message 
        Session::flash('success_message', "Loan ID [' $loan_id '] has been deleted!");

        // go back to the index page
        return redirect()->route('loan.index');
    }

    /**
     * Approve loan
     */
    public function approve(Request $request)
    {
        $company = Company::lockForUpdate()
            ->firstOrFail();
        $loan_id = $request['id'] ?? 0;
        $loan = Loan::lockForUpdate()
            ->findOrFail($loan_id);

        // check if okay to proceed
        if ($loan->is_approved) {
            Session::flash('error_message', "Loan is already marked as approved!");
            return redirect()->route('loan.edit', ['id' => $loan_id]);
        }

        // check if okay to proceed
        if ($loan->is_settled) {
            Session::flash('error_message', "This is a settled Loan");
            return redirect()->route('loan.edit', ['id' => $loan_id]);
        }

        // check if okay to proceed
        if ($loan->is_transferred) {
            Session::flash('error_message', "The money has been transferred to the client!");
            return redirect()->route('loan.edit', ['id' => $loan_id]);
        }

        // Check if company has enough fund
        if ($loan->loan_details_total() > $company->fund_available) {
            Session::flash('error_message', "Company does not have enough fund!");
            return redirect()->route('loan.edit', ['id' => $loan_id]);
        }

        DB::beginTransaction();
        try {
            $loan->is_approved = true;
            $loan->save();

            // $company->fund_total += $loan->loan_details_total();
            // $company->fund_lended += $loan->loan_details_total();
            // $company->fund_available -= $loan->loan_details_total();
            // $company->fund_profit += $loan->loan_details_total_interest();
            // $company->save();

            
            $company->fund_available -= $loan->loan_details_total();
            $company->fund_reserved += $loan->loan_details_total();
            $company->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // create success message 
        Session::flash('success_message', "Loan ID [' $loan_id '] has been approved!");

        return redirect()->route('loan.edit', ['id' => $loan_id]);
    }

    /**
     * Transfer loan
     */
    public function transfer(Request $request)
    {
        $company = Company::lockForUpdate()
            ->firstOrFail();
        $loan_id = $request['id'] ?? 0;
        $loan = Loan::lockForUpdate()
            ->findOrFail($loan_id);

        // check if okay to proceed
        if ($loan->is_approved == false) {
            Session::flash('error_message', "Please approve the loan first!");
            return redirect()->route('loan.edit', ['id' => $loan_id]);
        }

        // check if okay to proceed
        if ($loan->is_settled) {
            Session::flash('error_message', "This is a settled Loan!");
            return redirect()->route('loan.edit', ['id' => $loan_id]);
        }

        // check if okay to proceed
        if ($loan->is_transferred) {
            Session::flash('error_message', "Loan is already marked as Transferred!");
            return redirect()->route('loan.edit', ['id' => $loan_id]);
        }

        // Check if company has enough fund
        if ($loan->loan_details_total() > $company->fund_reserved) {
            Session::flash('error_message', "Company does not have reserved fund!");
            return redirect()->route('loan.edit', ['id' => $loan_id]);
        }

        DB::beginTransaction();
        try {
            $loan->is_transferred = true;
            $loan->lockForUpdate();
            $loan->save();

            $company->fund_total += $loan->loan_details_total();
            $company->fund_lended += $loan->loan_details_total();
            $company->fund_profit += $loan->loan_details_total_interest();
            $company->fund_reserved -= $loan->loan_details_total();
            $company->lockForUpdate();
            $company->save();

            $loan->borrower->balance = $loan->loan_details_total();
            $loan->borrower->lockForUpdate();
            $loan->borrower->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // create success message 
        Session::flash('success_message', "Loan ID [' $loan_id '] has been marked as Transferred!");

        return redirect()->route('loan.edit', ['id' => $loan_id]); 
    }
}
