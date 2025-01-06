<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColisIdToReservationsTable extends Migration
{
    public function up()
    {
        Schema::table('reservation', function (Blueprint $table) {
            $table->unsignedBigInteger('colis_id')->nullable()->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('reservation', function (Blueprint $table) {
            $table->dropColumn('colis_id');
        });
    }
}
