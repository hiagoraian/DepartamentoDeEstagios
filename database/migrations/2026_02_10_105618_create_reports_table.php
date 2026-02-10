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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // Dono do relatório
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Semestre no formato "1.2026"
            $table->string('semester');

            // Configurações gerais
            $table->string('institution')->nullable();
            $table->string('place')->nullable(); // Local
            $table->string('course')->nullable();

            // Textos grandes
            $table->longText('presentation')->nullable();
            $table->longText('activities_description')->nullable();
            $table->longText('teaching_assignments')->nullable(); // Encargos Docentes
            $table->longText('didactic_assignments')->nullable(); // Encargos Didático

            $table->longText('positive_aspects')->nullable();
            $table->longText('negative_aspects')->nullable();
            $table->longText('improvement_suggestions')->nullable();
            $table->longText('enade')->nullable();
            $table->longText('conclusion')->nullable();

            // Produções do semestre (caixinhas)
            $table->json('semester_productions')->nullable();

            // Anexos (caminhos no storage)
            $table->string('teaching_plan_path')->nullable(); // Plano de Ensino (PDF)
            $table->string('visit_term_path')->nullable();    // Termo de Visita (PDF)

            // Controle de envio/bloqueio
            $table->enum('status', ['draft', 'submitted'])->default('draft');
            $table->boolean('edit_unlocked')->default(false);

            $table->timestamps();

            // Um relatório por professor por semestre
            $table->unique(['user_id', 'semester']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
