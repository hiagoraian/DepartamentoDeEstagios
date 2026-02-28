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
        $semester = $request->get('semester', '1.2026');

        $teachersTotal = \App\Models\User::where('is_admin', false)->count();

        $submittedCount = \App\Models\Report::where('semester', $semester)
            ->where('status', 'submitted')
            ->count();

        $pendingCount = \App\Models\Report::where('semester', $semester)
            ->where('status', 'draft')
            ->count();

        return view('admin.dashboard', compact(
            'semester',
            'teachersTotal',
            'submittedCount',
            'pendingCount'
        ));
    }
}
