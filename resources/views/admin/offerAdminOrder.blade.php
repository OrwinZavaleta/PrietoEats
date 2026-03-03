@extends('partials.layout')

@section('title', 'Detalle de Reservas - Prieto Eats')

@section('content')
    <div class="container py-5">
        
        <div class="mb-4">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-link text-decoration-none text-muted ps-0 fw-bold">
                <i class="bi bi-arrow-left me-2"></i>Volver al Historial
            </a>
        </div>

        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;">
                <i class="bi bi-receipt fs-4"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-0">Reservas del {{ \Carbon\Carbon::parse($offer->date_delivery)->translatedFormat('l, j \d\e F') }}</h2>
                <p class="text-muted mb-0">Detalle de pedidos por cliente</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle table-hover">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th scope="col" class="py-3 ps-4 border-0">Cliente</th>
                                @foreach ($offer->productsOffer as $o)
                                    <th scope="col" class="py-3 text-center border-0">{{ $o->product->name }}</th>
                                @endforeach
                                <th scope="col" class="py-3 text-center border-0 fw-bold pe-4">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $columnTotals = [];
                                foreach ($offer->productsOffer as $item) {
                                    $columnTotals[$item->product->id] = 0;
                                }
                            @endphp
                            @forelse ($reportData as $userId => $userData)
                                <tr>
                                    <td scope="row" class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <span class="fw-bold text-dark">{{ $userData['user_name'] }}</span>
                                        </div>
                                    </td>
                                    @php $rowTotal = 0; @endphp
                                    @foreach ($offer->productsOffer as $item)
                                        @php
                                            $qty = $userData['totals'][$item->product->id] ?? 0;
                                            $columnTotals[$item->product->id] += $qty;
                                            $rowTotal += $qty;
                                        @endphp

                                        <td class="text-center text-muted">
                                            @if($qty > 0)
                                                <span class="badge bg-white text-dark border shadow-sm rounded-pill px-3 py-2">
                                                    {{ $qty }}
                                                </span>
                                            @else
                                                <span class="opacity-25">-</span>
                                            @endif
                                        </td>
                                    @endforeach

                                    <td class="text-center pe-4">
                                        <span class="fw-bold text-success fs-5">{{ $rowTotal }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $offer->productsOffer->count() + 2 }}" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bi bi-basket text-muted opacity-25 display-4 mb-2"></i>
                                            <p class="text-muted fw-bold">No hay pedidos registrados para esta oferta.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light">
                            <tr class="fw-bold">
                                <td class="ps-4 py-3 text-uppercase text-secondary small letter-spacing-1">Totales</td>

                                @foreach ($offer->productsOffer as $item)
                                    <td class="text-center py-3 text-success">{{ $columnTotals[$item->product->id] }}</td>
                                @endforeach

                                <!-- Total de totales -->
                                <td class="text-center py-3 text-success fs-5 pe-4">{{ array_sum($columnTotals) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush