<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;

class Menu extends Model
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
}
