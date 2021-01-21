<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('element_name')->default('');
            $table->string('display_name')->default('');
            $table->string('route')->default('');
            $table->string('link')->default('');
            $table->integer('sequence')->default(0);
            $table->string('icon_class')->default('');
            $table->boolean('restricted')->default(false);
            $table->timestamps();
            $table->index(['sequence'], 'idx_001');
            $table->index(['link'], 'idx_002');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
