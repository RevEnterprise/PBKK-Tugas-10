<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/beranda', [PageController::class, 'index'])->name('beranda');
Route::get('/ide-agent', [PageController::class, 'agent'])->name('agent.idea');
Route::get('/profil-mahasiswa', [PageController::class, 'mahasiswaDetail'])->name('mahasiswa.detail');

Route::post('/agent/idea', [PageController::class, 'store'])->name('agent.idea.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/projects', [\App\Http\Controllers\AdminProjectController::class, 'index'])->name('admin.projects.index');
    Route::delete('/admin/projects/{project}', [\App\Http\Controllers\AdminProjectController::class, 'destroy'])
        ->middleware('role:Admin')
        ->name('admin.projects.destroy');
});

Route::fallback(function () {
    return view('errors.404');
});

require __DIR__.'/auth.php';
