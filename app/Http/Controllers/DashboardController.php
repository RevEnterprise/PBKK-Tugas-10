<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin|Staf');
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $isAdmin = $user->hasRole('Admin');
        $projectQuery = Project::query();

        if (! $isAdmin) {
            $projectQuery->where('user_id', $user->id);
        }

        $stats = [
            'projects' => (clone $projectQuery)->count(),
            'users' => User::count(),
            'today' => (clone $projectQuery)->whereDate('created_at', today())->count(),
        ];
        $recentProjects = (clone $projectQuery)->with('user')->latest()->take(6)->get();

        return view('admin.dashboard', compact('user', 'isAdmin', 'stats', 'recentProjects'));
    }
}
