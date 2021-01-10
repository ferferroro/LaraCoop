<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    /**
     * Guard the primary key
     */
    protected $guarded = ['id'];

    /**
     * Get the member record associated with the contribution.
     */
    public function member()
    {
        return $this->hasOne('App\Member', 'id', 'member_id');
    }
}
