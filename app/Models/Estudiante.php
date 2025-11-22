<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';
    protected $primaryKey = 'id_estudiante';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'apellidos',
        'nombres',
    ];

    /**
     * Relación con atenciones
     */
    public function atenciones()
    {
        return $this->hasMany(Atencion::class, 'id_estudiante', 'id_estudiante');
    }

    /**
     * Obtener nombre completo del estudiante
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->apellidos}, {$this->nombres}";
    }

    /**
     * Obtener estudiante con código
     */
    public function getEstudianteConCodigoAttribute()
    {
        return "{$this->codigo} - {$this->apellidos}, {$this->nombres}";
    }
}
