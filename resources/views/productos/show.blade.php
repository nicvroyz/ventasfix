@extends('layouts.app')

@section('title', 'Detalles del Producto')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Detalles del Producto</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if($producto->imagen)
                                <div class="text-center mb-3">
                                    <img src="{{ Storage::url($producto->imagen) }}" 
                                         alt="{{ $producto->nombre }}" 
                                         class="img-fluid rounded"
                                         style="max-height: 300px; object-fit: contain;">
                                </div>
                            @else
                                <div class="bg-light rounded p-5 text-center mb-3">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                    <p class="mt-2 text-muted">Sin imagen</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title">{{ $producto->nombre }}</h5>
                            <p class="text-muted">SKU: {{ $producto->sku }}</p>
                            
                            <div class="mb-3">
                                <h6>Precios</h6>
                                <p class="mb-1">Precio Neto: ${{ number_format($producto->precio_neto, 2) }}</p>
                                <p class="mb-1">Precio de Venta: ${{ number_format($producto->precio_venta, 2) }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6>Stock</h6>
                                <p class="mb-1">Actual: {{ $producto->stock_actual }}</p>
                                <p class="mb-1">Mínimo: {{ $producto->stock_minimo }}</p>
                                <p class="mb-1">Bajo: {{ $producto->stock_bajo }}</p>
                                <p class="mb-1">Alto: {{ $producto->stock_alto }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6>Descripción Corta</h6>
                            <p>{{ $producto->descripcion_corta }}</p>
                            
                            <h6>Descripción Larga</h6>
                            <p>{{ $producto->descripcion_larga }}</p>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este producto?')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 