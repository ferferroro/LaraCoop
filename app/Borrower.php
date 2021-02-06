<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;
use Illuminate\Support\Facades\{Auth};
use Carbon\Carbon;

class Borrower extends Model
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
