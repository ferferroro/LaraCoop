<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Company, Loan, LoanDetail, CompanyAccount, MemberAccount};
use Illuminate\Validation\Rule;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanDetailController extends Controller
{
    /**
     * Pay
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request)
    {
        
        $validated = $request->validate([
            'id' => 'required|exists:loan_details,id',
            'loan_id' => 'required|exists:loans,id',
            'amount_payed' => 'required|numeric|min:0',
            'date_payment' => 'required|date',
        ]);

        $settled_message = '';

        $loan_detail_id = $request['id'] ?? 0;
        $loan_detail = LoanDetail::with('loan')
            ->findOrFail($loan_detail_id);
        $company = Company::lockForUpdate()
            ->firstOrFail();
        
        // should not happen because the buttons are suppose to be not clickable but add a extra check
        if ($loan_detail->loan->is_settled) {
            Session::flash('error_message', "Loan is settled, unable to make any payments!");
            return redirect()->route('loan.edit', ['id' => $loan_detail->loan->id]);
        }
        // should not happen because the buttons are suppose to be not clickable but add a extra check
        if ($loan_detail->loan->is_approved == false) {
            Session::flash('error_message', "Loan is not yet approved, unable to make any payments!");
            return redirect()->route('loan.edit', ['id' => $loan_detail->loan->id]);
        }
        // should not happen because the buttons are suppose to be not clickable but add a extra check
        if ($loan_detail->loan->is_transferred == false) {
            Session::flash('error_message', "Loan amount is not yet transferred to client, unable to make any payments!");
            return redirect()->route('loan.edit', ['id' => $loan_detail->loan->id]);
        }

        DB::beginTransaction();
        try {
            /**
             * cases
             * 1. you paid 0  previously and then you changed it to 10
             *  Result: add 10 to company fund (new - old)
             * 2. you paid 10 previously and then you changed it to 0
             *  Result: add -10 to company fund (new - old)
             * 3. you paid 0  previously and then you changed it to 0
             *  Result: add 0 to company fund (new - old)
             */
            $old_payment = $loan_detail->amount_payed;
            $new_payment = $validated['amount_payed'];
            $var_payment = $new_payment - $old_payment;

            if ($var_payment != 0) {
                if ($loan_detail->type_line == 'Amortization') {
                    $company->fund_lended -= $var_payment;
                    $company->fund_available += $var_payment;
                }

                if ($loan_detail->type_line == 'Penalty') {
                    $company->fund_total += $var_payment;
                    $company->fund_available += $var_payment;
                    $company->fund_profit += $var_payment;
                }

                if ($company->fund_lended < 0) {
                    $company->fund_lended = 0;
                }

                $member_account = MemberAccount::findOrFail($loan_detail->loan->member_account_id);
                if ($member_account) {
                    $member_account->amount += $var_payment;
                    $member_account->lockForUpdate();
                    $member_account->save();   
                }
                else {
                     // wont likely to happen, but let us add a default company account to prevent orphan records
                    $company_account = CompanyAccount::first();
                    if (!$company_account) {
                        $company_account = new CompanyAccount;
                        $company_account->company_id = $company->id;
                        $company_account->bank = "Unamed Bank";
                        $company_account->name = "Unamed Account";
                        $company_account->account = "N/A";
                    }
                    else {
                        $company_account->lockForUpdate();
                    }
                    $company_account->amount += $var_payment;
                    $company_account->save();      
                } 
                
                $company->lockForUpdate();
                $company->save();

                $loan_detail->loan->borrower->balance -= $var_payment;
                $loan_detail->loan->borrower->lockForUpdate();
                $loan_detail->loan->borrower->save();
            }

            $loan_detail->fill($validated);
            $loan_detail->lockForUpdate();
            $loan_detail->save();


            $is_settled = false;
            foreach($loan_detail->loan->loan_details as $each_detail) {
                if ($each_detail->amount_payed < $each_detail->amount_due) {
                    $is_settled = false;
                    break;
                }
                else {
                    $is_settled = true;
                }
            }

            // if all payment is complete then mark it as settled
            if ($is_settled) {
                $loan_detail->loan->is_settled = true;
                $loan_detail->loan->lockForUpdate();
                $loan_detail->loan->save();
                // create success message 
                $settled_message = ' Loan has been automatically marked as settled!';
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // create success message 
        Session::flash('success_message', "Loan Payment for term [' $loan_detail->term_number '] has been completed! $settled_message");

        // redirect
        return redirect()->route('loan.edit', ['id' => $loan_detail->loan->id]);
    }

    /**
     * Add penalty
     */
    public function add_penalty(Request $request)
    {
        
        $validated = $request->validate([
            'id' => 'required|exists:loan_details,id',
            'loan_id' => 'required|exists:loans,id',
            'date_payment_due' => 'required|date',
            'amount_due' => 'required|numeric|min:0',
        ]);

        $loan_id = $request['loan_id'] ?? 0;
        $loan = Loan::findOrFail($loan_id);
        $company = Company::lockForUpdate()
            ->firstOrFail();
        
        // should not happen because the buttons are suppose to be not clickable but add a extra check
        if ($loan->is_settled) {
            Session::flash('error_message', "Loan is settled, unable to create penalty!");
            return redirect()->route('loan.edit', ['id' => $loan_detail->loan->id]);
        }
        // should not happen because the buttons are suppose to be not clickable but add a extra check
        if ($loan->is_approved == false) {
            Session::flash('error_message', "Loan is not yet approved, unable to create penalty!");
            return redirect()->route('loan.edit', ['id' => $loan->id]);
        }
        // should not happen because the buttons are suppose to be not clickable but add a extra check
        if ($loan->is_transferred == false) {
            Session::flash('error_message', "Loan amount is not yet transferred to client, unable to create penalty!");
            return redirect()->route('loan.edit', ['id' => $loan_detail->loan->id]);
        }

        DB::beginTransaction();
        try {

            $last_loan = LoanDetail::where('loan_id', $loan->id)
                ->orderBy('term_number', 'desc')->first();

            $loan_detail = new LoanDetail;
            $loan_detail->loan_id = $loan->id;
            $loan_detail->term_number = $last_loan->term_number + 1;
            $loan_detail->type_line = "Penalty";
            $loan_detail->date_payment_due = $validated['date_payment_due'];
            $loan_detail->amount_base = $validated['amount_due'];
            $loan_detail->interest_amount = 0;
            $loan_detail->amount_due = $validated['amount_due'];
            $loan_detail->lockForUpdate();
            $loan_detail->save();

            $loan_detail->loan->borrower->balance += $loan_detail->amount_due;
            $loan_detail->loan->borrower->lockForUpdate();
            $loan_detail->loan->borrower->save();
            
            $company->fund_total += $loan_detail->amount_due;
            $company->fund_profit += $loan_detail->amount_due;
            $company->lockForUpdate();
            $company->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // create success message 
        Session::flash('success_message', "Penalty has been added!");

        // redirect
        return redirect()->route('loan.edit', ['id' => $loan_detail->loan->id]);
    }
}
