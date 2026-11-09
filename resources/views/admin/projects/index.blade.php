@extends('adminlte::page')

@section('title', 'Data Project')

@section('content_header')
    <h1>Data Project</h1>
    <p class="text-muted">{{ auth()->user()->hasRole('Admin') ? 'Admin dapat melihat dan menghapus seluruh project.' : 'Staf hanya dapat melihat project miliknya.' }}</p>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <form action="{{ route('admin.projects.index') }}" method="GET" class="d-flex">
                <div class="input-group input-group-sm" style="width: 360px;">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari judul, tema, deskripsi, pemilik...">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Cari</button>
                    @if (request()->filled('search'))
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead><tr><th>#</th><th>Judul Project</th><th>Pemilik</th><th>Tema Agent</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>{{ $projects->firstItem() + $loop->index }}</td>
                            <td><strong>{{ $project->judul }}</strong><br><small class="text-muted">{{ Str::limit($project->deskripsi, 75) }}</small></td>
                            <td>{{ $project->user?->name ?? '-' }}</td>
                            <td><span class="badge bg-info">{{ $project->tema_agent }}</span></td>
                            <td>{{ $project->created_at?->format('d/m/Y') }}</td>
                            <td>
                                @role('Admin')
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus project ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                @else
                                    <span class="text-muted">Tidak ada aksi</span>
                                @endrole
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center p-4">Data project tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">{{ $projects->links() }}</div>
    </div>
@stop
