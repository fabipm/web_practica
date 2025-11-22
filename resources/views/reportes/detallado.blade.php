@extends('layouts.app')

@section('title', 'Reporte Detallado')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-filter"></i> Reporte Detallado con Filtros</h1>
    <a href="{{ route('reportes.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-header">
        <h5><i class="fas fa-sliders-h"></i> Filtros de Búsqueda</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('reportes.detallado') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="semestre" class="form-label">Semestre</label>
                    <select class="form-select" id="semestre" name="semestre">
                        <option value="">Todos</option>
                        @foreach($semestres as $sem)
                            <option value="{{ $sem }}" {{ request('semestre') == $sem ? 'selected' : '' }}>
                                {{ $sem }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="id_docente" class="form-label">Docente</label>
                    <select class="form-select" id="id_docente" name="id_docente">
                        <option value="">Todos</option>
                        @foreach($docentes as $docente)
                            <option value="{{ $docente->id_docente }}" 
                                {{ request('id_docente') == $docente->id_docente ? 'selected' : '' }}>
                                {{ $docente->nombre_completo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="id_tema" class="form-label">Tema</label>
                    <select class="form-select" id="id_tema" name="id_tema">
                        <option value="">Todos</option>
                        @foreach($temas as $tema)
                            <option value="{{ $tema->id_tema }}" 
                                {{ request('id_tema') == $tema->id_tema ? 'selected' : '' }}>
                                {{ $tema->nombre_tema }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                           value="{{ request('fecha_inicio') }}">
                </div>

                <div class="col-md-3">
                    <label for="fecha_fin" class="form-label">Fecha Fin</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
                           value="{{ request('fecha_fin') }}">
                </div>

                <div class="col-md-9 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="{{ route('reportes.detallado') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Limpiar Filtros
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Resultados -->
<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-list"></i> Resultados: {{ $atenciones->count() }} atenciones encontradas</h5>
    </div>
    <div class="card-body">
        @if($atenciones->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estudiante</th>
                            <th>Docente</th>
                            <th>Tema</th>
                            <th>Semestre</th>
                            <th>Consulta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($atenciones as $atencion)
                            <tr>
                                <td>{{ $atencion->id_atencion }}</td>
                                <td>{{ $atencion->fecha_atencion->format('d/m/Y') }}</td>
                                <td>{{ substr($atencion->hora_atencion, 0, 5) }}</td>
                                <td>{{ $atencion->estudiante->nombre_completo }}</td>
                                <td>{{ $atencion->docente->nombre_completo }}</td>
                                <td><span class="badge bg-info">{{ $atencion->tema->nombre_tema }}</span></td>
                                <td>{{ $atencion->semestre }}</td>
                                <td>{{ Str::limit($atencion->consulta_estudiante, 50) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Resumen estadístico -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="alert alert-success">
                        <h5><i class="fas fa-chart-pie"></i> Resumen Estadístico</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Total de Atenciones:</strong> {{ $atenciones->count() }}
                            </div>
                            <div class="col-md-4">
                                <strong>Docentes Involucrados:</strong> {{ $atenciones->pluck('id_docente')->unique()->count() }}
                            </div>
                            <div class="col-md-4">
                                <strong>Estudiantes Atendidos:</strong> {{ $atenciones->pluck('id_estudiante')->unique()->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón de impresión -->
            <div class="text-center mt-3">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> Imprimir Reporte
                </button>
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No se encontraron atenciones con los filtros seleccionados.
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        .sidebar, .navbar, .btn, .card-footer, .card-header:first-child {
            display: none !important;
        }
        .col-md-9 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
    }
</style>
@endpush
