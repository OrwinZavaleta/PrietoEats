@extends('partials.layout')

@section('title', 'Historial de Reservas - Prieto Eats')

@section('content')
    <div class="container py-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 gap-3">
            <div>
                @admin
                    <h2 class="fw-bold text-success mb-0">
                        <i class="bi bi-clipboard-data-fill me-2"></i>Historial de Reservas
                    </h2>
                @endadmin
                <p class="text-muted mt-1 mb-0">Visualiza todas las reservas realizadas por los usuarios.</p>
            </div>
        </div>

        @if ($offers->isEmpty())
            @admin
                <div class="card border-0 shadow-sm rounded-4 py-5 bg-light">
                    <div class="card-body text-center py-5">
                        <div class="display-1 text-success opacity-25 mb-4">
                            <i class="bi bi-clipboard-x"></i>
                        </div>
                        <h3 class="fw-bold text-secondary">No hay Ofertas con reservas aún.</h3>
                        <p class="text-muted mb-0">El historial de pedidos está vacío por el momento.</p>
                    </div>
                </div>
            @endadmin
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($offers as $o)
                    @admin
                        <div class="col">
                            <a href="{{ route('admin.offers.show', $o->id) }}"
                                class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition-all text-decoration-none card-hover-effect">
                                <div class="card-body p-4 d-flex flex-column align-items-center text-center">
                                    <div class="mb-3">
                                        <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                                             <i class="bi bi-calendar-event-fill text-success fs-3"></i>
                                        </div>
                                    </div>
                                    <h5 class="card-title fw-bold text-dark mb-2">
                                        Oferta del {{ \Carbon\Carbon::parse($o->date_delivery)->translatedFormat('l, j \d\e F') }}
                                    </h5>
                                    <p class="card-text text-muted small mb-4">
                                        Gestionar los pedidos y reservas para esta fecha.
                                    </p>
                                    <div class="mt-auto">
                                        <span class="btn btn-success rounded-pill px-4 fw-bold">
                                            Ver Reservas
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endadmin
                @endforeach
            </div>
        @endif
    </div>
    
    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
@endsection

@push('scripts')
@endpush