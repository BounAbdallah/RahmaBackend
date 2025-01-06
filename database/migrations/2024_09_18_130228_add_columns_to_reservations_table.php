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
        Schema::table('reservation', function (Blueprint $table) {
            // Ajout des colonnes
            $table->foreignId('annonce_id')->constrained('annonces')->onDelete('cascade')->after('id');
            $table->timestamp('date_reservation')->nullable()->after('annonce_id');
            $table->enum('status', ['confirmée', 'annulée', 'en attente'])->default('en attente')->after('date_reservation');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['annonce_id']);
            $table->dropColumn('annonce_id');
            $table->dropColumn('date_reservation');
            $table->dropColumn('status');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
