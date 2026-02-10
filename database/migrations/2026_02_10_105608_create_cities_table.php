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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();

            // Nome da cidade (padronizado) e UF fixo MG
            $table->string('name');
            $table->char('uf', 2)->default('MG');

            // Código IBGE (opcional, mas excelente para padronizar)
            $table->string('ibge_code')->nullable()->unique();

            $table->timestamps();

            // Evita duplicidade (mesmo nome e uf)
            $table->unique(['name', 'uf']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
