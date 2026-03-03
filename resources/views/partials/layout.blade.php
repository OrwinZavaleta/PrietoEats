<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap 5.3.8 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="/img/gregorioprieto.png" type="image/x-icon">
    <title>@yield('title', 'Prieto Eats')</title>
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
    <header>
        @include('partials.header')
    </header>

    <main class="flex-grow-1">
        @session('success')
            <div class="container">
                <div class="alert alert-success my-3 alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endsession
        @session('error')
            <div class="container">
                <div class="alert alert-danger my-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endsession
        @session('info')
            <div class="container">
                <div class="alert alert-info my-3" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endsession
        </div>
        @yield('content')
    </main>

    <footer class="mt-auto">
        @include('partials.footer')
    </footer>

    <!-- Modal de Confirmación Genérico -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-danger text-white border-0 py-3">
                    <h5 class="modal-title fw-bold" id="confirmationModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Acción
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <i class="bi bi-trash3 text-danger display-1 opacity-25"></i>
                    </div>
                    <h5 class="fw-bold mb-2" id="modalMessageTitle">¿Estás seguro?</h5>
                    <p class="text-muted" id="modalMessageBody">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer border-0 bg-light p-3 justify-content-center gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm" id="confirmActionBtn">
                        Si, eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3.8 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <!-- Aquí se inyectarán los scripts específicos de cada vista -->
    @stack('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Auto-close alerts
            const alert = document.querySelector(".alert");
            if (alert) {
                setTimeout(() => {
                    const alertInstance = bootstrap.Alert.getOrCreateInstance(alert);
                    alertInstance.close();
                }, 3000);
            }

            // Confirmation Modal Logic
            const deleteForms = document.querySelectorAll('.form-delete');
            const modalElement = document.getElementById('confirmationModal');
            const modal = new bootstrap.Modal(modalElement);
            const confirmBtn = document.getElementById('confirmActionBtn');
            const msgTitle = document.getElementById('modalMessageTitle');
            const msgBody = document.getElementById('modalMessageBody');
            
            let currentForm = null;

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    currentForm = this;
                    
                    // Custom message from data attributes
                    const title = this.dataset.confirmTitle || '¿Estás seguro?';
                    const message = this.dataset.confirmMessage || 'Esta acción eliminará el elemento permanentemente.';
                    const btnText = this.dataset.confirmBtn || 'Si, eliminar';

                    msgTitle.textContent = title;
                    msgBody.textContent = message;
                    confirmBtn.textContent = btnText;

                    modal.show();
                });
            });

            confirmBtn.addEventListener('click', function() {
                if(currentForm) {
                    currentForm.submit();
                }
                modal.hide();
            });
        });
    </script>
</body>

</html>
