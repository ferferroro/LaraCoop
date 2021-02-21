<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;

class MemberAccount extends Model
{
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->search_text = Helper::getSearchText($model);
        });

        self::updating(function($model){
            $model->search_text = Helper::getSearchText($model);
        });
    }

    /**
     * Get member
     */
    public function member()
    {
        return $this->belongsTo('App\Member', 'member_id', 'id');
    }
}
