@extends('layouts.app')

@section('title', 'Reportes')

@section('content')
<div class="mb-4">
    <h1><i class="fas fa-chart-bar"></i> Reportes y Estadísticas</h1>
    <p class="text-muted">Seleccione el tipo de reporte que desea generar</p>
</div>

<div class="row">
    <!-- Reporte por Semestre -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-calendar-alt fa-4x text-primary mb-3"></i>
                <h3>Atenciones por Semestre</h3>
                <p class="text-muted">Visualice el número total de atenciones agrupadas por semestre académico</p>
                <a href="{{ route('reportes.semestre') }}" class="btn btn-primary">
                    <i class="fas fa-eye"></i> Ver Reporte
                </a>
            </div>
        </div>
    </div>

    <!-- Reporte por Docente -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-chalkboard-teacher fa-4x text-success mb-3"></i>
                <h3>Atenciones por Docente</h3>
                <p class="text-muted">Consulte cuántas atenciones ha realizado cada docente consejero</p>
                <a href="{{ route('reportes.docente') }}" class="btn btn-success">
                    <i class="fas fa-eye"></i> Ver Reporte
                </a>
            </div>
        </div>
    </div>

    <!-- Reporte por Tema -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-tags fa-4x text-info mb-3"></i>
                <h3>Atenciones por Tema</h3>
                <p class="text-muted">Identifique los temas más consultados por los estudiantes</p>
                <a href="{{ route('reportes.tema') }}" class="btn btn-info">
                    <i class="fas fa-eye"></i> Ver Reporte
                </a>
            </div>
        </div>
    </div>

    <!-- Reporte Detallado -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-filter fa-4x text-warning mb-3"></i>
                <h3>Reporte Detallado</h3>
                <p class="text-muted">Genere reportes personalizados con múltiples filtros y criterios</p>
                <a href="{{ route('reportes.detallado') }}" class="btn btn-warning">
                    <i class="fas fa-eye"></i> Ver Reporte
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
