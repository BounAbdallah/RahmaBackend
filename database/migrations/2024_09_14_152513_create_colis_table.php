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
        Schema::create('colis', function (Blueprint $table) {
            $table->id(); // Identifiant unique pour le colis
            $table->string('titre'); // Titre du colis
            $table->string('image_1')->nullable(); // URL ou chemin de la première image du colis
            $table->string('image_2')->nullable(); // URL ou chemin de la deuxième image du colis
            $table->string('image_3')->nullable(); // URL ou chemin de la troisième image du colis
            $table->decimal('poids_kg', 8, 2); // Poids du colis en kilogrammes
            $table->text('adresse_expediteur'); // Adresse de l'expéditeur
            $table->text('adresse_destinataire'); // Adresse du destinataire
            $table->string('contact_destinataire'); // Contact du destinataire
            $table->string('contact_expediteur'); // Contact de l'expéditeur
            $table->timestamp('date_envoi'); // Date d'envoi du colis
            $table->timestamp('date_reception')->nullable(); // Date de réception (prévue ou effective)
            $table->enum('statut', ['en transit', 'livré', 'en attente', 'retourné']); // Statut du colis
            $table->text('description')->nullable(); // Description du contenu ou autres détails
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Clé étrangère pour l'utilisateur qui envoie le colis
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colis');
    }
};
