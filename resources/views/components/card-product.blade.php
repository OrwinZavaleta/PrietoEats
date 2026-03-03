@props(['product', 'offer', 'productOfferId', 'editar' => false])

<div {{ $attributes->merge(['class' => 'col']) }}>
    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card hover-shadow transition-all">
        <div class="position-relative">
            <img src="{{ asset('storage/' . ($product->image ?? 'img/unknown-dish.png')) }}"
                class="card-img-top object-fit-cover" alt="{{ $product->name }}" loading="lazy" style="height: 220px;">
            @if (!$editar)
                <div class="position-absolute top-0 end-0 m-3">
                    <span class="badge bg-white text-success shadow-sm fs-5 fw-bold px-3 py-2 rounded-pill">
                        {{ $product->price }} €
                    </span>
                </div>
            @endif
        </div>

        <div class="card-body d-flex flex-column p-4">
            <h5 class="card-title fw-bold text-dark mb-2">{{ $product->name }}</h5>
            <p class="card-text text-muted small flex-grow-1 line-clamp-3">{{ $product->description }}</p>
            @if ($editar)
                <p class="card-text text-muted small flex-grow-1 line-clamp-3">{{ $product->price }} €</p>
            @endif
            <div class="mt-3 pt-3 border-top border-light">
                @auth
                    @if (auth()->user()->isAdmin() && $editar)
                        <div class="d-flex justify-content-between gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                class="btn btn-warning flex-grow-1 fw-bold rounded-pill">
                                <i class="bi bi-pencil-fill me-1"></i> Editar
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="post"
                                class="flex-grow-1 form-delete"
                                data-confirm-message="¿Eliminar este producto permanentemente?">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger w-100 fw-bold rounded-pill">
                                    <i class="bi bi-trash-fill me-1"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('cart.add', $productOfferId) }}" method="post" class="d-grid">
                            @csrf
                            <button type="submit"
                                class="btn btn-success rounded-pill py-2 fw-bold shadow-sm btn-hover-scale">
                                <i class="bi bi-cart-plus-fill me-2"></i>Añadir al Pedido
                            </button>
                        </form>
                    @endif
                @else
                    <div class="d-grid">
                        <a href="{{ route('login') }}" class="btn btn-outline-success rounded-pill fw-bold">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Inicia sesión para pedir
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
