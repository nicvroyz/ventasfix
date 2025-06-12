@extends('layouts.app')

@section('title', 'Clientes - VentasFix')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Lista de Clientes</h5>
            <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Nuevo Cliente
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>RUT</th>
                            <th>Razón Social</th>
                            <th>Rubro</th>
                            <th>Contacto</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->rut_empresa }}</td>
                                <td>{{ $cliente->razon_social }}</td>
                                <td>{{ $cliente->rubro }}</td>
                                <td>
                                    {{ $cliente->nombre_contacto }}<br>
                                    <small class="text-muted">{{ $cliente->email_contacto }}</small>
                                </td>
                                <td>{{ $cliente->telefono }}</td>
                                <td>
                                    <div class="d-inline-block">
                                        <a href="{{ route('clientes.show', $cliente) }}" 
                                            class="btn btn-sm btn-icon btn-info">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="{{ route('clientes.edit', $cliente) }}" 
                                            class="btn btn-sm btn-icon btn-warning">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <form action="{{ route('clientes.destroy', $cliente) }}" 
                                            method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-icon btn-danger delete-btn">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No hay clientes registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $clientes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.delete-btn').click(function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush 