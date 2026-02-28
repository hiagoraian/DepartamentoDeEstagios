<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportStatusController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $semester = $request->get('semester', '1.2026');

        $reports = \App\Models\Report::with('user')
            ->where('semester', $semester)
            ->orderByRaw("CASE WHEN status = 'draft' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reports.index', compact('semester', 'reports'));
    }

    public function unlock(Report $report)
    {
        $report->update([
            'edit_unlocked' => true,
        ]);

        return redirect()->back()->with('success', 'Edição liberada para o professor.');
    }

    public function destroy(Report $report)
    {
        // Segurança: impedir excluir relatório enviado (por enquanto)
        if ($report->status === 'submitted') {
            return back()->with('error', 'Não é possível excluir um relatório enviado.');
        }

        // Carrega imagens relacionadas
        $report->load('images');

        // Apagar PDFs
        if (!empty($report->teaching_plan_path)) {
            Storage::disk('public')->delete($report->teaching_plan_path);
        }

        if (!empty($report->visit_term_path)) {
            Storage::disk('public')->delete($report->visit_term_path);
        }

        // Apagar imagens do storage
        foreach ($report->images as $img) {
            if (!empty($img->path)) {
                Storage::disk('public')->delete($img->path);
            }
        }

        // Apagar registro (imagens no banco serão deletadas via cascade)
        $report->delete();

        return back()->with('success', 'Relatório excluído com sucesso.');
    }
}
