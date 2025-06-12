<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RutChileno implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Eliminar puntos y guión
        $rut = str_replace(['.', '-'], '', $value);
        
        // Separar número y dígito verificador
        $numero = substr($rut, 0, -1);
        $dv = strtoupper(substr($rut, -1));
        
        // Calcular dígito verificador
        $i = 2;
        $suma = 0;
        foreach (array_reverse(str_split($numero)) as $v) {
            if ($i == 8) {
                $i = 2;
            }
            $suma += $v * $i;
            $i++;
        }
        
        $dvr = 11 - ($suma % 11);
        
        if ($dvr == 11) {
            $dvr = 0;
        } elseif ($dvr == 10) {
            $dvr = 'K';
        }
        
        if ($dvr != strtoupper($dv)) {
            $fail('El RUT ingresado no es válido.');
        }
    }
} 