<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->nullable();
            $table->string('bank')->nullable()->default('');
            $table->string('account')->nullable()->default('');
            $table->string('search_text')->default('');
            $table->timestamps();
            $table->index(['member_id'], 'idx_001');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_accounts');
    }
}
