<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->nullable();
            $table->string('bank')->nullable()->default('');
            $table->string('name')->nullable()->default('');
            $table->string('account')->nullable()->default('');
            $table->float('amount', 10,4)->default(0);
            $table->string('search_text')->default('');
            $table->timestamps();
            $table->index(['company_id'], 'idx_001');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_accounts');
    }
}
