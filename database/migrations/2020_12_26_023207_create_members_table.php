<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->integer('order')->default(0);
            $table->string('name')->default('');
            $table->string('address')->default('');
            $table->float('monthly_contribution', 10,4)->default(0);
            $table->float('total_contribution', 10,4)->default(0);
            $table->date('distribution_schedule')->nullable();
            $table->string('primary_contact')->default('');
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
        Schema::dropIfExists('members');
    }
}
