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
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->string('destination');
            $table->date('date_de_livraison');
            $table->string('statut');

            // Relations avec les utilisateurs (livreur, gestionnaire, client, GP) depuis la table users avec nullable
            $table->foreignId('livreur_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('gestionnaire_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('client_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('gp_id')->nullable()->constrained('users')->onDelete('cascade');

            // Relations existantes
            $table->foreignId('colis_id')->constrained('colis')->onDelete('cascade');
            $table->foreignId('zone_livraison_id')->constrained('zone_livraisons')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('livraisons');
    }
};
