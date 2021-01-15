<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the borrower record associated with the contribution.
     */
    public function borrower()
    {
        return $this->hasOne('App\Borrower', 'id', 'borrower_id');
    }

    /**
     * Get the loan details
     */
    public function loan_details()
    {
        return $this->hasMany('App\LoanDetail', 'loan_id', 'id');
    }

    /**
     * Get the loan details total
     */
    public function loan_details_total()
    {
        return $this->loan_details->sum('amount_due');
    }

    /**
     * Get the loan details total
     */
    public function loan_details_total_principal()
    {
        return $this->loan_details->sum('amount_base');
    }

    /**
     * Get the loan details total
     */
    public function loan_details_total_interest()
    {
        return $this->loan_details->sum('interest_amount');
    }
}
