@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
</div>

<!-- Tarjetas de estadísticas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Atenciones</h5>
                        <h2>{{ $totalAtenciones }}</h2>
                    </div>
                    <i class="fas fa-clipboard-list fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Docentes</h5>
                        <h2>{{ $totalDocentes }}</h2>
                    </div>
                    <i class="fas fa-chalkboard-teacher fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Estudiantes</h5>
                        <h2>{{ $totalEstudiantes }}</h2>
                    </div>
                    <i class="fas fa-user-graduate fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Temas</h5>
                        <h2>{{ $totalTemas }}</h2>
                    </div>
                    <i class="fas fa-tags fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Atenciones recientes -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-clock"></i> Atenciones Recientes
            </div>
            <div class="card-body">
                @if($atencionesRecientes->count() > 0)
                    <div class="list-group">
                        @foreach($atencionesRecientes as $atencion)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $atencion->estudiante->nombre_completo }}</h6>
                                    <small>{{ $atencion->fecha_atencion->format('d/m/Y') }}</small>
                                </div>
                                <p class="mb-1"><strong>Docente:</strong> {{ $atencion->docente->nombre_completo }}</p>
                                <small><strong>Tema:</strong> {{ $atencion->tema->nombre_tema }}</small>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No hay atenciones registradas.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Atenciones por semestre -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-calendar-alt"></i> Atenciones por Semestre
            </div>
            <div class="card-body">
                @if($atencionesPorSemestre->count() > 0)
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Semestre</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($atencionesPorSemestre as $semestre)
                                <tr>
                                    <td>{{ $semestre->semestre }}</td>
                                    <td class="text-end"><span class="badge bg-primary">{{ $semestre->total }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">No hay datos disponibles.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Temas más consultados -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-trophy"></i> Temas Más Consultados
            </div>
            <div class="card-body">
                @if($temasMasConsultados->count() > 0)
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tema</th>
                                <th class="text-end">Consultas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($temasMasConsultados as $tema)
                                <tr>
                                    <td>{{ $tema->nombre_tema }}</td>
                                    <td class="text-end"><span class="badge bg-success">{{ $tema->atenciones_count }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">No hay datos disponibles.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Docentes con más atenciones -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-star"></i> Docentes con Más Atenciones
            </div>
            <div class="card-body">
                @if($docentesMasAtenciones->count() > 0)
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Docente</th>
                                <th class="text-end">Atenciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($docentesMasAtenciones as $docente)
                                <tr>
                                    <td>{{ $docente->nombre_completo }}</td>
                                    <td class="text-end"><span class="badge bg-info">{{ $docente->atenciones_count }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">No hay datos disponibles.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="text-center">
    <a href="{{ route('atenciones.create') }}" class="btn btn-primary btn-lg">
        <i class="fas fa-plus"></i> Registrar Nueva Atención
    </a>
</div>
@endsection
