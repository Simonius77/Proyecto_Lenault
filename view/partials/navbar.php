<!-- barra de navegacion principal -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold font-monospace text-warning fs-3" href="?controller=Home&action=Home">
            LE <span class="text-white">NAULT</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menú lado izquierdo -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="?controller=Home&action=Home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=Producto&action=Producto">Carta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=Home&action=aboutus">Quiénes Somos</a>
                </li>
            </ul>

            <!-- Menú lado derecho -->
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Carrito -->
                <li class="nav-item me-3">
                    <a class="nav-link btn btn-outline-warning px-3 py-1.5 position-relative text-warning border-warning" href="?controller=Producto&action=carrito">
                        <i class="fas fa-shopping-cart me-1"></i> Carrito
                        <?php 
                        $cart_count = 0;
                        if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                            foreach ($_SESSION['carrito'] as $item) {
                                $cart_count += $item['cantidad'];
                            }
                        }
                        if ($cart_count > 0): 
                        ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= $cart_count; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>

                <!-- Usuario / Mi Cuenta -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> Hola, <?= htmlspecialchars($_SESSION['user_name']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="navbarDropdown">
                            <?php if (strtolower($_SESSION['user_role']) === 'admin'): ?>
                                <li>
                                    <a class="dropdown-item fw-bold text-primary" href="?controller=Admind&action=Admind">
                                        <i class="fas fa-cog me-2"></i>Panel Administrador
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            <?php endif; ?>
                            <li>
                                <a class="dropdown-item text-danger" href="?controller=Usuario&action=Logout">
                                    <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-warning text-dark px-3 fw-bold border-0" href="?controller=Usuario&action=Login" style="background: #ffc107;">
                            <i class="fas fa-user me-1"></i> Mi Lenault
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Font Awesome para los iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">