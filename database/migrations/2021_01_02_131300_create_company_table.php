<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('');
            $table->string('primary_contact')->default('');
            $table->string('address')->default('');
            $table->float('percent_interest', 10,4)->default(0);
            $table->float('percent_penalty', 10,4)->default(0);
            $table->float('fund_total', 10,4)->default(0);
            $table->float('fund_available', 10,4)->default(0);
            $table->float('fund_lended', 10,4)->default(0);
            $table->float('fund_profit', 10,4)->default(0);
            $table->date('date_founded')->nullable();
            $table->string('mission')->default('');
            $table->string('vision')->default('');
            $table->string('search_text')->default('');
            $table->timestamps();
            $table->index(['search_text'], 'idx_001');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company');
    }
}
