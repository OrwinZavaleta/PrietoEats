@extends('partials.layout')

@section('title', 'Iniciar Sesión - Prieto Eats')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-success text-white text-center py-4">
                        <h4 class="mb-0 fw-bold">Bienvenido de nuevo</h4>
                        <p class="small mb-0 opacity-75">Ingresa a tu cuenta para ordenar</p>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                            @csrf

                            <!-- Email -->
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="nombre@ejemplo.com"
                                    value="{{ old('email') }}" required autofocus>
                                <label for="email" class="text-muted">Correo Electrónico</label>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">
                                        Por favor ingresa un email válido.
                                    </div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Contraseña" required>
                                <label for="password" class="text-muted">Contraseña</label>
                                <div class="invalid-feedback">
                                    Por favor ingresa tu contraseña.
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check mb-4">
                                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                <label for="remember_me" class="form-check-label text-muted small">
                                    Mantener sesión iniciada
                                </label>
                            </div>

                            <!-- Actions -->
                            <div class="d-grid gap-2">
                                <button class="btn btn-success btn-lg fw-bold rounded-pill shadow-sm" type="submit">Iniciar Sesión</button>
                            </div>

                            <div class="text-center mt-4">
                                <p class="small text-muted mb-0">¿No tienes cuenta? <a href="{{ route('register') }}"
                                        class="text-success fw-bold text-decoration-none">Regístrate aquí</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
@endpush
