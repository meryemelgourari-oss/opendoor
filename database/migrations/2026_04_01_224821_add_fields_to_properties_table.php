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
    Schema::table('properties', function (Blueprint $table) {
        // 1. Ajouter le téléphone (après l'adresse par exemple)
        $table->string('phone', 20)->nullable()->after('address');

        // 2. Ajouter le système de modération
        // Par défaut 'false', l'admin devra passer à 'true'
        $table->boolean('is_approved')->default(false)->after('status');
        
        // Optionnel : date de validation pour l'historique
        $table->timestamp('approved_at')->nullable()->after('is_approved');
    });
}

public function down(): void
{
    Schema::table('properties', function (Blueprint $table) {
        $table->dropColumn(['phone', 'is_approved', 'approved_at']);
    });
}
};
