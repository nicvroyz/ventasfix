@extends('layouts.app')

@section('title', 'Detalles de la Venta - VentasFix')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Información de la Venta</h5>
                    <div>
                        @if($venta->estado === 'pending')
                            <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-warning btn-sm">
                                <i class="bx bx-edit"></i> Editar
                            </a>
                        @endif
                        <a href="{{ route('ventas.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bx bx-arrow-back"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cliente</label>
                        <p>
                            {{ $venta->cliente->razon_social }}<br>
                            <small class="text-muted">{{ $venta->cliente->rut_empresa }}</small>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Fecha</label>
                        <p>{{ $venta->formatted_created_at }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Estado</label>
                        <p>
                            <span class="badge bg-label-{{ $venta->estado_badge }}">
                                {{ $venta->estado_text }}
                            </span>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Total</label>
                        <p>{{ $venta->formatted_total }}</p>
                    </div>
                    @if($venta->observaciones)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Observaciones</label>
                            <p>{{ $venta->observaciones }}</p>
                        </div>
                    @endif
                    
                    @if($venta->estado === 'pending')
                        <div class="mt-4">
                            <form action="{{ route('ventas.update-status', $venta) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="estado" value="completed">
                                <button type="submit" class="btn btn-success">
                                    <i class="bx bx-check"></i> Completar Venta
                                </button>
                            </form>
                            
                            <form action="{{ route('ventas.update-status', $venta) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="estado" value="cancelled">
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Está seguro de cancelar esta venta?')">
                                    <i class="bx bx-x"></i> Cancelar Venta
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Productos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unit.</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($venta->detalles as $detalle)
                                    <tr>
                                        <td>{{ $detalle->producto->nombre }}</td>
                                        <td>{{ $detalle->cantidad }}</td>
                                        <td>{{ $detalle->formatted_precio_unitario }}</td>
                                        <td>{{ $detalle->formatted_subtotal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th>{{ $venta->formatted_total }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 