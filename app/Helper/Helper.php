<?php

namespace App\Helper;

use App\{Menu, UserMenu};
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    public static function getSearchText($model)
    {
      $search_text = '';

      foreach($model->getAttributes() as $key => $value) {

        if ($key != 'search_text' && $key != 'password') {
          $search_text = $search_text . "$value ";
        }
      }

      return $search_text;

    }

    public static function canUpdateRecords()
    {
        $user = Auth::user();

        return $user->can_update_records;
    }

    public static function canApproveContributions()
    {
        $user = Auth::user();

        return $user->can_approve_contributions;
    }

    public static function canApproveLoans()
    {
        $user = Auth::user();

        return $user->can_approve_loans;
    }

    public static function canTransferFunds()
    {
        $user = Auth::user();

        return $user->can_transfer_funds;
    }

    public static function isMasterAccount()
    {
        $user = Auth::user();

        return $user->is_master_account;
    }

    public static function incrementDate($day, $date, $interval)
    {

      $newDate = date('Y-m-d', strtotime($date));
      $newDate = Carbon::create($newDate);
      
      switch ($interval) {
                    
        case "Monthly":

            $newDate->addMonth(1);

            // new date has been computed
            // anything that will fall into this is either a month has no 29, has no 30, and has no 31
            if ($day = date('d', strtotime($newDate)) != $day  ) {

                // subtract any day to bring it back to previous month
                $newDate->addDays(-10);

                // get the last day of the month
                $newDate = date('Y-m-t', strtotime($newDate)); 
            }

            break;
        case "Semi-Monthly":
            $newDate->addDays(15);
            break;
        default:
            return 'Error!';

      }

      return $newDate;
    }
}