<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;
use Illuminate\Support\Facades\{Auth};
use Carbon\Carbon;

class Loan extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_settled' => 'boolean',
        'is_approved' => 'boolean',
        'is_transferred' => 'boolean'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->search_text = Helper::getSearchText($model);
            $model->created_by = Auth::id();
            $model->created_at = Carbon::now();
        });

        self::updating(function($model){
            $model->search_text = Helper::getSearchText($model);
            $model->updated_by = Auth::id();
            $model->updated_at = Carbon::now();

            if ($model->is_approved) {
                $model->approved_by = Auth::id();
                $model->approved_at = Carbon::now();
            }

            if ($model->is_transferred) {
                $model->transferred_by = Auth::id();
                $model->transferred_at = Carbon::now();
            }
        });
    }

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
