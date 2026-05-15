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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->enum('type_transaction', ['location', 'vente']);
            $table->enum('type_bien', ['appartement', 'maison', 'terrain', 'commercial']);
            $table->integer('surface');
            $table->integer('rooms')->nullable();
            $table->string('city');
            $table->enum('status', ['publiee', 'brouillon', 'archivee'])->default('publiee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
