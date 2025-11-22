<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DocentePasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Actualizar contraseñas para todos los docentes existentes
        // Contraseña por defecto: "password123"
        
        $docentes = DB::table('docentes')->get();
        
        foreach ($docentes as $docente) {
            DB::table('docentes')
                ->where('id_docente', $docente->id_docente)
                ->update([
                    'password' => Hash::make('password123')
                ]);
        }
        
        $this->command->info('Contraseñas asignadas exitosamente.');
        $this->command->info('Contraseña por defecto: password123');
    }
}
