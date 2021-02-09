<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_adjustments', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->nullable();
            $table->string('type')->nullable()->default('');
            $table->float('amount_from', 10,4)->default(0);
            $table->float('amount_to', 10,4)->default(0);
            $table->float('variance', 10,4)->default(0);
            $table->integer('adjusted_by')->nullable();
            $table->date('adjusted_at')->nullable();
            $table->string('search_text')->default('');
            $table->timestamps();
            $table->index(['search_text'], 'idx_001');
            $table->index(['company_id'], 'idx_002');
            $table->index(['adjusted_by'], 'idx_003');
            $table->index(['adjusted_at'], 'idx_004');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_adjustments');
    }
}
