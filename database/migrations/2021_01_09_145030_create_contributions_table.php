<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->default(0);
            $table->string('period')->default('');
            $table->float('amount', 10,4)->default(0);
            $table->string('remarks')->default('');
            $table->string('search_text')->default('');
            $table->integer('user_id')->default(0);
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
        Schema::dropIfExists('contributions');
    }
}
