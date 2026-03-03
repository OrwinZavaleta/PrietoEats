<div class="d-flex flex-column align-items-start">
    <h6 class="fw-bold text-dark">Eliminar Cuenta</h6>
    <p class="text-muted small mb-3">
        Una vez que se elimine tu cuenta, todos sus recursos y datos se eliminarán permanentemente.
    </p>

    <button type="button" class="btn btn-danger rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        <i class="bi bi-trash3-fill me-2"></i>Eliminar Cuenta
    </button>
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-danger text-white border-0 py-3">
                <h5 class="modal-title fw-bold" id="confirmUserDeletionModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>¿Estás seguro?
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                
                <div class="modal-body p-4">
                    <p class="text-muted mb-4">
                        Una vez que se elimine tu cuenta, todos sus recursos y datos se eliminarán permanentemente. Por favor, ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.
                    </p>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                            id="delete_account_password" name="password" placeholder="Contraseña">
                        <label for="delete_account_password">Contraseña</label>
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="modal-footer border-0 bg-light p-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm">
                        Eliminar Cuenta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
            myModal.show();
        });
    </script>
@endif