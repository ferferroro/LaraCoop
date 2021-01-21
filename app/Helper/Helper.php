<?php

namespace App\Helper;

use App\{Menu, UserMenu};
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function getMenuList()
    {
        $user = Auth::user();

        if ($user->is_master_account) {
            $menus = Menu::orderBy('sequence', 'asc')
              ->get();
        }
        else {
            $user_menus = UserMenu::with('menu')
              ->where('user_id', $user->id)
              ->orderBy('sequence', 'asc')
              ->get();

            $menus = [];
            foreach ($user_menus as $user_menu) {
              $menus[] = $user_menu->menu;
            }
        }

        return $menus;
    }

    public static function hasMenu()
    {
      $user = Auth::user();
      
      if ($user->is_master_account) {
        $menu = Menu::first();

        if ($menu) {
          return true;
        }
        else {
          return false;
        }
      }
      else {
        $user_menu = UserMenu::first();

        if ($user_menu) {
          return true;
        }
        else {
          return false;
        }
      }

    }
}