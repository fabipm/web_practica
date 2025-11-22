<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    use HasFactory;

    protected $table = 'temas';
    protected $primaryKey = 'id_tema';
    public $timestamps = false;

    protected $fillable = [
        'nombre_tema',
    ];

    /**
     * Relación con atenciones
     */
    public function atenciones()
    {
        return $this->hasMany(Atencion::class, 'id_tema', 'id_tema');
    }
}
