<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovalFieldsToContributions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->boolean('is_approved')->nullable()->default(false);
            $table->integer('approved_by')->nullable();
            $table->date('approved_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('fund_collector')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->dropColumn('is_approved');
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_at');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('fund_collector');
        });
    }
}
