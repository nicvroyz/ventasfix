@extends('layouts.app')

@section('title', 'Dashboard - VentasFix')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- Estadísticas -->
        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/users.png') }}" alt="Usuarios" class="rounded">
                                </div>
                            </div>
                            <span class="fw-medium d-block mb-1">Usuarios</span>
                            <h3 class="card-title mb-2">{{ $stats['usuarios'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/box.png') }}" alt="Productos" class="rounded">
                                </div>
                            </div>
                            <span class="fw-medium d-block mb-1">Productos</span>
                            <h3 class="card-title mb-2">{{ $stats['productos'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/store.png') }}" alt="Clientes" class="rounded">
                                </div>
                            </div>
                            <span class="fw-medium d-block mb-1">Clientes</span>
                            <h3 class="card-title mb-2">{{ $stats['clientes'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/warning.png') }}" alt="Stock Bajo" class="rounded">
                                </div>
                            </div>
                            <span class="fw-medium d-block mb-1">Stock Bajo</span>
                            <h3 class="card-title mb-2">{{ $stats['productos_bajo_stock'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Últimos Productos -->
        <div class="col-lg-4 col-md-4 order-2">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Últimos Productos</h5>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        @foreach($stats['ultimos_productos'] as $producto)
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="rounded">
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">{{ $producto->nombre }}</h6>
                                    <small class="text-muted">SKU: {{ $producto->sku }}</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-medium">Stock: {{ $producto->stock_actual }}</small>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Últimos Clientes -->
        <div class="col-lg-4 col-md-4 order-3">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Últimos Clientes</h5>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        @foreach($stats['ultimos_clientes'] as $cliente)
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    {{ substr($cliente->razon_social, 0, 1) }}
                                </span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">{{ $cliente->razon_social }}</h6>
                                    <small class="text-muted">{{ $cliente->rubro }}</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-medium">{{ $cliente->rut_empresa }}</small>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 