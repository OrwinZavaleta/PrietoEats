@extends('partials.layout')

@section('title', 'Registro - Prieto Eats')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-success text-white text-center py-4">
                        <div class="mb-2">
                            <i class="bi bi-person-plus-fill display-4 opacity-50"></i>
                        </div>
                        <h4 class="mb-0 fw-bold">Crea tu Cuenta</h4>
                        <p class="small mb-0 opacity-75">Únete a la comunidad de Prieto Eats</p>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                            @csrf

                            <!-- Nombre -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Tu Nombre" value="{{ old('name') }}"
                                    required autofocus>
                                <label for="name" class="text-muted">Nombre Completo</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Por favor ingresa tu nombre.</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="nombre@ejemplo.com"
                                    value="{{ old('email') }}" required>
                                <label for="email" class="text-muted">Correo Electrónico</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Ingresa un email válido.</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Contraseña" minlength="8" required>
                                <label for="password" class="text-muted">Contraseña</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">La contraseña es obligatoria.</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-floating mb-4">
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation" placeholder="Confirmar"
                                    minlength="8" required>
                                <label for="password_confirmation" class="text-muted">Confirmar Contraseña</label>
                                <div class="invalid-feedback">
                                    Por favor confirma tu contraseña.
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-grid gap-2">
                                <button class="btn btn-success btn-lg fw-bold rounded-pill shadow-sm" type="submit">Registrarse</button>
                            </div>

                            <div class="text-center mt-4 border-top pt-3">
                                <p class="small text-muted mb-0">¿Ya tienes cuenta? <a href="{{ route('login') }}"
                                        class="text-success fw-bold text-decoration-none">Inicia Sesión</a></p>
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