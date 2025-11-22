@extends('layouts.app')

@section('title', 'Reporte por Docente')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-chalkboard-teacher"></i> Reporte de Atenciones por Docente</h1>
    <a href="{{ route('reportes.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($reportes->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-success">
                        <tr>
                            <th width="50">#</th>
                            <th>Docente</th>
                            <th>Correo Institucional</th>
                            <th class="text-end">Total de Atenciones</th>
                            <th width="200">Porcentaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalGeneral = $reportes->sum('atenciones_count');
                        @endphp
                        @foreach($reportes as $index => $docente)
                            @php
                                $porcentaje = $totalGeneral > 0 ? ($docente->atenciones_count / $totalGeneral) * 100 : 0;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $docente->nombre_completo }}</strong></td>
                                <td>{{ $docente->correo }}</td>
                                <td class="text-end">
                                    <span class="badge bg-success fs-6">{{ $docente->atenciones_count }}</span>
                                </td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: {{ $porcentaje }}%"
                                             aria-valuenow="{{ $porcentaje }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                            {{ number_format($porcentaje, 1) }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr>
                            <th colspan="3" class="text-end">TOTAL GENERAL:</th>
                            <th class="text-end">
                                <span class="badge bg-dark fs-6">{{ $totalGeneral }}</span>
                            </th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Botón de impresión -->
            <div class="text-center mt-4">
                <button onclick="window.print()" class="btn btn-success">
                    <i class="fas fa-print"></i> Imprimir Reporte
                </button>
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No hay datos disponibles para mostrar.
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        .sidebar, .navbar, .btn, .card-footer {
            display: none !important;
        }
        .col-md-9 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
    }
</style>
@endpush
