@extends('partials.layout')

@section('title', 'Crear un nuevo Producto')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-success text-white py-3">
                        <h4 class="mb-0 fw-bold"><i class="bi bi-basket-fill me-2"></i>Crear Nuevo Producto</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.products.store') }}" method="post" class="row g-4 needs-validation"
                            novalidate enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label for="nombre" class="form-label fw-bold text-muted">Nombre del Producto</label>
                                <input type="text" class="form-control form-control-lg" id="nombre" name="nombre"
                                    placeholder="Ej. Paella Valenciana" required>
                                <div class="invalid-feedback">
                                    Nombre del producto no valido
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="precio" class="form-label fw-bold text-muted">Precio (€)</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light text-success fw-bold">€</span>
                                    <input type="number" class="form-control" min="0.01" step="0.01" id="precio"
                                        name="precio" placeholder="0.00" required>
                                </div>
                                <div class="invalid-feedback">
                                    Precio del producto no valido
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="descripcion" class="form-label fw-bold text-muted">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="4"
                                    placeholder="Describe los ingredientes y detalles del plato..."></textarea>
                            </div>
                            <div class="col-12">
                                <label for="imagen" class="form-label fw-bold text-muted">Imagen del Producto</label>
                                <input type="file" class="form-control form-control-lg mb-3" id="imagen" name="imagen"
                                    accept="image/png, image/jpeg, image/webp">
                                
                                <div class="text-center d-none" id="imagePreviewContainer">
                                    <p class="small text-muted mb-2">Previsualización:</p>
                                    <img id="imagePreview" src="#" alt="Vista previa" class="img-fluid rounded-3 shadow-sm object-fit-cover" style="max-height: 200px;">
                                </div>

                                <div class="form-text">Formatos aceptados: PNG, JPG, WebP.</div>
                                <div class="invalid-feedback">
                                    Por favor, seleccione un formato de imagen válido.
                                </div>
                            </div>
                            <div class="col-12 pt-3 text-end">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-lg me-2 rounded-pill">Cancelar</a>
                                <button class="btn btn-success btn-lg px-5 rounded-pill fw-bold" type="submit">
                                    <i class="bi bi-save me-2"></i>Guardar Producto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })

            // Image Preview Logic
            const imgInput = document.getElementById('imagen');
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImg = document.getElementById('imagePreview');

            if(imgInput) {
                imgInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if(file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            previewContainer.classList.remove('d-none');
                        }
                        reader.readAsDataURL(file);
                    } else {
                        previewContainer.classList.add('d-none');
                        previewImg.src = '#';
                    }
                });
            }
        })()
    </script>
@endpush
