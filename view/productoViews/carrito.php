<div class="container py-5">
    <h2 class="fw-bold mb-4 text-center text-dark font-monospace">Tu Carrito de Compra</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])): ?>
        <div class="card shadow-sm border-0 rounded-4 text-center p-5 bg-white">
            <div class="card-body">
                <div class="text-warning mb-4" style="font-size: 4rem;">
                    <i class="fas fa-shopping-basket"></i>
                </div>
                <h4 class="fw-bold text-dark">Tu carrito está vacío</h4>
                <p class="text-muted mb-4">¿Aún no has probado nuestras especialidades? ¡Explora nuestra carta!</p>
                <a href="?controller=Producto&action=Producto" class="btn btn-warning btn-lg fw-bold px-4 py-2 text-dark shadow-sm" style="background: #ffc107; border: none;">
                    Ver la Carta
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <!-- Tabla de Productos -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Producto</th>
                                    <th scope="col" class="py-3">Precio</th>
                                    <th scope="col" class="py-3 text-center">Cantidad</th>
                                    <th scope="col" class="py-3 text-end px-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total_general = 0;
                                foreach ($_SESSION['carrito'] as $id_prod => $item): 
                                    $producto = $item['producto'];
                                    $cantidad = $item['cantidad'];
                                    $subtotal = $producto->getPrecio() * $cantidad;
                                    $total_general += $subtotal;
                                ?>
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <img src="Imagenes/<?= htmlspecialchars($producto->getImagen()); ?>" class="rounded-3 shadow-sm me-3" style="width: 70px; height: 55px; object-fit: cover;" onerror="this.src='Imagenes/default.png'">
                                                <div>
                                                    <h6 class="fw-bold text-dark mb-0"><?= htmlspecialchars($producto->getNombre()); ?></h6>
                                                    <small class="text-muted"><?= htmlspecialchars($producto->getDescripcion()); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3"><?= number_format($producto->getPrecio(), 2); ?> €</td>
                                        <td class="py-3">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <!-- Botón Disminuir -->
                                                <a href="?controller=Producto&action=removeCart&id_producto=<?= $id_prod; ?>&type=decrease" class="btn btn-sm btn-outline-secondary rounded-circle px-2 py-0 fw-bold me-2">-</a>
                                                <span class="fw-bold text-dark px-2"><?= $cantidad; ?></span>
                                                <!-- Botón Aumentar -->
                                                <a href="?controller=Producto&action=addCart&id_producto=<?= $id_prod; ?>" class="btn btn-sm btn-outline-secondary rounded-circle px-2 py-0 fw-bold ms-2">+</a>
                                                
                                                <!-- Eliminar Fila -->
                                                <a href="?controller=Producto&action=removeCart&id_producto=<?= $id_prod; ?>&type=remove" class="btn btn-sm text-danger ms-3" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </td>
                                        <td class="py-3 text-end fw-bold text-dark px-4"><?= number_format($subtotal, 2); ?> €</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Resumen y Confirmación -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 bg-white p-4">
                    <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">Resumen de Compra</h5>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Productos:</span>
                        <span class="fw-bold text-dark"><?= count($_SESSION['carrito']); ?> artículos</span>
                    </div>

                    <div class="d-flex justify-content-between mb-4 border-bottom pb-3">
                        <span class="text-muted">Total del Pedido:</span>
                        <span class="fs-4 fw-bold text-dark"><?= number_format($total_general, 2); ?> €</span>
                    </div>

                    <!-- Formulario de Pedido -->
                    <form action="?controller=Producto&action=confirmOrder" method="POST">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary mb-2">Método de entrega</label>
                            
                            <div class="form-check p-3 border rounded-3 mb-2 bg-light shadow-sm-hover cursor-pointer" onclick="document.getElementById('entrega_recoger').click()">
                                <input class="form-check-input ms-0 me-2" type="radio" name="tipo_entrega" id="entrega_recoger" value="recoger" checked>
                                <label class="form-check-label fw-semibold text-dark" for="entrega_recoger">
                                    <i class="fas fa-shopping-bag me-1 text-warning"></i> Para Recoger (Llevar)
                                </label>
                            </div>
                            
                            <div class="form-check p-3 border rounded-3 bg-light shadow-sm-hover cursor-pointer" onclick="document.getElementById('entrega_local').click()">
                                <input class="form-check-input ms-0 me-2" type="radio" name="tipo_entrega" id="entrega_local" value="local">
                                <label class="form-check-label fw-semibold text-dark" for="entrega_local">
                                    <i class="fas fa-utensils me-1 text-warning"></i> Consumir en el Local
                                </label>
                            </div>
                        </div>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold py-3 text-dark rounded-3 shadow" style="background: #ffc107; border: none; transition: transform 0.2s;">
                                Confirmar Pedido
                            </button>
                        <?php else: ?>
                            <a href="?controller=Usuario&action=Login" class="btn btn-outline-dark btn-lg w-100 fw-bold py-3 rounded-3 mb-2">
                                Iniciar Sesión para Pedir
                            </a>
                            <small class="text-muted d-block text-center mt-1">Debes tener cuenta para poder confirmar el pedido.</small>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .cursor-pointer {
        cursor: pointer;
    }
    .shadow-sm-hover:hover {
        border-color: #ffc107 !important;
        background: #fffbef !important;
    }
    .btn:hover {
        transform: translateY(-1px);
    }
</style>