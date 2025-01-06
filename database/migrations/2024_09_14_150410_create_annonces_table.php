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
        // Création de la table 'annonces'
        Schema::create('annonces', function (Blueprint $table) {
            // Colonne pour l'identifiant unique de l'annonce
            $table->id();

            // Colonne pour stocker l'image de l'annonce, peut être null
            $table->string('image')->nullable();

            // Colonne pour le titre de l'annonce
            $table->string('titre');

            // Colonne pour la date de début de réception du colis
            $table->timestamp('date_debut_reception_colis');

            // Colonne pour la date de fin de réception du colis
            $table->timestamp('date_fin_reception_colis');

            // Colonne pour la description de l'annonce
            $table->text('description');

            // Colonne pour le tarif de l'annonce, avec 2 décimales
            $table->decimal('tarif', 8, 2);

            // Colonne pour les conditions du service
            $table->text('condition');

            // Colonne pour le statut de l'annonce, avec les valeurs possibles 'active' ou 'expirée'
            $table->enum('statut', ['active', 'expirée']);

            // Colonne pour le poids en kilogrammes de l'annonce, avec précision de 2 décimales
            $table->decimal('poids_kg', 8, 2);

            // Colonne pour la clé étrangère vers l'utilisateur qui a créé l'annonce
            $table->foreignId('createur')->constrained('users')->onDelete('cascade');

            // Colonnes pour les timestamps 'created_at' et 'updated_at'
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Annule les migrations.
     */
    public function down(): void
    {
        // Suppression de la table 'annonces' si elle existe
        Schema::dropIfExists('annonces');
    }
};
