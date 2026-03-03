<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="/">
            <img src="/img/gregorioprieto.png" alt="Logo del Instituto Gregorio Prieto"
                class="d-inline-block align-text-top nav-icon shadow-sm rounded-circle"
                style="background: white; padding: 2px;">
            <span class="text-white fs-4 ms-2 tracking-tight">Prieto<span
                    class="badge bg-white text-success rounded-pill ms-1 px-2">Eats</span></span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-lg-2">
                @auth
                    @admin
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white fw-medium" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear-fill me-1 opacity-75"></i> Administrar
                            </a>
                            <ul class="dropdown-menu shadow-lg border-0 rounded-4 p-2 mt-2">
                                <li>
                                    <a class="dropdown-item rounded-3 py-2" href="{{ route('admin.products.index') }}"><i
                                            class="bi bi-basket me-2 text-success"></i>Productos</a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded-3 py-2" href="{{ route('admin.orders.index') }}"><i
                                            class="bi bi-receipt me-2 text-success"></i>Reservas</a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded-3 py-2" href="{{ route('admin.offers.index') }}"><i
                                            class="bi bi-calendar-event me-2 text-success"></i>Ofertas</a>
                                </li>
                            </ul>
                        </li>
                    @endadmin
                    <li class="nav-item me-2">
                        <a class="nav-link text-white position-relative d-inline-block" href="{{ route('cart.index') }}" aria-label="Ver carrito">
                            @if (count(session()->get('cart', [])) > 0)
                                <i class="bi bi-cart-fill fs-5"></i>
                                <span
                                    class="position-absolute start-100 translate-middle badge rounded-pill bg-danger border border-white small shadow-sm" style="min-width: 20px;">
                                    @php
                                        $cantidad = 0;
                                        foreach (session()->get('cart', []) as $cart => $items) {
                                            foreach ($items as $id => $quantity) {
                                                $cantidad += $quantity;
                                            }
                                        }
                                    @endphp
                                    {{ $cantidad }}
                                    <span class="visually-hidden">productos en el carrito</span>
                                </span>
                            @else
                                <i class="bi bi-cart fs-5 opacity-75"></i>
                            @endif
                        </a>
                    </li>
                    
                    <!-- Dropdown Usuario -->
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2 bg-white bg-opacity-10 rounded-pill px-3 py-1 mt-2 mt-lg-0"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                style="width: 24px; height: 24px; font-size: 0.8rem;">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="small fw-bold text-truncate" style="max-width: 100px;">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2 mt-2">
                            <li><a class="dropdown-item rounded-3 py-2" href="{{ route('order.index') }}"> 
                                <i class="bi bi-journal-text me-2 text-success"></i>Mis Reservas</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="post" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item rounded-3 py-2 text-danger"><i
                                            class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a class="btn btn-outline-light rounded-pill px-4 fw-bold btn-sm w-100 w-lg-auto" href="{{ route('login') }}"><i
                                class="bi bi-box-arrow-in-right me-2"></i>Login</a>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-light rounded-pill px-4 text-success fw-bold btn-sm shadow-sm w-100 w-lg-auto"
                            href="{{ route('register') }}"><i class="bi bi-person-plus me-2"></i>Regístrate</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>