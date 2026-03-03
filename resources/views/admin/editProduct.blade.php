@extends('partials.layout')

@section('title', 'Actualizar un Producto')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-warning text-dark py-3">
                        <h4 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Actualizar Producto</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.products.update', $plato->id) }}" method="post"
                            class="row g-4 needs-validation" novalidate enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="col-md-6">
                                <label for="nombre" class="form-label fw-bold text-muted">Nombre</label>
                                <input type="text" class="form-control form-control-lg" id="nombre" name="nombre"
                                    value="{{ $plato->name }}" required>
                                <div class="invalid-feedback">
                                    Nombre del producto no valido
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="precio" class="form-label fw-bold text-muted">Precio (€)</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light text-success fw-bold">€</span>
                                    <input type="number" class="form-control" min="0.01" step="0.01" id="precio"
                                        name="precio" value="{{ $plato->price }}" required>
                                </div>
                                <div class="invalid-feedback">
                                    Precio del producto no valido
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="descripcion" class="form-label fw-bold text-muted">Descripcion</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="4">{{ $plato->description }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-muted mb-2">Imagen del Producto</label>
                                <div class="d-flex flex-column flex-sm-row gap-4 align-items-start">
                                    <div class="text-center">
                                        <p class="small text-muted mb-1">Actual / Nueva:</p>
                                        <img id="imagePreview" src="{{ asset('storage/' . ($plato->image ?? 'img/unknown-dish.png')) }}"
                                            alt="Imagen actual" class="rounded-4 shadow-sm object-fit-cover border" width="150"
                                            height="150">
                                    </div>
                                    <div class="flex-grow-1 w-100">
                                        <label for="imagen" class="form-label fw-bold text-muted mb-1">Cambiar Imagen</label>
                                        <input type="file" class="form-control mb-2" id="imagen" name="imagen"
                                            accept="image/png, image/jpeg, image/webp">
                                        <div class="form-text small mb-2">Dejar vacío para mantener la imagen actual.</div>
                                        <div class="form-text small">Formatos: PNG, JPG, WebP.</div>
                                        <div class="invalid-feedback">
                                            Por favor, seleccione un formato de imagen válido.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 pt-3 text-end">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-lg me-2 rounded-pill">Cancelar</a>
                                <button class="btn btn-warning btn-lg px-5 rounded-pill fw-bold" type="submit">
                                    <i class="bi bi-arrow-repeat me-2"></i>Actualizar
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

            // Image Preview Logic (Update existing img)
            const imgInput = document.getElementById('imagen');
            const previewImg = document.getElementById('imagePreview');
            // Store original src to revert if needed (optional, keeping it simple)

            if(imgInput && previewImg) {
                imgInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if(file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                    // If file input is cleared (user cancels), browser usually clears the input.
                    // We could revert to original src if we stored it, but standard file input behavior varies.
                });
            }
        })()
    </script>
@endpush
