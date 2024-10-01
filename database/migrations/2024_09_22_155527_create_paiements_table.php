<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant', 10, 2); // Montant total du paiement
            $table->unsignedBigInteger('colis_id')->nullable(); // Clé étrangère vers un colis
            $table->unsignedBigInteger('livraison_id')->nullable(); // Clé étrangère vers une livraison
            $table->unsignedBigInteger('user_id'); // Clé étrangère vers l'utilisateur
            $table->timestamps();
            $table->softDeletes();
            // Définir les relations
            $table->foreign('colis_id')->references('id')->on('colis')->onDelete('cascade');
            $table->foreign('livraison_id')->references('id')->on('livraisons')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Relation avec la table users
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paiements');
    }
}
