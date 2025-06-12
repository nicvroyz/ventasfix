@props(['cliente' => null])

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="rut_empresa" class="form-label">RUT Empresa</label>
            <input type="text" class="form-control @error('rut_empresa') is-invalid @enderror" 
                id="rut_empresa" name="rut_empresa" value="{{ old('rut_empresa', $cliente?->rut_empresa) }}" required />
            @error('rut_empresa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="razon_social" class="form-label">Razón Social</label>
            <input type="text" class="form-control @error('razon_social') is-invalid @enderror" 
                id="razon_social" name="razon_social" value="{{ old('razon_social', $cliente?->razon_social) }}" required />
            @error('razon_social')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="rubro" class="form-label">Rubro</label>
            <input type="text" class="form-control @error('rubro') is-invalid @enderror" 
                id="rubro" name="rubro" value="{{ old('rubro', $cliente?->rubro) }}" required />
            @error('rubro')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                id="telefono" name="telefono" value="{{ old('telefono', $cliente?->telefono) }}" required />
            @error('telefono')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control @error('direccion') is-invalid @enderror" 
                id="direccion" name="direccion" value="{{ old('direccion', $cliente?->direccion) }}" required />
            @error('direccion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="nombre_contacto" class="form-label">Nombre de Contacto</label>
            <input type="text" class="form-control @error('nombre_contacto') is-invalid @enderror" 
                id="nombre_contacto" name="nombre_contacto" value="{{ old('nombre_contacto', $cliente?->nombre_contacto) }}" required />
            @error('nombre_contacto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="email_contacto" class="form-label">Email de Contacto</label>
            <input type="email" class="form-control @error('email_contacto') is-invalid @enderror" 
                id="email_contacto" name="email_contacto" value="{{ old('email_contacto', $cliente?->email_contacto) }}" required />
            @error('email_contacto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div> 