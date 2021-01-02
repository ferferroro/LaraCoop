<?php
namespace App\Setups;
use Illuminate\Support\Facades\DB;

class AppSetup
{
      public function setupHasBeenRan()
      {
            $company = DB::table('company')->first();
            $users = DB::table('users')->first();

            if ($company AND $users) {
                  return true;
            }
            else {
                  return false;
            }

            
      }

      // public function startQueryLog()
      // {
      //       \DB::enableQueryLog();
      // }

      // public function showQueries()
      // {
      //       dd(\DB::getQueryLog());
      // }

      public static function instance()
      {
            return new AppSetup();
      }
}