<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\City;
use Barryvdh\DomPDF\Facade\Pdf;



class GeneralReportController extends Controller
{
    public function index(Request $request)
    {
        $semester = $request->get('semester', '1.2026');
        $status = $request->get('status', 'all'); // all | submitted | draft
        $cityId = $request->get('city_id', 'all'); // all ou id


        $teachersTotal = User::where('is_admin', false)->count();

        $reportsQuery = Report::with(['user', 'schools.city'])
            ->where('semester', $semester);

        if ($status !== 'all') {
            $reportsQuery->where('status', $status);
        }

        if ($cityId !== 'all') {
            $reportsQuery->whereHas('schools', function ($q) use ($cityId) {
                $q->where('city_id', $cityId);
            });
        }


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

        // Contagem de produções (quantos relatórios marcaram cada item)
        $productionsCount = [
            'artigos' => 0,
            'palestras' => 0,
            'anais' => 0,
            'outros' => 0,
        ];

        foreach ($reports as $report) {
            $items = $report->semester_productions ?? [];
            if (!is_array($items)) $items = [];

            foreach (array_keys($productionsCount) as $key) {
                if (in_array($key, $items, true)) {
                    $productionsCount[$key]++;
                }
            }
        }

        // Top 10 cidades por alunos e por escolas (a partir do consolidado)
        $topCitiesByStudents = $byCity->sortByDesc('students')->take(10)->values();
        $topCitiesBySchools = $byCity->sortByDesc('schools')->take(10)->values();

        $cities = City::orderBy('name')->get();

        return view('admin.general-report.index', compact(
            'semester',
            'teachersTotal',
            'submittedCount',
            'draftCount',
            'notStartedCount',
            'totalSchools',
            'totalStudents',
            'reports',
            'byCity',
            'productionsCount',
            'topCitiesByStudents',
            'topCitiesBySchools',
            'status',
            'cityId',
            'cities',
        ));
    }

    public function show(\App\Models\Report $report)
    {
        $report->load(['user', 'schools.city']);

        return view('admin.reports.show', compact('report'));
    }

    public function pdf(Request $request)
    {
        $semester = $request->get('semester', '1.2026');

        // Reaproveita a mesma lógica do index (sem filtros extras)
        $teachersTotal = User::where('is_admin', false)->count();

        $reports = Report::with(['user', 'schools.city'])
            ->where('semester', $semester)
            ->get();

        $submittedCount = $reports->where('status', 'submitted')->count();
        $draftCount = $reports->where('status', 'draft')->count();
        $notStartedCount = max(0, $teachersTotal - $reports->count());

        $totalSchools = 0;
        $totalStudents = 0;

        foreach ($reports as $report) {
            $totalSchools += $report->schools->count();
            $totalStudents += $report->schools->sum('students_impacted');
        }

        // Produções
        $productionsCount = [
            'artigos' => 0,
            'palestras' => 0,
            'anais' => 0,
            'outros' => 0,
        ];

        foreach ($reports as $report) {
            $items = $report->semester_productions ?? [];
            if (!is_array($items)) $items = [];

            foreach (array_keys($productionsCount) as $key) {
                if (in_array($key, $items, true)) {
                    $productionsCount[$key]++;
                }
            }
        }

        // Consolidado por cidade
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

        $byCity = collect($byCity)->sortByDesc('students')->values();

        $topCitiesByStudents = $byCity->sortByDesc('students')->take(10)->values();
        $topCitiesBySchools = $byCity->sortByDesc('schools')->take(10)->values();

        // PDF (não inclui a tabela detalhada gigante; inclui apenas um resumo de professores que enviaram)
        $pdf = Pdf::loadView('admin.general-report.pdf', compact(
            'semester',
            'teachersTotal',
            'submittedCount',
            'draftCount',
            'notStartedCount',
            'totalSchools',
            'totalStudents',
            'productionsCount',
            'topCitiesByStudents',
            'topCitiesBySchools',
            'byCity',
            'reports'
        ))->setPaper('a4', 'portrait');

        return $pdf->download("relatorio-geral-{$semester}.pdf");
    }
}
