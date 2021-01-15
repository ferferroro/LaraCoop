<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanDetail extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the loan etails
     */
    public function loan()
    {
        return $this->belongsTo('App\Loan', 'loan_id', 'id');
    }
}
