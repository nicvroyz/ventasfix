@extends('layouts.app')

@section('title', 'Productos - VentasFix')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Productos /</span> Lista de Productos
    </h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Productos</h5>
            <a href="{{ route('productos.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Nuevo Producto
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio Neto</th>
                            <th>Stock Actual</th>
                            <th>Stock Mínimo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                            <tr>
                                <td>{{ $producto->id }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>${{ number_format($producto->precio_neto, 2) }}</td>
                                <td>{{ $producto->stock_actual }}</td>
                                <td>{{ $producto->stock_minimo }}</td>
                                <td>
                                    @if($producto->stock_actual <= $producto->stock_bajo)
                                        <span class="badge bg-danger">Stock Bajo</span>
                                    @elseif($producto->stock_actual >= $producto->stock_alto)
                                        <span class="badge bg-success">Stock Alto</span>
                                    @else
                                        <span class="badge bg-warning">Stock Normal</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('productos.show', $producto) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver detalles">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="{{ route('productos.edit', $producto) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <form action="{{ route('productos.destroy', $producto) }}" 
                                              method="POST" 
                                              id="delete-form-{{ $producto->id }}" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Eliminar"
                                                    onclick="confirmDelete('delete-form-{{ $producto->id }}')">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No hay productos registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $productos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 