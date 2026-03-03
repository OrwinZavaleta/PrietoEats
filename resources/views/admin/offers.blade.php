@extends('partials.layout')

@section('title', 'Mis Reservas - Prieto Eats')

@section('content')
    <div class="container py-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 gap-3">
            <div>
                <h2 class="fw-bold text-success mb-0">
                    @admin
                        <i class="bi bi-calendar-range-fill me-2"></i>Gestión de Ofertas
                    @endadmin
                </h2>
                <p class="text-muted mt-1 mb-0">Programa los menús para las próximas fechas.</p>
            </div>
            <div class="text-end">
                <a href="{{ route('admin.offers.create') }}" class="btn btn-success btn-lg rounded-pill shadow-sm fw-bold px-4">
                    <i class="bi bi-plus-lg me-2"></i>Nueva Oferta
                </a>
            </div>
        </div>

        @if ($offers->isEmpty())
            @admin
                <div class="card border-0 shadow-sm rounded-4 py-5 bg-light">
                    <div class="card-body text-center py-5">
                        <div class="display-1 text-success opacity-25 mb-4">
                            <i class="bi bi-calendar-x"></i>
                        </div>
                        <h3 class="fw-bold text-secondary">No hay ofertas programadas</h3>
                        <p class="text-muted mb-4">Crea una nueva oferta para empezar a recibir pedidos.</p>
                        <a href="{{ route('admin.offers.create') }}" class="btn btn-outline-success rounded-pill fw-bold">
                            Crear primera oferta
                        </a>
                    </div>
                </div>
            @endadmin
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($offers as $o)
                    @admin
                        <div class="col">
                            <div class="card h-100 border-0 shadow rounded-4 overflow-hidden hover-shadow transition-all">
                                <div class="card-header bg-white border-0 pt-4 px-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                                            <i class="bi bi-calendar-check fs-4"></i>
                                        </div>
                                        <div>
                                            <small class="text-uppercase text-muted fw-bold ls-wide">Entrega</small>
                                            <h5 class="fw-bold mb-0">
                                                {{ \Carbon\Carbon::parse($o->date_delivery)->translatedFormat('l, j \d\e F') }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body px-4">
                                    <h6 class="fw-bold text-muted mb-3 border-bottom pb-2">Menú disponible</h6>
                                    <ul class="list-unstyled mb-4">
                                        @foreach ($o->productsOffer as $po)
                                            <li class="d-flex align-items-start mb-2">
                                                <i class="bi bi-check-circle-fill text-success me-2 mt-1 small"></i>
                                                <span class="text-dark">{{ $po->product->name }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="card-footer bg-light border-0 px-4 py-3">
                                    <form action="{{ route('admin.offers.destroy', $o->id) }}" method="post" class="d-grid form-delete" data-confirm-message="Esta oferta y sus productos asociados se eliminarán.">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger rounded-pill fw-bold btn-sm">
                                            <i class="bi bi-trash me-2"></i>Eliminar Oferta
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endadmin
                @endforeach
            </div>
        @endif
    </div>
@endsection

@push('scripts')
@endpush
