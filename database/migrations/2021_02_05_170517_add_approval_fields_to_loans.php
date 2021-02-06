<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovalFieldsToLoans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->integer('created_by')->nullable()->default(0);
            $table->integer('updated_by')->nullable()->default(0);
            $table->integer('approved_by')->nullable()->default(0);
            $table->date('approved_at')->nullable();
            $table->boolean('is_transferred')->nullable()->default(false);
            $table->integer('transferred_by')->nullable()->default(0);
            $table->date('transferred_at')->nullable();
            
        });

        Schema::table('company', function (Blueprint $table) {
            $table->float('fund_reserved', 10,4)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_at');
            $table->dropColumn('is_transferred');
            $table->dropColumn('transferred_by');
            $table->dropColumn('transferred_at');
        });

        Schema::table('company', function (Blueprint $table) {
            $table->dropColumn('fund_reserved');
        });
    }
}
