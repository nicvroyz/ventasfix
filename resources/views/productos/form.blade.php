@props(['producto' => null])

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="sku" class="form-label">SKU</label>
            <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                id="sku" name="sku" value="{{ old('sku', $producto?->sku) }}" required />
            @error('sku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                id="nombre" name="nombre" value="{{ old('nombre', $producto?->nombre) }}" required />
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="descripcion_corta" class="form-label">Descripción Corta</label>
            <input type="text" class="form-control @error('descripcion_corta') is-invalid @enderror" 
                id="descripcion_corta" name="descripcion_corta" 
                value="{{ old('descripcion_corta', $producto?->descripcion_corta) }}" required />
            @error('descripcion_corta')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="descripcion_larga" class="form-label">Descripción Larga</label>
            <textarea class="form-control @error('descripcion_larga') is-invalid @enderror" 
                id="descripcion_larga" name="descripcion_larga" rows="4" required>{{ old('descripcion_larga', $producto?->descripcion_larga) }}</textarea>
            @error('descripcion_larga')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="precio_neto" class="form-label">Precio Neto</label>
            <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" step="0.01" class="form-control @error('precio_neto') is-invalid @enderror" 
                    id="precio_neto" name="precio_neto" 
                    value="{{ old('precio_neto', $producto?->precio_neto) }}" required />
            </div>
            @error('precio_neto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen del Producto</label>
            <input type="file" class="form-control @error('imagen') is-invalid @enderror" 
                id="imagen" name="imagen" accept="image/*" {{ $producto ? '' : 'required' }} />
            @error('imagen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if($producto && $producto->imagen)
                <div class="mt-2">
                    <img src="{{ Storage::url($producto->imagen) }}" alt="Imagen actual" class="img-thumbnail" style="max-height: 100px;">
                </div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="mb-3">
            <label for="stock_actual" class="form-label">Stock Actual</label>
            <input type="number" class="form-control @error('stock_actual') is-invalid @enderror" 
                id="stock_actual" name="stock_actual" 
                value="{{ old('stock_actual', $producto?->stock_actual) }}" required />
            @error('stock_actual')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label for="stock_minimo" class="form-label">Stock Mínimo</label>
            <input type="number" class="form-control @error('stock_minimo') is-invalid @enderror" 
                id="stock_minimo" name="stock_minimo" 
                value="{{ old('stock_minimo', $producto?->stock_minimo) }}" required />
            @error('stock_minimo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label for="stock_bajo" class="form-label">Stock Bajo</label>
            <input type="number" class="form-control @error('stock_bajo') is-invalid @enderror" 
                id="stock_bajo" name="stock_bajo" 
                value="{{ old('stock_bajo', $producto?->stock_bajo) }}" required />
            @error('stock_bajo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label for="stock_alto" class="form-label">Stock Alto</label>
            <input type="number" class="form-control @error('stock_alto') is-invalid @enderror" 
                id="stock_alto" name="stock_alto" 
                value="{{ old('stock_alto', $producto?->stock_alto) }}" required />
            @error('stock_alto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div> 