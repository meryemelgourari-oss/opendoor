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
        Schema::create('reclamations', function (Blueprint $table) {
          $table->id();
        // Le propriétaire qui envoie la réclamation
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        $table->string('subject'); // Objet de la plainte (ex: Problème de paiement, Bug annonce)
        $table->text('message');   // Le contenu du message
        
        // États de la réclamation
        $table->boolean('is_read')->default(false); // Pour le badge de notification
        $table->enum('priority', ['basse', 'normale', 'urgente'])->default('normale');
        $table->enum('status', ['ouvert', 'en_cours', 'resolu'])->default('ouvert');

        $table->timestamps();
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reclamations');
    }
};
