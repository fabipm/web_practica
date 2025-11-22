@extends('layouts.app')

@section('title', 'Ver Atención')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-eye"></i> Detalle de Atención #{{ $atencion->id_atencion }}</h1>
    <div>
        <a href="{{ route('atenciones.edit', $atencion->id_atencion) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="{{ route('atenciones.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Información General</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong><i class="fas fa-chalkboard-teacher"></i> Docente:</strong><br>
                        {{ $atencion->docente->nombre_completo }}
                    </div>
                    <div class="col-md-6">
                        <strong><i class="fas fa-user-graduate"></i> Estudiante:</strong><br>
                        {{ $atencion->estudiante->nombre_completo }}<br>
                        <small class="text-muted">Código: {{ $atencion->estudiante->codigo }}</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong><i class="fas fa-tag"></i> Tema:</strong><br>
                        <span class="badge bg-info">{{ $atencion->tema->nombre_tema }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong><i class="fas fa-calendar"></i> Semestre:</strong><br>
                        {{ $atencion->semestre }}
                    </div>
                    <div class="col-md-4">
                        <strong><i class="fas fa-clock"></i> Fecha y Hora:</strong><br>
                        {{ $atencion->fecha_atencion->format('d/m/Y') }}<br>
                        <small>{{ substr($atencion->hora_atencion, 0, 5) }}</small>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <strong><i class="fas fa-question-circle"></i> Consulta del Estudiante:</strong>
                    <p class="mt-2 p-3 bg-light rounded">{{ $atencion->consulta_estudiante }}</p>
                </div>

                <div class="mb-3">
                    <strong><i class="fas fa-clipboard"></i> Descripción de la Atención:</strong>
                    <p class="mt-2 p-3 bg-light rounded">{{ $atencion->descripcion_atencion }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Evidencia -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-paperclip"></i> Evidencia</h5>
            </div>
            <div class="card-body text-center">
                @if($atencion->evidencia)
                    <i class="fas fa-file fa-4x text-primary mb-3"></i>
                    <p><strong>{{ $atencion->evidencia }}</strong></p>
                    <a href="{{ $atencion->evidencia_url }}" target="_blank" class="btn btn-primary w-100">
                        <i class="fas fa-download"></i> Ver/Descargar
                    </a>
                @else
                    <i class="fas fa-times-circle fa-4x text-muted mb-3"></i>
                    <p class="text-muted">No se adjuntó evidencia</p>
                @endif
            </div>
        </div>

        <!-- Acciones -->
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-cogs"></i> Acciones</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('atenciones.edit', $atencion->id_atencion) }}" class="btn btn-warning w-100 mb-2">
                    <i class="fas fa-edit"></i> Editar Atención
                </a>
                <form method="POST" action="{{ route('atenciones.destroy', $atencion->id_atencion) }}" 
                      onsubmit="return confirm('¿Está seguro de eliminar esta atención?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash"></i> Eliminar Atención
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
