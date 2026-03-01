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

    public function unlock(\App\Models\Report $report)
    {
        $report->edit_unlocked = true;
        $report->status = 'draft'; // volta para rascunho
        $report->save();

        return back()->with('success', 'Edição liberada. O relatório voltou para rascunho.');
    }

    public function destroy(Report $report)
    {
        $report->load('images');

        // Apagar PDFs
        if (!empty($report->teaching_plan_path)) {
            Storage::disk('public')->delete($report->teaching_plan_path);
        }

        if (!empty($report->visit_term_path)) {
            Storage::disk('public')->delete($report->visit_term_path);
        }

        // Apagar imagens
        foreach ($report->images as $img) {
            if (!empty($img->path)) {
                Storage::disk('public')->delete($img->path);
            }
        }

        $report->delete();

        return back()->with('success', 'Relatório excluído com sucesso.');
    }
}
