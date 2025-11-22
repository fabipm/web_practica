@extends('layouts.app')

@section('title', 'Atenciones')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-clipboard-list"></i> Gestión de Atenciones</h1>
    <a href="{{ route('atenciones.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nueva Atención
    </a>
</div>

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('atenciones.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="semestre" class="form-label">Semestre</label>
                    <input type="text" class="form-control" id="semestre" name="semestre" 
                           value="{{ request('semestre') }}" placeholder="Ej: 2024-I">
                </div>
                <div class="col-md-4">
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
                <div class="col-md-4">
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
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <a href="{{ route('atenciones.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Limpiar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tabla de atenciones -->
<div class="card">
    <div class="card-body">
        @if($atenciones->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha/Hora</th>
                            <th>Estudiante</th>
                            <th>Docente</th>
                            <th>Tema</th>
                            <th>Semestre</th>
                            <th>Evidencia</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($atenciones as $atencion)
                            <tr>
                                <td>{{ $atencion->id_atencion }}</td>
                                <td>
                                    {{ $atencion->fecha_atencion->format('d/m/Y') }}<br>
                                    <small class="text-muted">{{ substr($atencion->hora_atencion, 0, 5) }}</small>
                                </td>
                                <td>{{ $atencion->estudiante->nombre_completo }}</td>
                                <td>{{ $atencion->docente->nombre_completo }}</td>
                                <td><span class="badge bg-info">{{ $atencion->tema->nombre_tema }}</span></td>
                                <td>{{ $atencion->semestre }}</td>
                                <td class="text-center">
                                    @if($atencion->evidencia)
                                        <i class="fas fa-check-circle text-success"></i>
                                    @else
                                        <i class="fas fa-times-circle text-muted"></i>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('atenciones.show', $atencion->id_atencion) }}" 
                                           class="btn btn-sm btn-info" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('atenciones.edit', $atencion->id_atencion) }}" 
                                           class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('atenciones.destroy', $atencion->id_atencion) }}" 
                                              style="display: inline;"
                                              onsubmit="return confirm('¿Está seguro de eliminar esta atención?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-3">
                {{ $atenciones->links() }}
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No se encontraron atenciones registradas.
            </div>
        @endif
    </div>
</div>
@endsection
