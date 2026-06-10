<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold font-monospace text-dark mb-2">NUESTRA CARTA</h1>
        <div style="width: 80px; height: 4px; background: #ffc107; margin: 0 auto;" class="rounded-pill"></div>
        <p class="text-muted mt-3 fs-5">Sabores auténticos, ingredientes frescos y recetas tradicionales elaboradas con amor.</p>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 justify-content-center">
        <?php foreach ($listaproductos as $producto): ?>
            <div class="col d-flex">
                <div class="card w-100 shadow-sm border-0 rounded-4 overflow-hidden bg-white d-flex flex-column" style="transition: transform 0.3s, box-shadow 0.3s; cursor: default;">
                    <!-- Imagen del Producto -->
                    <div class="position-relative overflow-hidden" style="height: 200px;">
                        <img src="Imagenes/<?= htmlspecialchars($producto->getImagen()); ?>" class="w-100 h-100 object-fit-cover card-img-top" onerror="this.src='Imagenes/default.png'" style="transition: transform 0.5s;">
                        <div class="position-absolute bottom-0 start-0 bg-dark text-warning fw-bold px-3 py-1.5 rounded-tr-4" style="background: rgba(0,0,0,0.75);">
                            <?= number_format($producto->getPrecio(), 2); ?> €
                        </div>
                    </div>
                    
                    <!-- Contenido de la Tarjeta -->
                    <div class="card-body p-4 d-flex flex-column flex-grow-1">
                        <h5 class="card-title fw-bold text-dark mb-2"><?= htmlspecialchars($producto->getNombre()); ?></h5>
                        <p class="card-text text-muted mb-4 flex-grow-1" style="font-size: 0.9rem; line-height: 1.4;">
                            <?= htmlspecialchars($producto->getDescripcion()); ?>
                        </p>
                        
                        <!-- Boton Agregar -->
                        <div class="d-grid mt-auto">
                            <a href="?controller=Producto&action=addCart&id_producto=<?= $producto->getId_producto(); ?>" class="btn btn-warning btn-lg fw-bold text-dark py-2.5 rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="background: #ffc107; border: none; transition: background 0.2s;">
                                <i class="fas fa-plus-circle me-2"></i> Agregar al Pedido
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .card:hover img {
        transform: scale(1.05);
    }
    .btn-warning:hover {
        background: #e5ac00 !important;
    }
    .rounded-tr-4 {
        border-top-right-radius: 1rem;
    }
</style>