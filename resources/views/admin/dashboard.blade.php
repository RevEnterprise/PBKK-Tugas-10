@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
    <p class="text-muted">Selamat datang, {{ $user->name }} ({{ $isAdmin ? 'Admin' : 'Staf' }}).</p>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-4 col-12">
            <div class="small-box bg-info">
                <div class="inner"><h3>{{ $stats['projects'] }}</h3><p>Total Project {{ $isAdmin ? 'Seluruh Pengguna' : 'Saya' }}</p></div>
                <div class="icon"><i class="bi bi-folder"></i></div>
                <a href="{{ route('admin.projects.index') }}" class="small-box-footer">Lihat project <i class="bi bi-arrow-right-circle"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="small-box bg-success">
                <div class="inner"><h3>{{ $stats['users'] }}</h3><p>Total Pengguna Terdaftar</p></div>
                <div class="icon"><i class="bi bi-people"></i></div>
                <span class="small-box-footer">{{ $isAdmin ? 'Data seluruh pengguna' : 'Akses staf terbatas' }}</span>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="small-box bg-warning">
                <div class="inner"><h3>{{ $stats['today'] }}</h3><p>Project Ditambahkan Hari Ini</p></div>
                <div class="icon"><i class="bi bi-calendar-day"></i></div>
                <a href="{{ route('admin.projects.index') }}" class="small-box-footer">Lihat data <i class="bi bi-arrow-right-circle"></i></a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h3 class="card-title">Project Terbaru</h3></div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead><tr><th>Judul</th><th>Pemilik</th><th>Tema Agent</th><th>Dibuat</th></tr></thead>
                <tbody>
                    @forelse ($recentProjects as $project)
                        <tr>
                            <td>{{ $project->judul }}</td>
                            <td>{{ $project->user?->name ?? '-' }}</td>
                            <td>{{ $project->tema_agent }}</td>
                            <td>{{ $project->created_at?->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">Belum ada project.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop

