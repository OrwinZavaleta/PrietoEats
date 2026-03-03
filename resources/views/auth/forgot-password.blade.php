@extends('partials.layout')

@section('title', 'Recuperar Contraseña - Prieto Eats')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 px-4 text-center">
                         <div class="mb-3 text-warning">
                            <i class="bi bi-shield-lock display-4"></i>
                        </div>
                        <h4 class="fw-bold mb-2">¿Olvidaste tu contraseña?</h4>
                        <p class="text-muted small mb-0">
                            No hay problema. Solo dinos tu correo electrónico y te enviaremos un enlace para que elijas una nueva.
                        </p>
                    </div>
                    
                    <div class="card-body p-4">
                        @if (session('status'))
                            <div class="alert alert-success mb-4 rounded-3 small" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate>
                            @csrf

                            <!-- Email Address -->
                            <div class="form-floating mb-4">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    id="email" name="email" value="{{ old('email') }}" placeholder="tu@email.com" required autofocus>
                                <label for="email" class="text-muted">Correo Electrónico</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning btn-lg fw-bold rounded-pill text-dark shadow-sm">
                                    Enviar enlace de recuperación
                                </button>
                                <a href="{{ route('login') }}" class="btn btn-light rounded-pill fw-bold text-muted mt-2">
                                    Volver al inicio de sesión
                                </a>
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