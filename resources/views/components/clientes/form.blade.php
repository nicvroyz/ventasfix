@props(['cliente' => null])

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="rut_empresa" class="form-label">RUT Empresa <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('rut_empresa') is-invalid @enderror" 
                   id="rut_empresa" name="rut_empresa" value="{{ old('rut_empresa', $cliente?->rut_empresa) }}" required>
            @error('rut_empresa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="rubro" class="form-label">Rubro <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('rubro') is-invalid @enderror" 
                   id="rubro" name="rubro" value="{{ old('rubro', $cliente?->rubro) }}" required>
            @error('rubro')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="razon_social" class="form-label">Razón Social <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('razon_social') is-invalid @enderror" 
                   id="razon_social" name="razon_social" value="{{ old('razon_social', $cliente?->razon_social) }}" required>
            @error('razon_social')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
            <input type="tel" class="form-control @error('telefono') is-invalid @enderror" 
                   id="telefono" name="telefono" value="{{ old('telefono', $cliente?->telefono) }}" required>
            @error('telefono')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('direccion') is-invalid @enderror" 
                   id="direccion" name="direccion" value="{{ old('direccion', $cliente?->direccion) }}" required>
            @error('direccion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="nombre_contacto" class="form-label">Nombre de Contacto <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nombre_contacto') is-invalid @enderror" 
                   id="nombre_contacto" name="nombre_contacto" value="{{ old('nombre_contacto', $cliente?->nombre_contacto) }}" required>
            @error('nombre_contacto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="email_contacto" class="form-label">Email de Contacto <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email_contacto') is-invalid @enderror" 
                   id="email_contacto" name="email_contacto" value="{{ old('email_contacto', $cliente?->email_contacto) }}" required>
            @error('email_contacto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validar campos requeridos
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        let firstInvalidField = null;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            showValidationErrors({
                'campos_requeridos': ['Por favor, complete todos los campos requeridos.']
            });
            if (firstInvalidField) {
                firstInvalidField.focus();
            }
            return;
        }
        
        // Validar email de contacto
        const emailField = form.querySelector('#email_contacto');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailField.value)) {
            showValidationErrors({
                'email_contacto': ['Por favor, ingrese un email válido.']
            });
            emailField.classList.add('is-invalid');
            emailField.focus();
            return;
        }
        
        // Validar teléfono
        const telefonoField = form.querySelector('#telefono');
        const telefonoRegex = /^[0-9+\-\s()]*$/;
        if (!telefonoRegex.test(telefonoField.value)) {
            showValidationErrors({
                'telefono': ['Por favor, ingrese un número de teléfono válido.']
            });
            telefonoField.classList.add('is-invalid');
            telefonoField.focus();
            return;
        }
        
        // Si todo está bien, enviar el formulario
        form.submit();
    });
});
</script>
@endpush 