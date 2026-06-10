<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IsbnSubmission;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }
    
    public function index()
    {
        $stats = [
            'total_submissions' => IsbnSubmission::count(),
            'pending_submissions' => IsbnSubmission::pending()->count(),
            'approved_submissions' => IsbnSubmission::approved()->count(),
            'rejected_submissions' => IsbnSubmission::rejected()->count(),
            'total_users' => User::where('role', 'user')->count(),
        ];
        
        $recentSubmissions = IsbnSubmission::with('user')
            ->latest()
            ->take(10)
            ->get();
        
        // Get submissions by month for chart (last 6 months)
        $submissionsByMonth = IsbnSubmission::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
        
        return view('admin.dashboard', compact('stats', 'recentSubmissions', 'submissionsByMonth'));
    }
}
