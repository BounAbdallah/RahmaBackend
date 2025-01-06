<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Schema::table('colis', function (Blueprint $table) {
        //     $table->unsignedBigInteger('reservation_id')->nullable()->after('id');
        //     $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Schema::table('colis', function (Blueprint $table) {
        //     $table->dropForeign(['reservation_id']);
        //     $table->dropColumn('reservation_id');
        // });
    }
};
