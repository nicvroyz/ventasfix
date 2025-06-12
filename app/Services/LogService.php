<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LogService
{
    /**
     * Registra una acción en el sistema
     */
    public static function log($accion, $modelo = null, $detalles = [])
    {
        $usuario = Auth::user();
        $logData = [
            'usuario_id' => $usuario ? $usuario->id : null,
            'usuario_email' => $usuario ? $usuario->email : null,
            'accion' => $accion,
            'modelo' => $modelo,
            'detalles' => $detalles,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ];

        Log::channel('actions')->info('Acción del sistema', $logData);
    }

    /**
     * Registra un error en el sistema
     */
    public static function error($mensaje, $excepcion = null, $contexto = [])
    {
        $usuario = Auth::user();
        $logData = [
            'usuario_id' => $usuario ? $usuario->id : null,
            'usuario_email' => $usuario ? $usuario->email : null,
            'mensaje' => $mensaje,
            'excepcion' => $excepcion ? [
                'mensaje' => $excepcion->getMessage(),
                'archivo' => $excepcion->getFile(),
                'linea' => $excepcion->getLine(),
                'trace' => $excepcion->getTraceAsString()
            ] : null,
            'contexto' => $contexto,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ];

        Log::channel('errors')->error('Error en el sistema', $logData);
    }
} 