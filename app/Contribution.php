<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;
use Illuminate\Support\Facades\{Auth};
use Carbon\Carbon;

class Contribution extends Model
{
    /**
     * Guard the primary key
     */
    protected $guarded = ['id'];

    protected $casts = [
        'is_approved' => 'boolean'
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

            if ($model->is_approved == true) {
                $model->approved_by = Auth::id();
                $model->approved_at = Carbon::now();
            }
        });
    }

    /**
     * Get the member record associated with the contribution.
     */
    public function member()
    {
        return $this->hasOne('App\Member', 'id', 'member_id');
    }


}
