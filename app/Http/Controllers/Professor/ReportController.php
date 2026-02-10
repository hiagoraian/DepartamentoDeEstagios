<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $isLocked = $report->status === 'submitted' && $report->edit_unlocked === false;

        $report->load('schools.city');

        $cities = City::orderBy('name')->get();

        return view('professor.report.form', compact('report', 'semester', 'isLocked', 'cities'));
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

            // escolas atendidas
            'schools' => ['nullable', 'array'],
            'schools.*.city_id' => ['required', 'integer', 'exists:cities,id'],
            'schools.*.school_name' => ['required', 'string', 'max:255'],
            'schools.*.students_impacted' => ['required', 'integer', 'min:0'],

            //pdf
            'teaching_plan' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'visit_term' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],

        ]);

        // Upload de anexos (PDF)
        if ($request->hasFile('teaching_plan')) {
            // apaga o antigo se existir
            if ($report->teaching_plan_path) {
                Storage::disk('public')->delete($report->teaching_plan_path);
            }

            $path = $request->file('teaching_plan')->store('reports/' . $report->id, 'public');
            $data['teaching_plan_path'] = $path;
        }

        if ($request->hasFile('visit_term')) {
            if ($report->visit_term_path) {
                Storage::disk('public')->delete($report->visit_term_path);
            }

            $path = $request->file('visit_term')->store('reports/' . $report->id, 'public');
            $data['visit_term_path'] = $path;
        }


        $report->update([
            ...$data,
            'status' => 'draft',
        ]);

        $report->schools()->delete();

        if (!empty($data['schools'])) {
            foreach ($data['schools'] as $school) {
                $report->schools()->create([
                    'city_id' => $school['city_id'],
                    'school_name' => $school['school_name'],
                    'students_impacted' => (int) $school['students_impacted'],
                ]);
            }
        }

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
