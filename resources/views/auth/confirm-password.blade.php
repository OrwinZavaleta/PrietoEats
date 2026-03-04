@extends('partials.layout')

@section('title', 'Confirmar Acceso - Prieto Eats')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-danger text-white text-center py-4">
                        <i class="bi bi-shield-lock-fill display-4 opacity-50 mb-2"></i>
                        <h4 class="mb-0 fw-bold">Confirmar Acceso</h4>
                        <p class="small mb-0 opacity-75">Esta es una zona segura de la aplicación.</p>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted small mb-4 text-center">
                            Por favor, confirma tu contraseña antes de continuar.
                        </p>

                        <form method="POST" action="{{ route('password.confirm') }}" class="needs-validation" novalidate>
                            @csrf

                            <!-- Password -->
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                    id="password" name="password" placeholder="Contraseña" required autocomplete="current-password">
                                <label for="password" class="text-muted">Contraseña</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger btn-lg fw-bold rounded-pill shadow-sm">
                                    Confirmar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/js/form-validation.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form[action="{{ route('password.confirm') }}"]');

            PrietoValidation.init(form, {
                password: [
                    'required',
                ],
            });
        });
    </script>
@endpush