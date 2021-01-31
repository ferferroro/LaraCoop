<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;

class SystemUser extends Model
{
    protected $table = 'users';  // this model is for 'users' table as well

    protected $guarded = ['id'];

    protected $casts = [
        'can_approve_loans' => 'boolean',
        'can_apprrove_contributions' => 'boolean',
        'can_transfer_funds' => 'boolean',
        'can_view_other_records' => 'boolean',
        'can_update_records' => 'boolean',
    ];

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
