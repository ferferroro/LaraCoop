<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;

class Company extends Model
{
    protected $guarded = ['id'];
    protected $table = 'company';

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
     * Get the company accounts details
     */
    public function company_accounts()
    {
        return $this->hasMany('App\CompanyAccount', 'company_id', 'id');
    }
}
