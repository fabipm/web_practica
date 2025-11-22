<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtencionRequest;
use App\Models\Atencion;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Tema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AtencionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Atencion::with(['docente', 'estudiante', 'tema']);

        // Filtros opcionales
        if ($request->filled('semestre')) {
            $query->where('semestre', $request->semestre);
        }

        if ($request->filled('id_docente')) {
            $query->where('id_docente', $request->id_docente);
        }

        if ($request->filled('id_tema')) {
            $query->where('id_tema', $request->id_tema);
        }

        $atenciones = $query->orderBy('fecha_atencion', 'desc')
                           ->orderBy('hora_atencion', 'desc')
                           ->paginate(15);

        $docentes = Docente::orderBy('apellidos')->get();
        $temas = Tema::all();

        return view('atenciones.index', compact('atenciones', 'docentes', 'temas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $docentes = Docente::orderBy('apellidos')->get();
        $estudiantes = Estudiante::orderBy('apellidos')->get();
        $temas = Tema::all();

        return view('atenciones.create', compact('docentes', 'estudiantes', 'temas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AtencionRequest $request)
    {
        $data = $request->validated();

        // Manejar subida de evidencia
        if ($request->hasFile('evidencia')) {
            $file = $request->file('evidencia');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/evidencias', $filename);
            $data['evidencia'] = $filename;
        }

        Atencion::create($data);

        return redirect()->route('atenciones.index')
                        ->with('success', 'Atención registrada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $atencion = Atencion::where('id_atencion', $id)->firstOrFail();
        $atencion->load(['docente', 'estudiante', 'tema']);
        return view('atenciones.show', compact('atencion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $atencion = Atencion::where('id_atencion', $id)->firstOrFail();
        $docentes = Docente::orderBy('apellidos')->get();
        $estudiantes = Estudiante::orderBy('apellidos')->get();
        $temas = Tema::all();

        return view('atenciones.edit', compact('atencion', 'docentes', 'estudiantes', 'temas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AtencionRequest $request, $id)
    {
        $atencion = Atencion::where('id_atencion', $id)->firstOrFail();
        $data = $request->validated();

        // Manejar nueva evidencia
        if ($request->hasFile('evidencia')) {
            // Eliminar evidencia anterior si existe
            if ($atencion->evidencia) {
                Storage::delete('public/evidencias/' . $atencion->evidencia);
            }

            $file = $request->file('evidencia');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/evidencias', $filename);
            $data['evidencia'] = $filename;
        }

        $atencion->update($data);

        return redirect()->route('atenciones.index')
                        ->with('success', 'Atención actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $atencion = Atencion::where('id_atencion', $id)->firstOrFail();
        
        // Eliminar evidencia si existe
        if ($atencion->evidencia) {
            Storage::delete('public/evidencias/' . $atencion->evidencia);
        }

        $atencion->delete();

        return redirect()->route('atenciones.index')
                        ->with('success', 'Atención eliminada correctamente');
    }
}
