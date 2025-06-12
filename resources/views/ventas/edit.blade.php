@extends('layouts.app')

@section('title', 'Editar Venta - VentasFix')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Editar Venta</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('ventas.update', $venta) }}" method="POST">
                @csrf
                @method('PUT')
                <x-ventas.form :venta="$venta" :clientes="$clientes" :productos="$productos" />
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Actualizar Venta
                    </button>
                    <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
                        <i class="bx bx-x"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 