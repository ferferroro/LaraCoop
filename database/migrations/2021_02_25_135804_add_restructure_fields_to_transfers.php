<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRestructureFieldsToTransfers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropColumn('member_from');
            $table->dropColumn('member_to');
            $table->dropColumn('bank_from');
            $table->dropColumn('account_number_from');
            $table->dropColumn('bank_to');
            $table->dropColumn('account_number_to');

            $table->integer('transfer_from')->nullable();
            $table->integer('transfer_to')->nullable();
            $table->integer('account_from')->nullable();
            $table->integer('account_to')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->integer('member_from')->nullable();
            $table->integer('member_to')->nullable();
            $table->string('bank_from')->nullable()->default('');
            $table->string('account_number_from')->nullable()->default('');
            $table->string('bank_to')->nullable()->default('');
            $table->string('account_number_to')->nullable()->default('');
            $table->dropColumn('transfer_from');
            $table->dropColumn('transfer_to');
            $table->dropColumn('account_from');
            $table->dropColumn('account_to');
        });
    }
}
