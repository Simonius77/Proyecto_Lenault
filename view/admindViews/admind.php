<!-- Contenido panel de administrador con bootstrap -->
<main class="col-12 col-md-9 col-lg-10 p-4">
    <div class="tab-content" id="admin-tabContent">
        <!-- SECCION USUARIOS -->
        <div class="tab-pane fade show active" id="usuarios" role="tabpanel" aria-labelledby="usuarios-tab">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Gestión de Usuarios</h2>
                <button class="btn btn-primary" onclick="openCreateUserModal()">
                    <i class="fas fa-plus"></i> Nuevo Usuario
                </button>
            </div>
            
            <!-- Tabla de Usuarios -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <!-- Filas generadas por JS -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SECCION PRODUCTOS -->
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

        <!-- SECCION PEDIDOS -->
        <div class="tab-pane fade" id="pedidos" role="tabpanel" aria-labelledby="pedidos-tab">
            <h2>Gestión de Pedidos</h2>
            
            <!-- Tabla de Pedidos -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="ordersTableBody">
                        <!-- Filas generadas por JS -->
                    </tbody>
                </table>
            </div>
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
                    <!-- ID oculto -->
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
                            <!-- Idealmente esto seria un <select> cargado dinamicamente -->
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

<!-- MODAL DE USUARIO (Crear / Editar) -->
<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalTitle">Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm">
                    <!-- ID oculto -->
                    <input type="hidden" id="userId">

                    <div class="mb-3">
                        <label for="userName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="userName" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="userEmail" required>
                    </div>

                    <div class="mb-3">
                        <label for="userRole" class="form-label">Rol</label>
                        <select class="form-select" id="userRole" required>
                            <option value="cliente">cliente</option>
                            <option value="admin">admin</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="saveUser()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE PEDIDO (Editar) -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalTitle">Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="orderForm">
                    <!-- ID oculto -->
                    <input type="hidden" id="orderId">

                    <div class="mb-3">
                        <label for="orderUser" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="orderUser" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="orderTotal" class="form-label">Importe Total</label>
                        <input type="number" step="0.01" class="form-control" id="orderTotal" required>
                    </div>

                    <div class="mb-3">
                        <label for="orderDate" class="form-label">Fecha</label>
                        <input type="text" class="form-control" id="orderDate" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="orderTipo" class="form-label">Tipo de Entrega</label>
                        <select class="form-select" id="orderTipo" required>
                            <option value="local">Local</option>
                            <option value="recoger">Para Llevar (Recoger)</option>
                            <option value="">No Definido</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="saveOrder()">Guardar</button>
            </div>
        </div>
    </div>
</div>