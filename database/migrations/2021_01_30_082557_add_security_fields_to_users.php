<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecurityFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('contact')->default('');
            $table->boolean('can_approve_loans')->default(false);
            $table->boolean('can_approve_contributions')->default(false);
            $table->boolean('can_transfer_funds')->default(false);
            $table->integer('borrower_id')->nullable();
            $table->integer('member_id')->nullable();
            $table->boolean('can_view_other_records')->default(false);
            $table->boolean('can_update_records')->default(false);
            $table->string('side_bg_color')->default('white');
            $table->string('side_active_color')->default('danger');
            $table->string('search_text')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('contact');
            $table->dropColumn('can_approve_loans');
            $table->dropColumn('can_approve_contributions');
            $table->dropColumn('can_transfer_funds');
            $table->dropColumn('borrower_id');
            $table->dropColumn('member_id');
            $table->dropColumn('can_view_other_records');
            $table->dropColumn('can_update_records');
            $table->dropColumn('side_bg_color');
            $table->dropColumn('side_active_color');
            $table->dropColumn('search_text');
            
        });
    }
}
