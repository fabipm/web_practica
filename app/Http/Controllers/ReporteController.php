<?php

namespace App\Http\Controllers;

use App\Models\Atencion;
use App\Models\Docente;
use App\Models\Tema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Página principal de reportes
     */
    public function index()
    {
        return view('reportes.index');
    }

    /**
     * Reporte por semestre
     */
    public function porSemestre()
    {
        $reportes = Atencion::select('semestre', DB::raw('COUNT(*) as total_atenciones'))
            ->groupBy('semestre')
            ->orderBy('semestre', 'desc')
            ->get();

        return view('reportes.por-semestre', compact('reportes'));
    }

    /**
     * Reporte por docente
     */
    public function porDocente()
    {
        $reportes = Docente::withCount('atenciones')
            ->orderBy('atenciones_count', 'desc')
            ->get();

        return view('reportes.por-docente', compact('reportes'));
    }

    /**
     * Reporte por tema
     */
    public function porTema()
    {
        $reportes = Tema::withCount('atenciones')
            ->orderBy('atenciones_count', 'desc')
            ->get();

        return view('reportes.por-tema', compact('reportes'));
    }

    /**
     * Reporte detallado con filtros
     */
    public function detallado(Request $request)
    {
        $query = Atencion::with(['docente', 'estudiante', 'tema']);

        // Aplicar filtros
        if ($request->filled('semestre')) {
            $query->where('semestre', $request->semestre);
        }

        if ($request->filled('id_docente')) {
            $query->where('id_docente', $request->id_docente);
        }

        if ($request->filled('id_tema')) {
            $query->where('id_tema', $request->id_tema);
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_atencion', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_atencion', '<=', $request->fecha_fin);
        }

        $atenciones = $query->orderBy('fecha_atencion', 'desc')->get();

        $docentes = Docente::orderBy('apellidos')->get();
        $temas = Tema::all();
        
        // Obtener semestres únicos
        $semestres = Atencion::select('semestre')
            ->distinct()
            ->orderBy('semestre', 'desc')
            ->pluck('semestre');

        return view('reportes.detallado', compact('atenciones', 'docentes', 'temas', 'semestres'));
    }
}
