<div class="row">
    <div class="col-md-6 mb-3">
        <label for="codigo" class="form-label">Código <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('codigo') is-invalid @enderror" 
               id="codigo" name="codigo" value="{{ old('codigo') }}" required>
        @error('codigo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
               id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="precio" class="form-label">Precio <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="number" step="0.01" class="form-control @error('precio') is-invalid @enderror" 
                   id="precio" name="precio" value="{{ old('precio') }}" required>
            @error('precio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
        <input type="number" class="form-control @error('stock') is-invalid @enderror" 
               id="stock" name="stock" value="{{ old('stock', 0) }}" required>
        @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="categoria" class="form-label">Categoría <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('categoria') is-invalid @enderror" 
               id="categoria" name="categoria" value="{{ old('categoria') }}" required>
        @error('categoria')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="unidad_medida" class="form-label">Unidad de Medida <span class="text-danger">*</span></label>
        <select class="form-select @error('unidad_medida') is-invalid @enderror" 
                id="unidad_medida" name="unidad_medida" required>
            <option value="">Seleccione una unidad</option>
            <option value="PIEZA" {{ old('unidad_medida') == 'PIEZA' ? 'selected' : '' }}>Pieza</option>
            <option value="KILOGRAMO" {{ old('unidad_medida') == 'KILOGRAMO' ? 'selected' : '' }}>Kilogramo</option>
            <option value="LITRO" {{ old('unidad_medida') == 'LITRO' ? 'selected' : '' }}>Litro</option>
            <option value="METRO" {{ old('unidad_medida') == 'METRO' ? 'selected' : '' }}>Metro</option>
            <option value="METRO_CUADRADO" {{ old('unidad_medida') == 'METRO_CUADRADO' ? 'selected' : '' }}>Metro Cuadrado</option>
            <option value="METRO_CUBICO" {{ old('unidad_medida') == 'METRO_CUBICO' ? 'selected' : '' }}>Metro Cúbico</option>
        </select>
        @error('unidad_medida')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                  id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
        @error('descripcion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 mb-3">
        <label for="imagen" class="form-label">Imagen del Producto</label>
        <input type="file" class="form-control @error('imagen') is-invalid @enderror" 
               id="imagen" name="imagen" accept="image/*">
        @error('imagen')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div> 