<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('order')->default(0);
            $table->string('name')->default('');
            $table->string('address')->default('');
            $table->float('percent_interest', 10,4)->default(0);
            $table->float('percent_penalty', 10,4)->default(0);
            $table->float('balance', 10,4)->default(0);
            $table->date('date_joined')->nullable();
            $table->string('primary_contact')->default('');
            $table->string('search_text')->default('');
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
        Schema::dropIfExists('borrowers');
    }
}
