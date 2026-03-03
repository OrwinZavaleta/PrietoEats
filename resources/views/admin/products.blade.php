@extends('partials.layout')

@section('title', 'Catálogo de Productos - Prieto Eats')

@section('content')
    <div class="container py-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 gap-3">
            <div>
                <h2 class="fw-bold text-success mb-0">
                    @admin
                        <i class="bi bi-grid-fill me-2"></i>Catálogo de Productos
                    @endadmin
                </h2>
                <p class="text-muted mt-1 mb-0">Gestiona todos los platos disponibles en la plataforma.</p>
            </div>
            <div class="d-flex gap-3 align-items-center flex-wrap justify-content-center">
                <div class="position-relative">
                    <label for="searchInput" class="visually-hidden">Buscar producto</label>
                    <input type="text" id="searchInput" class="form-control rounded-pill ps-4 pe-5" placeholder="Buscar producto..." aria-label="Buscador de productos por nombre">
                    <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                </div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-lg rounded-pill shadow-sm fw-bold px-4">
                    <i class="bi bi-plus-lg me-2"></i>Nuevo Producto
                </a>
            </div>
        </div>

        @if ($products->isEmpty())
            @admin
                <div class="card border-0 shadow-sm rounded-4 py-5 bg-light">
                    <div class="card-body text-center py-5">
                        <div class="display-1 text-success opacity-25 mb-4">
                            <i class="bi bi-basket3"></i>
                        </div>
                        <h3 class="fw-bold text-secondary">No hay productos registrados</h3>
                        {{-- <p class="text-muted mb-4">Comienza agregando deliciosos platos al menú.</p> --}}
                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-success rounded-pill fw-bold">
                            Crear primer producto
                        </a>
                    </div>
                </div>
            @endadmin
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="productsGrid">
                @foreach ($products as $p)
                    @admin
                        <x-card-product :product="$p" :offers="$p->offers" :editar="true" 
                            class="product-item" 
                            data-name="{{ strtolower($p->name) }}" />
                    @endadmin
                @endforeach
            </div>
            <div id="noResults" class="text-center py-5 d-none">
                <div class="fs-1 text-muted opacity-25 mb-3"><i class="bi bi-search"></i></div>
                <h4 class="text-muted">No se encontraron productos</h4>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const items = document.querySelectorAll('.product-item');
            const noResults = document.getElementById('noResults');

            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const term = e.target.value.toLowerCase();
                    let visibleCount = 0;

                    items.forEach(item => {
                        const name = item.dataset.name;
                        if (name.includes(term)) {
                            item.classList.remove('d-none');
                            visibleCount++;
                        } else {
                            item.classList.add('d-none');
                        }
                    });

                    if (visibleCount === 0) {
                        noResults.classList.remove('d-none');
                    } else {
                        noResults.classList.add('d-none');
                    }
                });
            }
        });
    </script>
@endpush