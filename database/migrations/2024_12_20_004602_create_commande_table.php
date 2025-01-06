<?php

use App\Models\Colis;
use App\Models\User;
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
        Schema::create('commande', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->enum('status', [
                'en_attente',
                'approuver',
                'desaprouver',
                'attribuer_au_livreur',
                'en_route',
                'livrer',
            ]);
            $table->enum('type_livraison', [
                'Livraison standard',
                'Livraison express',
                'Livraison domicile',
                'Livraison sur_demande',
            ]);
            $table->date('jour_livraison')->nullable(); 
            $table->time('heure_livraison')->nullable(); 
            $table->string('adresse_destinateur'); 
            $table->text('description');
            $table->text('message')->nullable();
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Colis::class)->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande');
    }
};
