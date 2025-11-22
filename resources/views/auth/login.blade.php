@extends('layouts.app')

@section('title', 'Login - Sistema de Consejería UPT')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header text-center py-4">
                    <h3><i class="fas fa-graduation-cap"></i> Sistema de Consejería UPT</h3>
                </div>
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Institucional</label>
                            <input type="email" 
                                   class="form-control @error('correo') is-invalid @enderror" 
                                   id="correo" 
                                   name="correo" 
                                   value="{{ old('correo') }}" 
                                   placeholder="correo@upt.pe" 
                                   required 
                                   autofocus>
                            @error('correo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Debe usar un correo @upt.pe o @virtual.upt.pe
                            </small>
                        </div>



                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p class="mb-0">¿No tienes una cuenta?</p>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm mt-2">
                            <i class="fas fa-user-plus"></i> Registrarse
                        </a>
                    </div>
                </div>
                <div class="card-footer text-center text-muted">
                    <small>Universidad Privada de Tacna - Sistema de Consejería</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
