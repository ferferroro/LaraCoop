<?php

namespace App;
use App\Helper\Helper;
use Illuminate\Support\Facades\{Auth};
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\{Company, CompanyAccount, Member};

class Transfer extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['transfer_from_name', 'transfer_to_name'];
    // protected $appends = ['transfer_to_name'];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->search_text = Helper::getSearchText($model);
            $model->transferred_by = Auth::id();
        });

        self::updating(function($model){
            $model->search_text = Helper::getSearchText($model);

            if ($model->is_accepted == true) {
                $model->accepted_by = Auth::id();
                $model->accepted_at =  Carbon::now();
            }
        });
    }

    /**
     * Get the account From
     */
    public function account_from_info()
    {
        
        if ($this->transfer_from != 0) {
            return $this->hasOne('App\MemberAccount', 'id', 'account_from');
        }
        else {
            return $this->hasOne('App\CompanyAccount','id', 'account_from');
        }
        
    }

    /**
     * Get the account To
     */
    public function account_to_info()
    {
        
        if ($this->transfer_to != 0) {
            return $this->hasOne('App\MemberAccount', 'id', 'account_to');
        }
        else {
            return $this->hasOne('App\CompanyAccount','id', 'account_to');
        }
        
    }

    /**
     * Get the accepted by
     */
    public function accepted_by_info()
    {
        return $this->hasOne('App\User', 'id', 'accepted_by');
    }

    /**
     * get transfer To Name
     */
    public function getTransferFromNameAttribute()
    {

        if ($this->transfer_from != 0) {
            $transfer_from = Member::where('id', $this->transfer_from)->first();
        }
        else {
            $transfer_from = Company::first();
        }

        if($transfer_from) {
            return "$transfer_from->name";
        }
        else {
            return "Unknown";
        }
    }


    /**
     * get transfer To Name
     */
    public function getTransferToNameAttribute()
    {

        if ($this->transfer_to != 0) {
            $transfer_to = Member::where('id', $this->transfer_to)->first();
        }
        else {
            $transfer_to = Company::first();
        }

        if($transfer_to) {
            return "$transfer_to->name";
        }
        else {
            return "Unknown";
        }
    }
}
