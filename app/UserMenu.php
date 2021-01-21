<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMenu extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the member record associated with the contribution.
     */
    public function menu()
    {
        return $this->hasOne('App\Menu', 'id', 'menu_id');
    }
}
