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
        Schema::table('departements', function (Blueprint $table) {
            // Si vous voulez que arrondissements soit un tableau (JSON)
            $table->json('arrondissements')->nullable();
        });
    }

    public function down()
    {
        Schema::table('departements', function (Blueprint $table) {
            $table->dropColumn('arrondissements');
        });
    }

};
