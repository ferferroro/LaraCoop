<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardData extends Model
{
    /**
     * Guard the primary key
     */
    protected $guarded = ['id'];
    protected $table = 'dashboard_data';

}
