<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Semestre selecionado via query string (?semester=1.2026)
        $semester = $request->get('semester', '1.2026');

        // Total de professores (não-admin)
        $teachersTotal = User::where('is_admin', false)->count();

        // Quantos enviaram no semestre
        $submittedCount = Report::where('semester', $semester)
            ->where('status', 'submitted')
            ->count();

        // Pendentes = total - enviados (inclui rascunho e não iniciou)
        $pendingCount = max(0, $teachersTotal - $submittedCount);

        return view('admin.dashboard', compact(
            'semester',
            'teachersTotal',
            'submittedCount',
            'pendingCount'
        ));
    }
}
