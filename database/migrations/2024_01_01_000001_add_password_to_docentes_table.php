<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Agregar campo password a docentes si no existe
        if (!Schema::hasColumn('docentes', 'password')) {
            Schema::table('docentes', function (Blueprint $table) {
                $table->string('password')->nullable()->after('correo');
                $table->rememberToken();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->dropColumn(['password', 'remember_token']);
        });
    }
};
