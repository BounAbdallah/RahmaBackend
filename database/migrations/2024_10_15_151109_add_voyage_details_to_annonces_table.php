<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute les migrations.
     */
    public function up(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->string('pays_provenance_voyage')->nullable();
            $table->string('region_provenance_voyage')->nullable();
            $table->string('pays_destination_voyage')->nullable();
            $table->string('region_destination_voyage')->nullable();
            $table->date('date_prevue_voyage')->nullable();
            $table->time('heure_prevue_voyage')->nullable();
            $table->time('heure_debut_reception_colis')->nullable();
            $table->time('heure_fin_reception_colis')->nullable();
            $table->decimal('prix_par_kg', 8, 2)->nullable();
        });
    }

    /**
     * Annule les migrations.
     */
    public function down(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->dropColumn([
                'pays_provenance_voyage',
                'region_provenance_voyage',
                'pays_destination_voyage',
                'region_destination_voyage',
                'date_prevue_voyage',
                'heure_prevue_voyage',
                'heure_debut_reception_colis',
                'heure_fin_reception_colis',
                'prix_par_kg',
            ]);
        });
    }
};
