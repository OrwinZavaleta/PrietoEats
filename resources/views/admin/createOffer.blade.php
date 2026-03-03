@extends('partials.layout')

@section('title', 'Crear un nuevo Producto')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-success text-white py-3">
                        <h4 class="mb-0 fw-bold"><i class="bi bi-calendar-plus me-2"></i>Crear Nueva Oferta</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.offers.store') }}" method="post" class="row g-3 needs-validation"
                            novalidate enctype="multipart/form-data" id="createOfferForm">
                            @csrf
                            <div class="col-md-4">
                                <label for="date_delivery" class="form-label fw-bold text-muted">Fecha de Entrega</label>
                                <input type="date" class="form-control form-control-lg" id="date_delivery" name="date_delivery"
                                    required>
                                <div class="invalid-feedback">
                                    Fecha no valida
                                </div>
                            </div>
                            
                            <!-- UX Fix: Time Range Selection -->
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-muted">Horario de Entrega</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">De</span>
                                    <input type="time" class="form-control form-control-lg" id="time_start" value="13:30" required aria-label="Hora de inicio">
                                    <span class="input-group-text bg-light border-start-0 border-end-0">a</span>
                                    <input type="time" class="form-control form-control-lg" id="time_end" value="14:30" required aria-label="Hora de fin">
                                </div>
                                <input type="hidden" name="time_delivery" id="time_delivery_input" value="13:30 a 14:30">
                            </div>

                            <div class="col-12 mt-4">
                                <h5 class="fw-bold text-success border-bottom pb-2 mb-3">Productos en la oferta</h5>
                                
                                <div class="mb-3">
                                    <label for="offerSearch" class="visually-hidden">Filtrar productos</label>
                                    <div class="position-relative">
                                        <input type="text" id="offerSearch" class="form-control form-control-lg ps-5" placeholder="Filtrar productos..." aria-label="Buscar productos por nombre">
                                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                                    </div>
                                </div>

                                <div class="border rounded-3 p-2 bg-light" style="max-height: 400px; overflow-y: auto;" id="productsContainer">
                                    <div class="list-group list-group-flush bg-transparent" id="productsList">
                                        @foreach ($platos as $p)
                                            <label class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer border-0 rounded-3 mb-1 product-option bg-white shadow-sm mb-2" data-name="{{ strtolower($p->name) }}">
                                                <input class="form-check-input me-3 shadow-none border-2" type="checkbox" name="platosSeleccionados[]"
                                                    id="{{ $p->id }}" value="{{ $p->id }}" style="transform: scale(1.3);">
                                                <img src="{{ asset('storage/' . ($p->image ?? 'img/unknown-dish.png')) }}"
                                                    alt="{{ $p->name }}" class="rounded-3 object-fit-cover me-3 border" loading="lazy"
                                                    width="60" height="60">
                                                <span class="fs-6 fw-medium text-truncate text-dark" style="max-width: 60%;">{{ $p->name }}</span> 
                                                <span class="fs-5 fw-bold text-success ms-auto">{{ number_format($p->price, 2) }} €</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <div id="noOfferResults" class="text-center py-5 d-none">
                                        <div class="display-1 text-muted opacity-25 mb-3"><i class="bi bi-search"></i></div>
                                        <p class="text-muted mb-0 fw-medium">No se encontraron productos.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 pt-4 text-end">
                                <button class="btn btn-success btn-lg px-5 rounded-pill fw-bold shadow-sm" type="submit">
                                    <i class="bi bi-plus-circle me-2"></i>Crear Oferta
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <div class="container pb-5">
            <div class="alert alert-danger shadow-sm rounded-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
@endsection
@push('scripts')
    <script>
        (() => {
            'use strict'
            
            // Time Range Logic
            const form = document.getElementById('createOfferForm');
            const timeStart = document.getElementById('time_start');
            const timeEnd = document.getElementById('time_end');
            const timeInput = document.getElementById('time_delivery_input');

            const updateTimeInput = () => {
                timeInput.value = `${timeStart.value} a ${timeEnd.value}`;
            };

            if(timeStart && timeEnd) {
                timeStart.addEventListener('change', updateTimeInput);
                timeEnd.addEventListener('change', updateTimeInput);
            }

            // Validation Logic
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                updateTimeInput(); // Ensure value is updated on submit
                form.classList.add('was-validated')
            }, false)


            // Search Logic
            const searchInput = document.getElementById('offerSearch');
            const productsList = document.getElementById('productsList');
            const items = document.querySelectorAll('.product-option');
            const noResults = document.getElementById('noOfferResults');

            const filterItems = () => {
                const term = searchInput ? searchInput.value.toLowerCase() : '';
                let visible = 0;

                items.forEach(item => {
                    const name = item.dataset.name;
                    const isChecked = item.querySelector('input[type="checkbox"]').checked;
                    
                    if (isChecked || name.includes(term)) {
                        item.classList.remove('d-none');
                        visible++;
                    } else {
                        item.classList.add('d-none');
                    }
                });

                if (noResults) {
                    visible === 0 ? noResults.classList.remove('d-none') : noResults.classList.add('d-none');
                }
            };

            const sortItems = () => {
                const itemsArray = Array.from(productsList.children);
                
                itemsArray.sort((a, b) => {
                    const aChecked = a.querySelector('input[type="checkbox"]').checked;
                    const bChecked = b.querySelector('input[type="checkbox"]').checked;
                    
                    if (aChecked && !bChecked) return -1;
                    if (!aChecked && bChecked) return 1;
                    return 0;
                });

                itemsArray.forEach(item => productsList.appendChild(item));
            };

            if(searchInput) {
                searchInput.addEventListener('input', filterItems);
            }

            items.forEach(item => {
                const checkbox = item.querySelector('input[type="checkbox"]');
                checkbox.addEventListener('change', function() {
                    sortItems();
                    filterItems();
                    
                    if (this.checked) {
                         item.classList.add('border-success', 'bg-success', 'bg-opacity-10');
                         item.classList.remove('bg-white');
                    } else {
                         item.classList.remove('border-success', 'bg-success', 'bg-opacity-10');
                         item.classList.add('bg-white');
                    }
                });
            });

        })()
    </script>
@endpush
