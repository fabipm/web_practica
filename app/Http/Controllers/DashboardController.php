<?php

namespace App\Http\Controllers;

use App\Models\Atencion;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Tema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $totalAtenciones = Atencion::count();
        $totalDocentes = Docente::count();
        $totalEstudiantes = Estudiante::count();
        $totalTemas = Tema::count();

        // Atenciones recientes
        $atencionesRecientes = Atencion::with(['docente', 'estudiante', 'tema'])
            ->orderBy('fecha_atencion', 'desc')
            ->orderBy('hora_atencion', 'desc')
            ->limit(5)
            ->get();

        // Atenciones por semestre
        $atencionesPorSemestre = Atencion::selectRaw('semestre, COUNT(*) as total')
            ->groupBy('semestre')
            ->orderBy('semestre', 'desc')
            ->limit(5)
            ->get();

        // Temas más consultados
        $temasMasConsultados = Tema::withCount('atenciones')
            ->orderBy('atenciones_count', 'desc')
            ->limit(5)
            ->get();

        // Docentes con más atenciones
        $docentesMasAtenciones = Docente::withCount('atenciones')
            ->orderBy('atenciones_count', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalAtenciones',
            'totalDocentes',
            'totalEstudiantes',
            'totalTemas',
            'atencionesRecientes',
            'atencionesPorSemestre',
            'temasMasConsultados',
            'docentesMasAtenciones'
        ));
    }
}
