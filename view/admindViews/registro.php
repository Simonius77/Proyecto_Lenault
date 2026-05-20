<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
                <div class="card-header border-0 text-white text-center py-4" style="background: linear-gradient(135deg, #1f1c2c, #928dab);">
                    <h3 class="fw-bold mb-0">Crea tu Cuenta</h3>
                    <p class="text-white-50 mb-0 font-monospace" style="font-size: 0.85rem;">Únete al Club Lenault y realiza tus pedidos</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="?controller=Usuario&action=Register" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold text-secondary">Nombre de Usuario <span class="text-danger">*</span></label>
                            <input type="text" id="username" name="username" class="form-control bg-light py-2" placeholder="Tu apodo o nombre" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-secondary">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control bg-light py-2" placeholder="correo@instituto.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-secondary">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" id="password" name="password" class="form-control bg-light py-2" placeholder="Mínimo 6 caracteres (sin símbolos especiales)" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telf" class="form-label fw-semibold text-secondary">Teléfono</label>
                                <input type="text" id="telf" name="telf" class="form-control bg-light py-2" placeholder="600000000">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="direccion" class="form-label fw-semibold text-secondary">Dirección</label>
                                <input type="text" id="direccion" name="direccion" class="form-control bg-light py-2" placeholder="Calle Ejemplo, 12">
                            </div>
                        </div>

                        <div class="d-grid mb-3 mt-4">
                            <button type="submit" class="btn btn-dark btn-lg py-2.5 rounded-3 fw-bold shadow-sm" style="background: #1f1c2c; border: none; transition: transform 0.2s;">
                                Registrarse
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">¿Ya tienes una cuenta? 
                            <a href="?controller=Usuario&action=Login" class="fw-bold text-decoration-none" style="color: #928dab;">Inicia Sesión aquí</a>
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