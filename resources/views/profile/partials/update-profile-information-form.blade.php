<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="needs-validation" novalidate>
    @csrf
    @method('patch')

    <div class="mb-3">
        <label for="name" class="form-label fw-bold text-muted">Nombre</label>
        <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
            id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label fw-bold text-muted">Correo Electrónico</label>
        <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
            id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="alert alert-warning mt-3 d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>
                    Tu correo no está verificado.
                    <button form="send-verification" class="btn btn-link p-0 align-baseline fw-bold text-decoration-none">
                        Reenviar correo de verificación.
                    </button>
                </div>
            </div>

            @if (session('status') === 'verification-link-sent')
                <div class="alert alert-success mt-2" role="alert">
                    Un nuevo enlace de verificación ha sido enviado a tu correo.
                </div>
            @endif
        @endif
    </div>

    <div class="d-flex align-items-center gap-3 mt-4">
        <button type="submit" class="btn btn-success rounded-pill fw-bold px-4">
            Guardar Cambios
        </button>

        @if (session('status') === 'profile-updated')
            <span class="text-success fw-bold small fade-in-out">
                <i class="bi bi-check-circle-fill me-1"></i> Guardado.
            </span>
        @endif
    </div>
</form>