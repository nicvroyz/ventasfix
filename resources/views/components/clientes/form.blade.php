<div class="row">
    <div class="col-md-6 mb-3">
        <label for="razon_social" class="form-label">Razón Social</label>
        <input type="text" 
               class="form-control @error('razon_social') is-invalid @enderror" 
               id="razon_social" 
               name="razon_social" 
               value="{{ old('razon_social') }}" 
               required>
        @error('razon_social')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="rfc" class="form-label">RFC</label>
        <input type="text" 
               class="form-control @error('rfc') is-invalid @enderror" 
               id="rfc" 
               name="rfc" 
               value="{{ old('rfc') }}" 
               required>
        @error('rfc')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" 
               class="form-control @error('email') is-invalid @enderror" 
               id="email" 
               name="email" 
               value="{{ old('email') }}" 
               required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="telefono" class="form-label">Teléfono</label>
        <input type="tel" 
               class="form-control @error('telefono') is-invalid @enderror" 
               id="telefono" 
               name="telefono" 
               value="{{ old('telefono') }}" 
               required>
        @error('telefono')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="calle" class="form-label">Calle</label>
        <input type="text" 
               class="form-control @error('calle') is-invalid @enderror" 
               id="calle" 
               name="calle" 
               value="{{ old('calle') }}" 
               required>
        @error('calle')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="numero" class="form-label">Número</label>
        <input type="text" 
               class="form-control @error('numero') is-invalid @enderror" 
               id="numero" 
               name="numero" 
               value="{{ old('numero') }}" 
               required>
        @error('numero')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="colonia" class="form-label">Colonia</label>
        <input type="text" 
               class="form-control @error('colonia') is-invalid @enderror" 
               id="colonia" 
               name="colonia" 
               value="{{ old('colonia') }}" 
               required>
        @error('colonia')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="municipio" class="form-label">Municipio</label>
        <input type="text" 
               class="form-control @error('municipio') is-invalid @enderror" 
               id="municipio" 
               name="municipio" 
               value="{{ old('municipio') }}" 
               required>
        @error('municipio')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="estado" class="form-label">Estado</label>
        <input type="text" 
               class="form-control @error('estado') is-invalid @enderror" 
               id="estado" 
               name="estado" 
               value="{{ old('estado') }}" 
               required>
        @error('estado')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="cp" class="form-label">Código Postal</label>
        <input type="text" 
               class="form-control @error('cp') is-invalid @enderror" 
               id="cp" 
               name="cp" 
               value="{{ old('cp') }}" 
               required>
        @error('cp')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="pais" class="form-label">País</label>
        <input type="text" 
               class="form-control @error('pais') is-invalid @enderror" 
               id="pais" 
               name="pais" 
               value="{{ old('pais', 'México') }}" 
               required>
        @error('pais')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="observaciones" class="form-label">Observaciones</label>
    <textarea class="form-control @error('observaciones') is-invalid @enderror" 
              id="observaciones" 
              name="observaciones" 
              rows="3">{{ old('observaciones') }}</textarea>
    @error('observaciones')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div> 