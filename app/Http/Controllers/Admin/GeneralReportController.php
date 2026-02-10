<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class GeneralReportController extends Controller
{
    public function index(Request $request)
    {
        $semester = $request->get('semester', '1.2026');

        $teachersTotal = User::where('is_admin', false)->count();

        // Relatórios do semestre (com escolas e cidade)
        $reportsQuery = Report::with(['user', 'schools.city'])
            ->where('semester', $semester);

        $reports = $reportsQuery->get();

        $submittedCount = $reports->where('status', 'submitted')->count();
        $draftCount = $reports->where('status', 'draft')->count();
        $notStartedCount = max(0, $teachersTotal - $reports->count());

        // Total de escolas e alunos (somando todas as escolas de todos os relatórios do semestre)
        $totalSchools = 0;
        $totalStudents = 0;

        foreach ($reports as $report) {
            $totalSchools += $report->schools->count();
            $totalStudents += $report->schools->sum('students_impacted');
        }

        // Agrupado por cidade (nome da cidade -> alunos total, escolas total)
        $byCity = [];

        foreach ($reports as $report) {
            foreach ($report->schools as $school) {
                $cityName = $school->city?->name ?? 'Sem cidade';

                if (!isset($byCity[$cityName])) {
                    $byCity[$cityName] = [
                        'city' => $cityName,
                        'schools' => 0,
                        'students' => 0,
                    ];
                }

                $byCity[$cityName]['schools'] += 1;
                $byCity[$cityName]['students'] += (int) $school->students_impacted;
            }
        }

        // Ordenar cidades por alunos desc
        $byCity = collect($byCity)->sortByDesc('students')->values();

        return view('admin.general-report.index', compact(
            'semester',
            'teachersTotal',
            'submittedCount',
            'draftCount',
            'notStartedCount',
            'totalSchools',
            'totalStudents',
            'reports',
            'byCity'
        ));
    }
}
