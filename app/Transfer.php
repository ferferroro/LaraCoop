<?php

namespace App;
use App\Helper\Helper;
use Illuminate\Support\Facades\{Auth};
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $guarded = ['id'];

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
     * Get the borrower memberFrom
     */
    public function member_from_info()
    {
        return $this->hasOne('App\Member', 'id', 'member_from');
    }

    /**
     * Get the memberTo
     */
    public function member_to_info()
    {
        return $this->hasOne('App\Member', 'id', 'member_to');
    }

    /**
     * Get the accepted by
     */
    public function accepted_by_info()
    {
        return $this->hasOne('App\User', 'id', 'accepted_by');
    }
}
