<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';
    protected $primaryKey = 'id_docente';
    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
    ];

    /**
     * Relación con atenciones
     */
    public function atenciones()
    {
        return $this->hasMany(Atencion::class, 'id_docente', 'id_docente');
    }

    /**
     * Obtener nombre completo del docente
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    /**
     * Override para usar 'correo' como username en autenticación
     */
    public function getAuthIdentifierName()
    {
        return 'correo';
    }
}
