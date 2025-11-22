<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Atencion extends Model
{
    use HasFactory;

    protected $table = 'atenciones';
    protected $primaryKey = 'id_atencion';
    public $timestamps = false;

    protected $fillable = [
        'id_docente',
        'id_estudiante',
        'id_tema',
        'semestre',
        'fecha_atencion',
        'hora_atencion',
        'consulta_estudiante',
        'descripcion_atencion',
        'evidencia',
    ];

    protected $casts = [
        'fecha_atencion' => 'date',
    ];

    /**
     * Relación con docente
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente', 'id_docente');
    }

    /**
     * Relación con estudiante
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante', 'id_estudiante');
    }

    /**
     * Relación con tema
     */
    public function tema()
    {
        return $this->belongsTo(Tema::class, 'id_tema', 'id_tema');
    }

    /**
     * Obtener URL de evidencia
     */
    public function getEvidenciaUrlAttribute()
    {
        if ($this->evidencia) {
            return Storage::url('evidencias/' . $this->evidencia);
        }
        return null;
    }

    /**
     * Verificar si tiene evidencia
     */
    public function hasEvidencia()
    {
        return !empty($this->evidencia) && Storage::exists('public/evidencias/' . $this->evidencia);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id_atencion';
    }
}
