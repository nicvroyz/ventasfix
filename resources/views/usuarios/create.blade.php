@extends('layouts.app')

@section('title', 'Nuevo Usuario - VentasFix')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Crear Nuevo Usuario</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                @include('usuarios.form')
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Guardar Usuario
                    </button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                        <i class="bx bx-x"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 