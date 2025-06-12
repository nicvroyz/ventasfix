@extends('layouts.app')

@section('title', 'Productos - VentasFix')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Productos /</span> Lista de Productos
    </h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Productos del Sistema</h5>
            <a href="{{ route('productos.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Nuevo Producto
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio Neto</th>
                        <th>Precio Venta</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->sku }}</td>
                        <td>
                            @if($producto->imagen)
                                <img src="{{ Storage::url($producto->imagen) }}" alt="{{ $producto->nombre }}" 
                                    class="rounded" style="max-height: 50px;">
                            @else
                                <span class="badge bg-label-secondary">Sin imagen</span>
                            @endif
                        </td>
                        <td>{{ $producto->nombre }}</td>
                        <td>${{ number_format($producto->precio_neto, 2) }}</td>
                        <td>${{ number_format($producto->precio_venta, 2) }}</td>
                        <td>{{ $producto->stock_actual }}</td>
                        <td>
                            @if($producto->stockBajo())
                                <span class="badge bg-label-danger">Stock Bajo</span>
                            @elseif($producto->stockAlto())
                                <span class="badge bg-label-success">Stock Alto</span>
                            @else
                                <span class="badge bg-label-primary">Normal</span>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('productos.show', $producto) }}">
                                        <i class="bx bx-show-alt me-1"></i> Ver
                                    </a>
                                    <a class="dropdown-item" href="{{ route('productos.edit', $producto) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Editar
                                    </a>
                                    <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item" onclick="return confirm('¿Está seguro de eliminar este producto?')">
                                            <i class="bx bx-trash me-1"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $productos->links() }}
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</div>
@endsection 