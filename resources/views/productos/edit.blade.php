@extends('layouts.app')

@section('title', 'Editar Producto - VentasFix')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Productos /</span> Editar Producto
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Información del Producto</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('productos.update', $producto) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <x-productos.form :producto="$producto" />
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 