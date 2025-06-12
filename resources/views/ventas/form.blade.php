@props(['venta' => null, 'clientes', 'productos'])

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select class="form-select @error('cliente_id') is-invalid @enderror" 
                id="cliente_id" name="cliente_id" required>
                <option value="">Seleccione un cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" 
                        {{ old('cliente_id', $venta?->cliente_id) == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->razon_social }} ({{ $cliente->rut_empresa }})
                    </option>
                @endforeach
            </select>
            @error('cliente_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Productos</h5>
            </div>
            <div class="card-body">
                <div id="productos-container">
                    @if($venta)
                        @foreach($venta->detalles as $index => $detalle)
                            <div class="row mb-3 producto-item">
                                <div class="col-md-4">
                                    <select class="form-select producto-select" 
                                        name="productos[{{ $index }}][producto_id]" required>
                                        <option value="">Seleccione un producto</option>
                                        @foreach($productos as $producto)
                                            <option value="{{ $producto->id }}" 
                                                data-precio="{{ $producto->precio_venta }}"
                                                {{ $detalle->producto_id == $producto->id ? 'selected' : '' }}>
                                                {{ $producto->nombre }} (Stock: {{ $producto->stock_actual }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control cantidad-input" 
                                        name="productos[{{ $index }}][cantidad]" 
                                        value="{{ $detalle->cantidad }}" min="1" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control precio-input" 
                                        value="{{ $detalle->precio_unitario }}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control subtotal-input" 
                                        value="{{ $detalle->subtotal }}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-remove-producto">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                
                <button type="button" class="btn btn-success" id="btn-add-producto">
                    <i class="bx bx-plus"></i> Agregar Producto
                </button>
                
                <div class="row mt-3">
                    <div class="col-md-8 text-end">
                        <h5>Total:</h5>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="total-venta" 
                            value="{{ $venta?->total ?? 0 }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                id="observaciones" name="observaciones" rows="3">{{ old('observaciones', $venta?->observaciones) }}</textarea>
            @error('observaciones')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('productos-container');
    const btnAdd = document.getElementById('btn-add-producto');
    const productos = @json($productos);
    
    function updateSubtotal(row) {
        const cantidad = parseInt(row.querySelector('.cantidad-input').value) || 0;
        const precio = parseFloat(row.querySelector('.precio-input').value) || 0;
        const subtotal = cantidad * precio;
        row.querySelector('.subtotal-input').value = subtotal.toLocaleString('es-CL');
        updateTotal();
    }
    
    function updateTotal() {
        const subtotales = Array.from(document.querySelectorAll('.subtotal-input'))
            .map(input => parseFloat(input.value.replace(/[^0-9.-]+/g, '')) || 0);
        const total = subtotales.reduce((a, b) => a + b, 0);
        document.getElementById('total-venta').value = total.toLocaleString('es-CL');
    }
    
    function createProductoRow(index) {
        const row = document.createElement('div');
        row.className = 'row mb-3 producto-item';
        row.innerHTML = `
            <div class="col-md-4">
                <select class="form-select producto-select" name="productos[${index}][producto_id]" required>
                    <option value="">Seleccione un producto</option>
                    ${productos.map(p => `
                        <option value="${p.id}" data-precio="${p.precio_venta}">
                            ${p.nombre} (Stock: ${p.stock_actual})
                        </option>
                    `).join('')}
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control cantidad-input" 
                    name="productos[${index}][cantidad]" value="1" min="1" required>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control precio-input" readonly>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control subtotal-input" readonly>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-remove-producto">
                    <i class="bx bx-trash"></i>
                </button>
            </div>
        `;
        
        row.querySelector('.producto-select').addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const precio = option.dataset.precio || 0;
            row.querySelector('.precio-input').value = precio.toLocaleString('es-CL');
            updateSubtotal(row);
        });
        
        row.querySelector('.cantidad-input').addEventListener('input', function() {
            updateSubtotal(row);
        });
        
        row.querySelector('.btn-remove-producto').addEventListener('click', function() {
            row.remove();
            updateTotal();
        });
        
        return row;
    }
    
    btnAdd.addEventListener('click', function() {
        const index = container.children.length;
        container.appendChild(createProductoRow(index));
    });
    
    // Inicializar eventos para productos existentes
    document.querySelectorAll('.producto-item').forEach(row => {
        row.querySelector('.producto-select').addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const precio = option.dataset.precio || 0;
            row.querySelector('.precio-input').value = precio.toLocaleString('es-CL');
            updateSubtotal(row);
        });
        
        row.querySelector('.cantidad-input').addEventListener('input', function() {
            updateSubtotal(row);
        });
        
        row.querySelector('.btn-remove-producto').addEventListener('click', function() {
            row.remove();
            updateTotal();
        });
    });
    
    // Agregar primer producto si no hay ninguno
    if (container.children.length === 0) {
        btnAdd.click();
    }
});
</script>
@endpush 