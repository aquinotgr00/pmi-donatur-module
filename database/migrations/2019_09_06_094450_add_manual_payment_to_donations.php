<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddManualPaymentToDonations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('donations', 'manual_payment')) {
             Schema::table('donations', function (Blueprint $table) {                
                $table->boolean('manual_payment')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('donations', 'manual_payment')) {
            Schema::table('donations', function (Blueprint $table) {
                $table->dropColumn('manual_payment');
            });
        }
    }
}
