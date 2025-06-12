@extends('layouts.app')

@section('title', 'Detalles del Cliente - VentasFix')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Información del Cliente</h5>
                    <div>
                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning btn-sm">
                            <i class="bx bx-edit"></i> Editar
                        </a>
                        <a href="{{ route('clientes.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bx bx-arrow-back"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">RUT Empresa</label>
                        <p>{{ $cliente->rut_empresa }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Razón Social</label>
                        <p>{{ $cliente->razon_social }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Rubro</label>
                        <p>{{ $cliente->rubro }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dirección</label>
                        <p>{{ $cliente->direccion }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Teléfono</label>
                        <p>{{ $cliente->telefono }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Contacto</label>
                        <p>
                            {{ $cliente->nombre_contacto }}<br>
                            <small class="text-muted">{{ $cliente->email_contacto }}</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Últimas Ventas</h5>
                </div>
                <div class="card-body">
                    @if($cliente->ventas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cliente->ventas->take(5) as $venta)
                                        <tr>
                                            <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                                            <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge bg-label-{{ $venta->estado === 'completada' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($venta->estado) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('ventas.show', $venta) }}" 
                                                    class="btn btn-sm btn-icon btn-info">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center mb-0">No hay ventas registradas</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 