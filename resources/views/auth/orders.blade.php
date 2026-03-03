@extends('partials.layout')

@section('title', 'Mis Reservas - Prieto Eats')

@section('content')
    <div class="container py-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 gap-3">
            <div>
                <h2 class="fw-bold text-success mb-0">
                    <i class="bi bi-journal-check me-2"></i>Mis Reservas
                </h2>
                <p class="text-muted mt-1 mb-0">Consulta el historial de todos tus pedidos realizados en Prieto Eats.</p>
            </div>
            <div class="text-end">
                <a href="{{ route('home') }}" class="btn btn-success btn-lg rounded-pill shadow-sm fw-bold px-4">
                    <i class="bi bi-plus-lg me-2"></i>Nueva Reserva
                </a>
            </div>
        </div>

        @if ($orders->isEmpty())
            <div class="card border-0 shadow-sm rounded-4 py-5 bg-light">
                <div class="card-body text-center py-5">
                    <div class="display-1 text-success opacity-25 mb-4">
                        <i class="bi bi-basket2"></i>
                    </div>
                    <h3 class="fw-bold text-secondary">Aún no tienes reservas</h3>
                    <p class="text-muted mb-4">Tu historial de pedidos aparecerá aquí una vez que realices tu primera
                        reserva.</p>
                    <a href="{{ route('home') }}" class="btn btn-outline-success rounded-pill fw-bold px-4">
                        ¡Quiero pedir algo!
                    </a>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($orders as $o)
                    <div class="col">
                        <div class="card h-100 border-0 shadow rounded-4 overflow-hidden hover-shadow transition-all">
                            <!-- Cabecera de la Reserva -->
                            <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success mb-2 px-3 py-2 rounded-pill small fw-bold">
                                            Reserva #{{ $o->id }}
                                        </span>
                                        <div class="text-muted small mt-1">
                                            <i class="bi bi-calendar-check me-1"></i>
                                            {{ $o->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block text-uppercase fw-bold"
                                            style="font-size: 0.7rem;">Total</small>
                                        <span class="fw-bold fs-4 text-success">{{ number_format($o->total, 2) }}€</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Cuerpo: Listado de platos -->
                            <div class="card-body px-4 pt-2">
                                <h6 class="fw-bold mb-3 text-uppercase small ls-wide text-muted border-bottom pb-2">
                                    <i class="bi bi-list-stars me-2"></i>Detalle del Pedido
                                </h6>
                                <div class="order-items-container" style="max-height: 200px; overflow-y: auto;">
                                    @php $totalPlatos = 0; @endphp
                                    @foreach ($o->products as $item)
                                        @php $totalPlatos += $item->quantity; @endphp
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-2 p-2 rounded-3 bg-light bg-opacity-50">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2 quantity-circle shadow-sm"
                                                    style="width: 25px; height: 25px; font-size: 0.8rem;">
                                                    {{ $item->quantity }}
                                                </div>
                                                <span
                                                    class="small fw-medium text-dark">{{ $offerProducts[$item->product_id]->product->name ?? 'Producto no disponible' }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Footer: Resumen -->
                            <div class="card-footer bg-light border-0 px-4 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Cantidad total</span>
                                    <span
                                        class="badge bg-white text-success border border-success border-opacity-25 px-3 py-2 rounded-pill fw-bold shadow-sm">
                                        {{ $totalPlatos }} {{ $totalPlatos == 1 ? 'plato' : 'platos' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@push('scripts')
@endpush
