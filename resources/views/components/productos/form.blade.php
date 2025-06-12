@props(['producto' => null])

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                   id="sku" name="sku" value="{{ old('sku', $producto?->sku) }}" required>
            @error('sku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                   id="nombre" name="nombre" value="{{ old('nombre', $producto?->nombre) }}" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="precio_neto" class="form-label">Precio Neto <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control @error('precio_neto') is-invalid @enderror" 
                   id="precio_neto" name="precio_neto" value="{{ old('precio_neto', $producto?->precio_neto) }}" required>
            @error('precio_neto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="precio_venta" class="form-label">Precio de Venta <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control @error('precio_venta') is-invalid @enderror" 
                   id="precio_venta" name="precio_venta" value="{{ old('precio_venta', $producto?->precio_venta) }}" readonly>
            @error('precio_venta')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="stock_actual" class="form-label">Stock Actual <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('stock_actual') is-invalid @enderror" 
                   id="stock_actual" name="stock_actual" value="{{ old('stock_actual', $producto?->stock_actual) }}" required>
            @error('stock_actual')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="stock_minimo" class="form-label">Stock Mínimo <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('stock_minimo') is-invalid @enderror" 
                   id="stock_minimo" name="stock_minimo" value="{{ old('stock_minimo', $producto?->stock_minimo) }}" required>
            @error('stock_minimo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="stock_bajo" class="form-label">Stock Bajo <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('stock_bajo') is-invalid @enderror" 
                   id="stock_bajo" name="stock_bajo" value="{{ old('stock_bajo', $producto?->stock_bajo) }}" required>
            @error('stock_bajo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="stock_alto" class="form-label">Stock Alto <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('stock_alto') is-invalid @enderror" 
                   id="stock_alto" name="stock_alto" value="{{ old('stock_alto', $producto?->stock_alto) }}" required>
            @error('stock_alto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="mb-3">
            <label for="descripcion_corta" class="form-label">Descripción Corta <span class="text-danger">*</span></label>
            <textarea class="form-control @error('descripcion_corta') is-invalid @enderror" 
                      id="descripcion_corta" name="descripcion_corta" rows="2" required>{{ old('descripcion_corta', $producto?->descripcion_corta) }}</textarea>
            @error('descripcion_corta')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="mb-3">
            <label for="descripcion_larga" class="form-label">Descripción Larga <span class="text-danger">*</span></label>
            <textarea class="form-control @error('descripcion_larga') is-invalid @enderror" 
                      id="descripcion_larga" name="descripcion_larga" rows="4" required>{{ old('descripcion_larga', $producto?->descripcion_larga) }}</textarea>
            @error('descripcion_larga')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen del Producto</label>
            <input type="file" class="form-control @error('imagen') is-invalid @enderror" 
                   id="imagen" name="imagen" accept="image/*">
            @error('imagen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if($producto?->imagen)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen actual" class="img-thumbnail" style="max-height: 200px">
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const precioNetoInput = document.getElementById('precio_neto');
    const precioVentaInput = document.getElementById('precio_venta');
    
    // Calcular precio de venta cuando cambia el precio neto
    precioNetoInput.addEventListener('input', function() {
        const precioNeto = parseFloat(this.value) || 0;
        const precioVenta = precioNeto * 1.19; // 19% IVA
        precioVentaInput.value = precioVenta.toFixed(2);
    });
    
    // Si hay un precio neto inicial, calcular el precio de venta
    if (precioNetoInput.value) {
        const precioNeto = parseFloat(precioNetoInput.value) || 0;
        const precioVenta = precioNeto * 1.19;
        precioVentaInput.value = precioVenta.toFixed(2);
    }
    
    form.addEventListener('submit', function(e) {
        // Validar campos requeridos
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos requeridos.');
            return;
        }
        
        // Validar valores numéricos
        const numericFields = ['precio_neto', 'stock_actual', 'stock_minimo', 'stock_bajo', 'stock_alto'];
        let numericErrors = [];
        
        numericFields.forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            const value = parseFloat(field.value);
            
            if (isNaN(value) || value < 0) {
                numericErrors.push(`El campo ${fieldName} debe ser un número positivo.`);
                field.classList.add('is-invalid');
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert(numericErrors.join('\n'));
            return;
        }
    });
});
</script>
@endpush 