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
        Schema::create('tarifs', function (Blueprint $table) {
            $table->id();
            $table->decimal('sommes', 8, 2); // Montant du tarif avec précision
            $table->text('description')->nullable(); // Description du tarif (peut être nul)

            // Clé étrangère vers zone_livraison avec suppression en cascade
            $table->foreignId('zone_livraison_id')->constrained('zone_livraisons')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tarifs');
    }
};
