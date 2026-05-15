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
    Schema::table('commentaires', function (Blueprint $table) {
        // Par défaut à false (0) car le propriétaire doit valider
        $table->boolean('is_approved')->default(false)->after('content');
    });
}

public function down(): void
{
    Schema::table('commentaires', function (Blueprint $table) {
        $table->dropColumn('is_approved');
    });
}
};