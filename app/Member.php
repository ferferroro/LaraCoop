<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;
use Illuminate\Support\Facades\{Auth};
use Carbon\Carbon;

class Member extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'can_hold_fund' => 'boolean'
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
        });
    }

    /**
     * Get contributions
     */
    public function member_contributions()
    {
        return $this->hasMany('App\Contribution', 'member_id', 'id');
    }
    
}
