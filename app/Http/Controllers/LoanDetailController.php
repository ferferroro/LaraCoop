<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Company, Loan, LoanDetail};
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

        $loan_detail_id = $request['id'] ?? 0;
        $loan_detail = LoanDetail::lockForUpdate()
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
                    $company->fund_lended -= $var_payment;
                    $company->fund_available += $var_payment;
                    $company->fund_profit += $var_payment;
                }
                $company->save();
            }

            $loan_detail->fill($validated);
            $loan_detail->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // create success message 
        Session::flash('success_message', "Loan Payment for term [' $loan_detail->term_number '] has been completed!");

        // redirect
        return redirect()->route('loan.edit', ['id' => $loan_detail->loan->id]);
    }
}
