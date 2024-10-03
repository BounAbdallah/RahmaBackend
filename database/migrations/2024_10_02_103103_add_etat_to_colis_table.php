<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEtatToColisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('colis', function (Blueprint $table) {
            // Ajoute la colonne 'etat' avec les valeurs possibles
            $table->enum('etat', [ 'archivé', 'desarchivé', 'en cours'])
                  ->default('en cours')
                  ->after('statut');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('colis', function (Blueprint $table) {
            // Supprime la colonne 'etat' si la migration est annulée
            $table->dropColumn('etat');
        });
    }
}
