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
            $table->string('pays_provenance')
                  ->default('Sénégal')
                  ->nullable()
                  ->after('titre');
            $table->string('pays_destination')
                  ->default('France')
                  ->nullable()
                  ->after('pays_provenance');
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
