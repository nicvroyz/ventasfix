<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('rut_empresa')->unique();
            $table->string('rubro');
            $table->string('razon_social');
            $table->string('telefono');
            $table->string('direccion');
            $table->string('nombre_contacto');
            $table->string('email_contacto');
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
}; 