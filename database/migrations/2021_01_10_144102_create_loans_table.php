<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->integer('borrower_id')->default(0);
            $table->string('loan_type')->default('');
            $table->date('date_loan')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->integer('terms')->default(0);
            $table->string('type_schedule')->default('');
            $table->boolean('is_settled')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->float('amount', 10,4)->default(0);
            $table->float('percent_interest', 10,4)->default(0);
            $table->float('percent_penalty', 10,4)->default(0);
            $table->integer('member_id')->default(0); // referrer
            $table->string('remarks')->default('');
            $table->timestamps();
            $table->string('search_text')->default('');
            $table->index(['search_text'], 'idx_001');
            $table->index(['borrower_id'], 'idx_002');
            $table->index(['loan_type'], 'idx_003');
        });

        Schema::create('loan_details', function (Blueprint $table) {
            $table->id();
            $table->integer('loan_id')->default(0);
            $table->integer('term_number')->default(0);
            $table->string('type_line')->default(''); 
            $table->date('date_payment_due')->nullable();
            $table->date('date_payment')->nullable();
            $table->float('amount_base', 10,4)->default(0);
            $table->float('interest_amount', 10,4)->default(0);
            $table->float('amount_due', 10,4)->default(0);
            $table->float('amount_payed', 10,4)->default(0);
            $table->timestamps();
            $table->index(['loan_id'], 'idx_001');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
        Schema::dropIfExists('loan_details');
    }
}
