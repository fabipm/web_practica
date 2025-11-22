@extends('layouts.app')

@section('title', 'Registro - Sistema de Consejería UPT')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center py-4">
                    <h3><i class="fas fa-user-plus"></i> Registro de Docente</h3>
                    <p class="mb-0 text-muted">Sistema de Consejería UPT</p>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="nombres" class="form-label">Nombre(s) <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nombres') is-invalid @enderror" 
                                   id="nombres" 
                                   name="nombres" 
                                   value="{{ old('nombres') }}" 
                                   placeholder="Ej: Juan Carlos"
                                   required 
                                   autofocus>
                            @error('nombres')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('apellidos') is-invalid @enderror" 
                                   id="apellidos" 
                                   name="apellidos" 
                                   value="{{ old('apellidos') }}" 
                                   placeholder="Ej: García Pérez"
                                   required>
                            @error('apellidos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Institucional <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('correo') is-invalid @enderror" 
                                   id="correo" 
                                   name="correo" 
                                   value="{{ old('correo') }}" 
                                   placeholder="correo@upt.pe" 
                                   required>
                            @error('correo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Solo se permiten correos @upt.pe o @virtual.upt.pe
                            </small>
                        </div>

                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i> <strong>Nota:</strong> El acceso al sistema es mediante correo institucional sin contraseña.
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check-circle"></i> Registrarse
                            </button>
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Volver al Login
                            </a>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center text-muted">
                    <small>Universidad Privada de Tacna - Sistema de Consejería</small>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Validación en tiempo real del dominio del correo
    document.getElementById('correo').addEventListener('blur', function() {
        const correo = this.value;
        if (correo && !correo.endsWith('@upt.pe') && !correo.endsWith('@virtual.upt.pe')) {
            this.classList.add('is-invalid');
            if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('invalid-feedback')) {
                const feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                feedback.textContent = 'El correo debe pertenecer al dominio @upt.pe o @virtual.upt.pe';
                this.parentNode.insertBefore(feedback, this.nextSibling.nextSibling);
            }
        } else {
            this.classList.remove('is-invalid');
        }
    });
</script>
@endsection
@endsection
