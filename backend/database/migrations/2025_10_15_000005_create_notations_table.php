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
        Schema::create('notations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jury_id')->constrained('users')->onDelete('cascade');
            $table->json('infos_candidat');
            $table->json('reponses_notation');
            $table->float('note_totale');
            $table->string('fichier_pdf', 255);
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notations');
    }
};
