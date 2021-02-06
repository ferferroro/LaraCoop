<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->integer('member_from')->nullable();
            $table->integer('member_to')->nullable();
            $table->integer('transferred_by')->nullable();
            $table->date('transferred_at')->nullable();
            $table->boolean('is_accepted')->nullable()->default(false);
            $table->integer('accepted_by')->nullable();
            $table->date('accepted_at')->nullable();
            $table->string('bank_from')->nullable()->default('');
            $table->string('account_number_from')->nullable()->default('');
            $table->string('bank_to')->nullable()->default('');
            $table->string('account_number_to')->nullable()->default('');
            $table->string('remarks')->nullable()->default('');
            $table->float('amount', 10,4)->default(0);
            $table->string('search_text')->default('');
            $table->timestamps();
            $table->index(['search_text'], 'idx_001');
            $table->index(['member_from'], 'idx_002');
            $table->index(['member_to'], 'idx_003');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
}
