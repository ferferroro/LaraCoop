<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;
use Illuminate\Support\Facades\{Auth};
use Carbon\Carbon;

class CompanyAdjustment extends Model
{
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->search_text = Helper::getSearchText($model);
            $model->adjusted_by = Auth::id();
            $model->adjusted_at = Carbon::now();
        });

        self::updating(function($model){
            $model->search_text = Helper::getSearchText($model);
        });
    }

    /**
     * Get the user_adjusted record 
     */
    public function user_adjusted()
    {
        return $this->hasOne('App\User', 'id', 'adjusted_by');
    }

}
