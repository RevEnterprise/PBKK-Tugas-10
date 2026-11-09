<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin|Staf');
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $query = Project::query()->with('user')->latest();

        if (! $user->hasRole('Admin')) {
            $query->where('user_id', $user->id);
        }

        $projects = $query
            ->when($request->filled('search'), function ($builder) use ($request): void {
                $keyword = $request->string('search')->toString();
                $builder->where(function ($subQuery) use ($keyword): void {
                    $subQuery->where('judul', 'like', "%{$keyword}%")
                        ->orWhere('tema_agent', 'like', "%{$keyword}%")
                        ->orWhere('deskripsi', 'like', "%{$keyword}%")
                        ->orWhereHas('user', fn ($userQuery) => $userQuery->where('name', 'like', "%{$keyword}%"));
                });
            })
            ->paginate(10)
            ->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    public function destroy(Project $project): RedirectResponse
    {
        abort_unless(auth()->user()->hasRole('Admin'), 403);
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Data project berhasil dihapus.');
    }
}
