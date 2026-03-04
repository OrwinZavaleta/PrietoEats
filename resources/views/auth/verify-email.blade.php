@extends('partials.layout')

@section('title', 'Verificar Correo - Prieto Eats')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-center">
                    <div class="card-body p-5">
                        <div class="mb-4 text-success opacity-75">
                            <i class="bi bi-envelope-check display-1"></i>
                        </div>
                        
                        <h3 class="fw-bold mb-3">Verifica tu correo</h3>
                        
                        <p class="text-muted mb-4">
                            ¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar? Si no recibiste el correo, con gusto te enviaremos otro.
                        </p>

                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success rounded-3 small mb-4" role="alert">
                                Se ha enviado un nuevo enlace de verificación a la dirección de correo que proporcionaste durante el registro.
                            </div>
                        @endif

                        <div class="d-grid gap-3">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold w-100 shadow-sm">
                                    Reenviar correo de verificación
                                </button>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary rounded-pill fw-bold w-100">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection