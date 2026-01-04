<!-- Contenido panel de administrador con bootstrap -->
<main class="col-12 col-md-9 col-lg-10 p-4">
    <div class="tab-content" id="admin-tabContent">
        <!-- SECCIÓN USUARIOS -->
        <div class="tab-pane fade show active" id="usuarios" role="tabpanel" aria-labelledby="usuarios-tab">
            <h2>Gestión de Usuarios</h2>
            <p>Funcionalidad de usuarios próximamente.</p>
        </div>

        <!-- SECCIÓN PRODUCTOS -->
        <div class="tab-pane fade" id="productos" role="tabpanel" aria-labelledby="productos-tab">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Productos</h2>
                <button class="btn btn-primary" onclick="openCreateModal()">
                    <i class="fas fa-plus"></i> Nuevo Producto
                </button>
            </div>

            <!-- Buscador -->
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Buscar productos...">
            </div>

            <!-- Tabla de Productos -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody">
                        <!-- Filas generadas por JS -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SECCIÓN PEDIDOS -->
        <div class="tab-pane fade" id="pedidos" role="tabpanel" aria-labelledby="pedidos-tab">
            <h2>Gestión de Pedidos</h2>
            <p>Funcionalidad de pedidos próximamente.</p>
        </div>
    </div>
</main>

<!-- MODAL DE PRODUCTO (Crear / Editar) -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productForm">
                    <!-- ID Hidden -->
                    <input type="hidden" id="prodId">

                    <div class="mb-3">
                        <label for="prodName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="prodName" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="prodDesc" class="form-label">Descripción</label>
                        <textarea class="form-control" id="prodDesc" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="prodCategory" class="form-label">Categoría (ID)</label>
                            <!-- Idealmente esto sería un <select> cargado dinámicamente -->
                            <input type="number" class="form-control" id="prodCategory" placeholder="Ej: 1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="prodPrice" class="form-label">Precio</label>
                            <input type="number" step="0.01" class="form-control" id="prodPrice" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="prodImage" class="form-label">URL Imagen</label>
                        <input type="text" class="form-control" id="prodImage">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="saveProduct()">Guardar</button>
            </div>
        </div>
    </div>
</div>