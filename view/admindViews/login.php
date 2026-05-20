<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
                <div class="card-header border-0 text-white text-center py-4" style="background: linear-gradient(135deg, #1f1c2c, #928dab);">
                    <h3 class="fw-bold mb-0">Mi Lenault</h3>
                    <p class="text-white-50 mb-0 font-monospace" style="font-size: 0.85rem;">Acceso Clientes y Admin</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="?controller=Usuario&action=Authenticate" method="POST">
                        <div class="mb-4">
                            <label for="username" class="form-label fw-semibold text-secondary">Nombre de Usuario o Correo</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-user"></i></span>
                                <input type="text" id="username" name="username" class="form-control bg-light border-start-0 py-2.5 rounded-end-3" placeholder="ejemplo o correo@instituto.com" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-secondary">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fas fa-lock"></i></span>
                                <input type="password" id="password" name="password" class="form-control bg-light border-start-0 py-2.5 rounded-end-3" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-dark btn-lg py-2.5 rounded-3 fw-bold shadow-sm" style="background: #1f1c2c; border: none; transition: transform 0.2s;">
                                Iniciar Sesión
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">¿No tienes cuenta? 
                            <a href="?controller=Usuario&action=RegisterView" class="fw-bold text-decoration-none" style="color: #928dab;">Regístrate aquí</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-dark:hover {
        transform: translateY(-2px);
        background: #3a354c !important;
    }
</style>