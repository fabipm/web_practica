@extends('layouts.app')

@section('title', 'Registrar Atención')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-plus-circle"></i> Registrar Nueva Atención</h1>
    <a href="{{ route('atenciones.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('atenciones.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- Docente -->
                <div class="col-md-6 mb-3">
                    <label for="id_docente" class="form-label">Docente <span class="text-danger">*</span></label>
                    <select class="form-select @error('id_docente') is-invalid @enderror" 
                            id="id_docente" name="id_docente" required>
                        <option value="">Seleccione un docente</option>
                        @foreach($docentes as $docente)
                            <option value="{{ $docente->id_docente }}" 
                                {{ old('id_docente') == $docente->id_docente ? 'selected' : '' }}>
                                {{ $docente->nombre_completo }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_docente')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Estudiante -->
                <div class="col-md-6 mb-3">
                    <label for="id_estudiante" class="form-label">Estudiante <span class="text-danger">*</span></label>
                    <select class="form-select @error('id_estudiante') is-invalid @enderror" 
                            id="id_estudiante" name="id_estudiante" required>
                        <option value="">Seleccione un estudiante</option>
                        @foreach($estudiantes as $estudiante)
                            <option value="{{ $estudiante->id_estudiante }}" 
                                {{ old('id_estudiante') == $estudiante->id_estudiante ? 'selected' : '' }}>
                                {{ $estudiante->estudiante_con_codigo }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_estudiante')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tema -->
                <div class="col-md-6 mb-3">
                    <label for="id_tema" class="form-label">Tema <span class="text-danger">*</span></label>
                    <select class="form-select @error('id_tema') is-invalid @enderror" 
                            id="id_tema" name="id_tema" required>
                        <option value="">Seleccione un tema</option>
                        @foreach($temas as $tema)
                            <option value="{{ $tema->id_tema }}" 
                                {{ old('id_tema') == $tema->id_tema ? 'selected' : '' }}>
                                {{ $tema->nombre_tema }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_tema')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Semestre -->
                <div class="col-md-6 mb-3">
                    <label for="semestre" class="form-label">Semestre <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('semestre') is-invalid @enderror" 
                           id="semestre" 
                           name="semestre" 
                           value="{{ old('semestre') }}" 
                           placeholder="Ej: 2024-I" 
                           required>
                    @error('semestre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Fecha de atención -->
                <div class="col-md-6 mb-3">
                    <label for="fecha_atencion" class="form-label">Fecha de Atención <span class="text-danger">*</span></label>
                    <input type="date" 
                           class="form-control @error('fecha_atencion') is-invalid @enderror" 
                           id="fecha_atencion" 
                           name="fecha_atencion" 
                           value="{{ old('fecha_atencion') }}" 
                           required>
                    @error('fecha_atencion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Hora de atención -->
                <div class="col-md-6 mb-3">
                    <label for="hora_atencion" class="form-label">Hora de Atención <span class="text-danger">*</span></label>
                    <input type="time" 
                           class="form-control @error('hora_atencion') is-invalid @enderror" 
                           id="hora_atencion" 
                           name="hora_atencion" 
                           value="{{ old('hora_atencion') }}" 
                           required>
                    @error('hora_atencion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Consulta del estudiante -->
                <div class="col-12 mb-3">
                    <label for="consulta_estudiante" class="form-label">Consulta del Estudiante <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('consulta_estudiante') is-invalid @enderror" 
                              id="consulta_estudiante" 
                              name="consulta_estudiante" 
                              rows="3" 
                              required>{{ old('consulta_estudiante') }}</textarea>
                    @error('consulta_estudiante')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Descripción de la atención -->
                <div class="col-12 mb-3">
                    <label for="descripcion_atencion" class="form-label">Descripción de la Atención <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('descripcion_atencion') is-invalid @enderror" 
                              id="descripcion_atencion" 
                              name="descripcion_atencion" 
                              rows="3" 
                              required>{{ old('descripcion_atencion') }}</textarea>
                    @error('descripcion_atencion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Evidencia -->
                <div class="col-12 mb-3">
                    <label for="evidencia" class="form-label">Evidencia (Opcional)</label>
                    <input type="file" 
                           class="form-control @error('evidencia') is-invalid @enderror" 
                           id="evidencia" 
                           name="evidencia"
                           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                    <small class="form-text text-muted">Formatos permitidos: PDF, Imágenes, Word. Máximo 10 MB.</small>
                    @error('evidencia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('atenciones.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Atención
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
