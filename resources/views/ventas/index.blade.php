@extends('layouts.app')

@section('title', 'Ventas - VentasFix')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Lista de Ventas</h5>
            <a href="{{ route('ventas.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Nueva Venta
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventas as $venta)
                            <tr>
                                <td>{{ $venta->formatted_created_at }}</td>
                                <td>
                                    {{ $venta->cliente->razon_social }}<br>
                                    <small class="text-muted">{{ $venta->cliente->rut_empresa }}</small>
                                </td>
                                <td>{{ $venta->formatted_total }}</td>
                                <td>
                                    <span class="badge bg-label-{{ $venta->estado_badge }}">
                                        {{ $venta->estado_text }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-inline-block">
                                        <a href="{{ route('ventas.show', $venta) }}" 
                                            class="btn btn-sm btn-icon btn-info">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        @if($venta->estado === 'pending')
                                            <a href="{{ route('ventas.edit', $venta) }}" 
                                                class="btn btn-sm btn-icon btn-warning">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <form action="{{ route('ventas.destroy', $venta) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon btn-danger"
                                                    onclick="return confirm('¿Está seguro de eliminar esta venta?')">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay ventas registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $ventas->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 