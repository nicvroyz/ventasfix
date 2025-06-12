<div class="row">
    <div class="col-md-6 mb-3">
        <label for="rut" class="form-label">RUT <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('rut') is-invalid @enderror" 
               id="rut" name="rut" value="{{ old('rut', $usuario->rut ?? '') }}" required>
        @error('rut')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" 
               id="name" name="name" value="{{ old('name', $usuario->name ?? '') }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('apellido') is-invalid @enderror" 
               id="apellido" name="apellido" value="{{ old('apellido', $usuario->apellido ?? '') }}" required>
        @error('apellido')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" value="{{ old('email', $usuario->email ?? '') }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="password" class="form-label">Contraseña @if(empty($usuario))<span class="text-danger">*</span>@endif</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" 
               id="password" name="password" @if(empty($usuario)) required @endif>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="password_confirmation" class="form-label">Confirmar Contraseña @if(empty($usuario))<span class="text-danger">*</span>@endif</label>
        <input type="password" class="form-control" 
               id="password_confirmation" name="password_confirmation" @if(empty($usuario)) required @endif>
    </div>
</div> 