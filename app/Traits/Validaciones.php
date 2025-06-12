<?php

namespace App\Traits;

trait Validaciones
{
    /**
     * Reglas de validación para el RUT chileno
     */
    protected function validarRut($rut)
    {
        if (!preg_match('/^[0-9]{1,2}\.[0-9]{3}\.[0-9]{3}-[0-9kK]{1}$/', $rut)) {
            return false;
        }

        $rut = str_replace(['.', '-'], '', $rut);
        $dv = substr($rut, -1);
        $numero = substr($rut, 0, strlen($rut) - 1);
        
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
        }
        if ($dvr == 10) {
            $dvr = 'K';
        }
        
        return strtoupper($dv) == strtoupper($dvr);
    }

    /**
     * Reglas de validación para contraseñas
     */
    protected function reglasPassword()
    {
        return [
            'required',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
        ];
    }

    /**
     * Reglas de validación para teléfonos
     */
    protected function reglasTelefono()
    {
        return [
            'required',
            'regex:/^(\+56|56)?[2-9][0-9]{8}$/'
        ];
    }

    /**
     * Reglas de validación para precios
     */
    protected function reglasPrecio()
    {
        return [
            'required',
            'numeric',
            'min:0',
            'max:999999999.99'
        ];
    }

    /**
     * Reglas de validación para stock
     */
    protected function reglasStock()
    {
        return [
            'required',
            'integer',
            'min:0',
            'max:999999'
        ];
    }
} 