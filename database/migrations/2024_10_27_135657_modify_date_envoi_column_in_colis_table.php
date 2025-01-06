<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('colis', function (Blueprint $table) {
            $table->timestamp('date_envoi')
                  ->nullable()
                  ->default(DB::raw('CURRENT_TIMESTAMP'))
                  ->change(); // Modifier la colonne date_envoi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colis', function (Blueprint $table) {
            $table->timestamp('date_envoi')
                  ->nullable(false)
                  ->default(null)
                  ->change(); // Restaurer la configuration précédente
        });
    }
};
