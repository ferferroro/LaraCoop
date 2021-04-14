<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashboardDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_data', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->float('fund_total', 10,4)->default(0);
            $table->float('fund_available', 10,4)->default(0);
            $table->float('fund_lended', 10,4)->default(0);
            $table->float('fund_profit', 10,4)->default(0);
            $table->float('fund_reserved', 10,4)->default(0);

            $table->float('loans_01', 10,4)->default(0);
            $table->float('loans_02', 10,4)->default(0);
            $table->float('loans_03', 10,4)->default(0);
            $table->float('loans_04', 10,4)->default(0);
            $table->float('loans_05', 10,4)->default(0);
            $table->float('loans_06', 10,4)->default(0);
            $table->float('loans_07', 10,4)->default(0);
            $table->float('loans_08', 10,4)->default(0);
            $table->float('loans_09', 10,4)->default(0);
            $table->float('loans_10', 10,4)->default(0);
            $table->float('loans_11', 10,4)->default(0);
            $table->float('loans_12', 10,4)->default(0);

            $table->float('quote_01', 10,4)->default(0);
            $table->float('quote_02', 10,4)->default(0);
            $table->float('quote_03', 10,4)->default(0);
            $table->float('quote_04', 10,4)->default(0);
            $table->float('quote_05', 10,4)->default(0);
            $table->float('quote_06', 10,4)->default(0);
            $table->float('quote_07', 10,4)->default(0);
            $table->float('quote_08', 10,4)->default(0);
            $table->float('quote_09', 10,4)->default(0);
            $table->float('quote_10', 10,4)->default(0);
            $table->float('quote_11', 10,4)->default(0);
            $table->float('quote_12', 10,4)->default(0);

            $table->float('loan_new_count', 10,4)->default(0);
            $table->float('loan_settled_count', 10,4)->default(0);
            $table->float('loan_transferred_count', 10,4)->default(0);
            $table->float('loan_approved_count', 10,4)->default(0);

            $table->float('contribution_01', 10,4)->default(0);
            $table->float('contribution_02', 10,4)->default(0);
            $table->float('contribution_03', 10,4)->default(0);
            $table->float('contribution_04', 10,4)->default(0);
            $table->float('contribution_05', 10,4)->default(0);
            $table->float('contribution_06', 10,4)->default(0);
            $table->float('contribution_07', 10,4)->default(0);
            $table->float('contribution_08', 10,4)->default(0);
            $table->float('contribution_09', 10,4)->default(0);
            $table->float('contribution_10', 10,4)->default(0);
            $table->float('contribution_11', 10,4)->default(0);
            $table->float('contribution_12', 10,4)->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dashboard_data');
    }
}
