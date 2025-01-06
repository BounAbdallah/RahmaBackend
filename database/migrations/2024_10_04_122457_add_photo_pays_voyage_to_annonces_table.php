<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->string('photo_pays_voyage_provenance')
                  ->default('https://via.placeholder.com/150')
                  ->nullable()
                  ->after('titre');
            $table->string('photo_pays_voyage_destination')
                  ->default('https://via.placeholder.com/150')
                  ->nullable()
                  ->after('photo_pays_voyage_provenance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            //
        });
    }
};
