<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportStatusController extends Controller
{
    public function index(Request $request)
    {
        $semester = $request->get('semester', '1.2026');

        $teachers = User::where('is_admin', false)
            ->orderBy('name')
            ->get();

        $reports = Report::where('semester', $semester)
            ->get()
            ->keyBy('user_id');

        return view('admin.reports.index', compact('teachers', 'reports', 'semester'));
    }

    public function unlock(Report $report)
    {
        $report->update([
            'edit_unlocked' => true,
        ]);

        return redirect()->back()->with('success', 'Edição liberada para o professor.');
    }
}
