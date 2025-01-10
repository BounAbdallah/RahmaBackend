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
        Schema::table('livraisons', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère avant de supprimer la colonne
            $table->dropForeign(['colis_id']);

            // Supprimer les colonnes redondantes
            $table->dropColumn(['titre', 'description', 'statut', 'colis_id']);

            // Ajouter une clé étrangère vers la table commande
            $table->foreignId('commande_id')->after('id')->constrained('commandes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('livraisons', function (Blueprint $table) {
            // Restaurer les colonnes supprimées
            $table->string('titre');
            $table->text('description');
            $table->string('statut');
            $table->foreignId('colis_id')->constrained('colis')->onDelete('cascade');

            // Supprimer la clé étrangère et la colonne commande_id
            $table->dropForeign(['commande_id']);
            $table->dropColumn('commande_id');
        });
    }
};
