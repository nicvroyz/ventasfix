@props(['clientes', 'productos'])

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="cliente_id" class="form-label">Cliente</label>
        <select name="cliente_id" id="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
            <option value="">Seleccione un cliente</option>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                    {{ $cliente->razon_social }}
                </option>
            @endforeach
        </select>
        @error('cliente_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="fecha" class="form-label">Fecha</label>
        <input type="date" name="fecha" id="fecha" class="form-control @error('fecha') is-invalid @enderror" 
               value="{{ old('fecha', date('Y-m-d')) }}" required>
        @error('fecha')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered" id="productos-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="productos[0][producto_id]" class="form-select producto-select" required>
                                <option value="">Seleccione un producto</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}" 
                                            data-precio="{{ $producto->precio_venta }}" 
                                            data-stock="{{ $producto->stock_actual }}">
                                        {{ $producto->nombre }} - Stock: {{ $producto->stock_actual }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="productos[0][cantidad]" class="form-control cantidad-input" 
                                   min="1" value="1" required>
                        </td>
                        <td>
                            <input type="number" name="productos[0][precio]" class="form-control precio-input" 
                                   step="0.01" readonly>
                        </td>
                        <td>
                            <input type="number" name="productos[0][subtotal]" class="form-control subtotal-input" 
                                   step="0.01" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                <i class="bx bx-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">
                            <button type="button" class="btn btn-success btn-sm" id="add-row">
                                <i class="bx bx-plus"></i> Agregar Producto
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 offset-md-6">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>Subtotal:</th>
                    <td class="text-end">
                        <input type="number" name="subtotal" id="subtotal" class="form-control" readonly>
                    </td>
                </tr>
                <tr>
                    <th>IVA (19%):</th>
                    <td class="text-end">
                        <input type="number" name="iva" id="iva" class="form-control" readonly>
                    </td>
                </tr>
                <tr>
                    <th>Total:</th>
                    <td class="text-end">
                        <input type="number" name="total" id="total" class="form-control" readonly>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('productos-table');
    const addRowBtn = document.getElementById('add-row');
    let rowCount = 1;

    // Función para calcular subtotales
    function calcularSubtotales() {
        let subtotal = 0;
        document.querySelectorAll('.subtotal-input').forEach(input => {
            subtotal += parseFloat(input.value || 0);
        });
        const iva = subtotal * 0.19;
        const total = subtotal + iva;
        
        document.getElementById('subtotal').value = subtotal.toFixed(2);
        document.getElementById('iva').value = iva.toFixed(2);
        document.getElementById('total').value = total.toFixed(2);
    }

    // Función para actualizar fila
    function actualizarFila(row) {
        const productoSelect = row.querySelector('.producto-select');
        const cantidadInput = row.querySelector('.cantidad-input');
        const precioInput = row.querySelector('.precio-input');
        const subtotalInput = row.querySelector('.subtotal-input');
        
        const option = productoSelect.selectedOptions[0];
        const precio = parseFloat(option.dataset.precio || 0);
        const cantidad = parseFloat(cantidadInput.value || 0);
        
        precioInput.value = precio.toFixed(2);
        subtotalInput.value = (precio * cantidad).toFixed(2);
        
        calcularSubtotales();
    }

    // Agregar nueva fila
    addRowBtn.addEventListener('click', function() {
        const tbody = table.querySelector('tbody');
        const newRow = tbody.rows[0].cloneNode(true);
        
        // Actualizar nombres de campos
        newRow.querySelectorAll('[name]').forEach(input => {
            input.name = input.name.replace('[0]', `[${rowCount}]`);
        });
        
        // Limpiar valores
        newRow.querySelectorAll('input').forEach(input => {
            input.value = input.type === 'number' ? '1' : '';
        });
        newRow.querySelector('select').selectedIndex = 0;
        
        tbody.appendChild(newRow);
        rowCount++;
        actualizarFila(newRow);
    });

    // Eliminar fila
    table.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            const tbody = table.querySelector('tbody');
            if (tbody.rows.length > 1) {
                e.target.closest('tr').remove();
                calcularSubtotales();
            }
        }
    });

    // Actualizar cálculos al cambiar valores
    table.addEventListener('change', function(e) {
        if (e.target.matches('.producto-select, .cantidad-input')) {
            actualizarFila(e.target.closest('tr'));
        }
    });

    // Inicializar cálculos
    actualizarFila(table.querySelector('tbody tr'));
});
</script>
@endpush 