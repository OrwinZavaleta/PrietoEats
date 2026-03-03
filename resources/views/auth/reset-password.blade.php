@extends('partials.layout')

@section('title', 'Restablecer Contraseña - Prieto Eats')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-success text-white py-4 text-center">
                        <h4 class="mb-0 fw-bold">Nueva Contraseña</h4>
                        <p class="small mb-0 opacity-75">Introduce tus nuevas credenciales</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('password.store') }}" class="needs-validation" novalidate>
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Address -->
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    id="email" name="email" value="{{ old('email', $request->email) }}" placeholder="Email" required readonly>
                                <label for="email" class="text-muted">Correo Electrónico</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                    id="password" name="password" placeholder="Contraseña" required autofocus>
                                <label for="password" class="text-muted">Nueva Contraseña</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                    id="password_confirmation" name="password_confirmation" placeholder="Confirmar" required>
                                <label for="password_confirmation" class="text-muted">Confirmar Contraseña</label>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg fw-bold rounded-pill shadow-sm">
                                    Restablecer Contraseña
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection