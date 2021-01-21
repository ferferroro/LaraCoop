<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_menus', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->integer('menu_id')->default(0);
            $table->integer('sequence')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
            $table->index(['user_id'], 'idx_001');
            $table->index(['sequence'], 'idx_002');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_menus');
    }
}
