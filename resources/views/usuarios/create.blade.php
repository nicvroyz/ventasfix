@extends('layouts.app')

@section('title', 'Nuevo Usuario - VentasFix')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crear Usuario</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('usuarios.store') }}" id="createUserForm">
                        @csrf

                        <div class="mb-3">
                            <label for="rut" class="form-label">RUT</label>
                            <input type="text" class="form-control @error('rut') is-invalid @enderror" id="rut" name="rut" value="{{ old('rut') }}" placeholder="XX.XXX.XXX-X" required>
                            <div class="invalid-feedback" id="rutFeedback"></div>
                            @error('rut')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
                            @error('apellido')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            <div class="invalid-feedback" id="emailFeedback"></div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="mb-0">
                            <button type="submit" class="btn btn-primary">
                                Crear Usuario
                            </button>
                            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function validarRut(rut) {
        // Eliminar puntos y guión
        rut = rut.replace(/[.-]/g, '');
        
        // Separar número y dígito verificador
        var numero = rut.slice(0, -1);
        var dv = rut.slice(-1).toUpperCase();
        
        // Calcular dígito verificador
        var i = 2;
        var suma = 0;
        for (var j = numero.length - 1; j >= 0; j--) {
            if (i == 8) {
                i = 2;
            }
            suma += numero.charAt(j) * i;
            i++;
        }
        
        var dvr = 11 - (suma % 11);
        
        if (dvr == 11) {
            dvr = 0;
        } else if (dvr == 10) {
            dvr = 'K';
        }
        
        return dvr.toString() === dv;
    }

    function formatearRut(rut) {
        // Eliminar todo excepto números y K
        rut = rut.replace(/[^0-9kK]/g, '');
        
        // Si está vacío, retornar vacío
        if (rut.length === 0) return '';
        
        // Separar número y dígito verificador
        var numero = rut.slice(0, -1);
        var dv = rut.slice(-1).toUpperCase();
        
        // Formatear número con puntos
        var rutFormateado = '';
        for (var i = numero.length; i > 0; i -= 3) {
            if (i > 3) {
                rutFormateado = '.' + numero.slice(i - 3, i) + rutFormateado;
            } else {
                rutFormateado = numero.slice(0, i) + rutFormateado;
            }
        }
        
        // Agregar guión y dígito verificador
        return rutFormateado + '-' + dv;
    }

    $('#rut').on('input', function() {
        var rut = $(this).val();
        var rutFormateado = formatearRut(rut);
        $(this).val(rutFormateado);
        
        if (rutFormateado.length > 0) {
            if (validarRut(rutFormateado)) {
                $(this).removeClass('is-invalid').addClass('is-valid');
                $('#rutFeedback').text('');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
                $('#rutFeedback').text('El RUT ingresado no es válido');
            }
        } else {
            $(this).removeClass('is-valid is-invalid');
            $('#rutFeedback').text('');
        }
    });

    // Validación del correo electrónico
    $('#email').on('input', function() {
        var email = $(this).val();
        var emailRegex = /^[a-zA-Z0-9._-]+@ventasfix\.cl$/;
        
        if (email.length > 0) {
            if (emailRegex.test(email)) {
                $(this).removeClass('is-invalid').addClass('is-valid');
                $('#emailFeedback').text('');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
                $('#emailFeedback').text('El correo debe ser del dominio @ventasfix.cl');
            }
        } else {
            $(this).removeClass('is-valid is-invalid');
            $('#emailFeedback').text('');
        }
    });

    $('#createUserForm').on('submit', function(e) {
        var rut = $('#rut').val();
        var email = $('#email').val();
        var emailRegex = /^[a-zA-Z0-9._-]+@ventasfix\.cl$/;
        
        if (!validarRut(rut)) {
            e.preventDefault();
            $('#rut').addClass('is-invalid');
            $('#rutFeedback').text('El RUT ingresado no es válido');
        }
        
        if (!emailRegex.test(email)) {
            e.preventDefault();
            $('#email').addClass('is-invalid');
            $('#emailFeedback').text('El correo debe ser del dominio @ventasfix.cl');
        }
    });
});
</script>
@endpush 