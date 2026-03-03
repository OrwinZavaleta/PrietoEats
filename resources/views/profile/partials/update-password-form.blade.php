<form method="post" action="{{ route('password.update') }}" class="needs-validation" novalidate>
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="update_password_current_password" class="form-label fw-bold text-muted">Contraseña Actual</label>
        <input type="password" class="form-control form-control-lg @error('current_password', 'updatePassword') is-invalid @enderror" 
            id="update_password_current_password" name="current_password" autocomplete="current-password">
        @error('current_password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password" class="form-label fw-bold text-muted">Nueva Contraseña</label>
        <input type="password" class="form-control form-control-lg @error('password', 'updatePassword') is-invalid @enderror" 
            id="update_password_password" name="password" autocomplete="new-password">
        @error('password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password_confirmation" class="form-label fw-bold text-muted">Confirmar Contraseña</label>
        <input type="password" class="form-control form-control-lg @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
            id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password">
        @error('password_confirmation', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center gap-3 mt-4">
        <button type="submit" class="btn btn-success rounded-pill fw-bold px-4">
            Actualizar Contraseña
        </button>

        @if (session('status') === 'password-updated')
            <span class="text-success fw-bold small">
                <i class="bi bi-check-circle-fill me-1"></i> Guardado.
            </span>
        @endif
    </div>
</form>