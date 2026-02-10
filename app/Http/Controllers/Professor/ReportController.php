<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function show(string $semester)
    {
        $user = Auth::user();

        // Cria (se não existir) ou abre o relatório do semestre
        $report = Report::firstOrCreate(
            ['user_id' => $user->id, 'semester' => $semester],
            ['status' => 'draft', 'edit_unlocked' => false]
        );

        // Se já foi enviado e não está liberado, bloqueia edição (só visualiza)
        $isLocked = $report->status === 'submitted' && $report->edit_unlocked === false;

        // Carrega escolas relacionadas
        $report->load('schools.city');

        return view('professor.report.form', compact('report', 'semester', 'isLocked'));
    }

    public function save(Request $request, string $semester)
    {
        $user = Auth::user();

        $report = Report::where('user_id', $user->id)
            ->where('semester', $semester)
            ->firstOrFail();

        // Se travado, não permite salvar
        if ($report->status === 'submitted' && $report->edit_unlocked === false) {
            return redirect()->route('professor.report.show', $semester)
                ->with('error', 'Relatório enviado. Solicite liberação para editar.');
        }

        $data = $request->validate([
            'institution' => ['nullable', 'string', 'max:255'],
            'place' => ['nullable', 'string', 'max:255'],
            'course' => ['nullable', 'string', 'max:255'],

            'presentation' => ['nullable', 'string'],
            'activities_description' => ['nullable', 'string'],
            'teaching_assignments' => ['nullable', 'string'],
            'didactic_assignments' => ['nullable', 'string'],

            'positive_aspects' => ['nullable', 'string'],
            'negative_aspects' => ['nullable', 'string'],
            'improvement_suggestions' => ['nullable', 'string'],
            'enade' => ['nullable', 'string'],
            'conclusion' => ['nullable', 'string'],

            'semester_productions' => ['nullable', 'array'],
            'semester_productions.*' => ['string'],

            // anexos depois (vamos implementar já já)
        ]);

        $report->update([
            ...$data,
            'status' => 'draft',
        ]);

        return redirect()->route('professor.report.show', $semester)
            ->with('success', 'Rascunho salvo com sucesso!');
    }

    public function submit(Request $request, string $semester)
    {
        $user = Auth::user();

        $report = Report::where('user_id', $user->id)
            ->where('semester', $semester)
            ->firstOrFail();

        if ($report->status === 'submitted' && $report->edit_unlocked === false) {
            return redirect()->route('professor.report.show', $semester)
                ->with('error', 'Relatório já foi enviado.');
        }

        // Por enquanto, só marca como enviado.
        // Depois a gente pode exigir campos obrigatórios, anexos, etc.
        $report->update([
            'status' => 'submitted',
            'edit_unlocked' => false,
        ]);

        return redirect()->route('professor.report.show', $semester)
            ->with('success', 'Relatório enviado! Edição bloqueada.');
    }
}
