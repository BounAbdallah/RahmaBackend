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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('prix_kg');
            $table->dropColumn('pays_de_voyage');
            $table->dropColumn('region_de_voyage'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('prix_kg', 8, 2)->nullable();
            $table->string('pays_de_voyage')->nullable();
            $table->string('region_de_voyage')->nullable();
        });
    }
};
