
// Pagina de Administracion en JavaScript para consultas y administracion de productos, pedidos y usuarios


// Obtener los botones
const botonesMenu = document.querySelectorAll(".menu-btn");

// Obtener las secciones
const secciones = document.querySelectorAll(".content-section");

botonesMenu.forEach((boton) => {
    boton.addEventListener("click", () => {
        // Quitar la clase active de todos los botones para darles estilo
        botonesMenu.forEach(b => b.classList.remove('active'));
        boton.classList.add('active');

        const targetId = boton.getAttribute("data-target");
        setActiveSection(targetId);
    });
});

function setActiveSection(targetId) {
    secciones.forEach((seccion) => {
        // Usamos la clase "d-none" de Bootstrap para ocultar el elemento
        seccion.classList.add("d-none");
    });

    // Quita d-none del elemento objetivo para mostrarlo
    const targetSection = document.getElementById(targetId);
    if (targetSection) {
        targetSection.classList.remove("d-none");
    }
}

// Clase Producto

class Product {
    constructor(id, name, description, category, price, available) {
        this.id = id;
        this.name = name;
        this.description = description;
        this.category = category;
        this.price = parseFloat(price);
        this.available = available;
    }

    // Metodos de la clase Producto
    getHtmlRow() {
        const statusBadge = this.available == 1
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-danger">Hidden</span>';

        // ACTUALIZADO: agregar el boton de eliminar con la funcion onclick
        return `
            <tr id="row-${this.id}">
                <td>${this.id}</td>
                <td><strong>${this.name}</strong></td>
                <td>${this.category}</td>
                <td>$${this.price.toFixed(2)}</td>
                <td>${statusBadge}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary me-2" onclick="openEditModal(${this.id})">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteProduct(${this.id})">Delete</button>
                </td>
            </tr>
        `;
    }
}


// FETCH y gestion de datos 


const arrayProducts = []; // Array para almacenar los productos

// Llama a la API que creamos anteriormente
fetch('index.php?controller=Api&action=products')
    .then(response => response.json())
    .then(data => {

        // Recorrer los datos JSON
        data.forEach(item => {
            // Crear un nuevo objeto usando la clase
            const nuevoProducto = new Product(
                item.id,
                item.name,
                item.description,
                item.category,
                item.price,
                item.available
            );

            // Agrega a nuestro Array
            arrayProducts.push(nuevoProducto);
        });

        // Una vez que tengamos los datos, renderizamos la tabla
        renderTable(arrayProducts);
    })
    .catch(error => console.error("Error loading products:", error));


// Funcion para dibujar la matriz en el HTML
function renderTable(productsList) {
    const tableBody = document.getElementById('productsTableBody');
    tableBody.innerHTML = ""; // Borrar contenido existente

    productsList.forEach(product => {
        // Usar el metodo de la clase para obtener el HTML
        tableBody.innerHTML += product.getHtmlRow();
    });
}


// Filtrar o buscar  requiere funciones de orden superior


const searchInput = document.getElementById('searchInput');

// Evento: Cuando el usuario escribe en la caja de busqueda
searchInput.addEventListener('input', (e) => {
    const text = e.target.value.toLowerCase();

    // Usar .filter() (Funcion de orden superior)
    const filteredProducts = arrayProducts.filter(product => {
        return product.name.toLowerCase().includes(text);
    });

    // Redibujar la tabla con los resultados filtrados
    renderTable(filteredProducts);
});


// Funcion de borrado.


function deleteProduct(id) {
    // Confirmacion del usuario
    if (!confirm("Are you sure you want to delete this product?")) return;

    // Enviar peticion a la API
    fetch('index.php?controller=Api&action=delete_product', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Manipulacion del DOM: eliminar filas sin recargar
                const row = document.getElementById(`row-${id}`);
                if (row) {
                    row.remove();
                }

                // Opcional: Eliminar de nuestro array local tambien
                const index = arrayProducts.findIndex(p => p.id === id);
                if (index > -1) arrayProducts.splice(index, 1);

            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

// 6. LOGICA DEL MODAL (Crear y Editar)


// A. ABRIR MODAL PARA NUEVO PRODUCTO
function openCreateModal() {
    // 1. Cambiar Titulo
    document.getElementById('modalTitle').innerText = "New Product";

    // 2. Limpiar Campos
    document.getElementById('prodId').value = ""; // ID vacio significa "Crear"
    document.getElementById('prodName').value = "";
    document.getElementById('prodDesc').value = "";
    document.getElementById('prodPrice').value = "";
    document.getElementById('prodCategory').value = "Meats";

    // 3. Mostrar Modal de Bootstrap
    const modal = new bootstrap.Modal(document.getElementById('productModal'));
    modal.show();
}

// B. ABRIR MODAL PARA EDICION
function openEditModal(id) {
    // 1. Buscar el producto en nuestro array JS (No es necesario volver a consultar la base de datos)
    const product = arrayProducts.find(p => p.id == id);
    if (!product) return;

    // 2. Rellenar el formulario
    document.getElementById('modalTitle').innerText = "Edit Product";
    document.getElementById('prodId').value = product.id; // Si el ID existe significa "Actualizar"
    document.getElementById('prodName').value = product.name;
    document.getElementById('prodDesc').value = product.description || "";
    document.getElementById('prodPrice').value = product.price;
    document.getElementById('prodCategory').value = product.category;

    // 3. Mostrar modal
    const modal = new bootstrap.Modal(document.getElementById('productModal'));
    modal.show();
}

// C. FUNCION DE GUARDADO
function saveProduct() {
    // 1. Recopilar datos del formulario
    const id = document.getElementById('prodId').value;
    const name = document.getElementById('prodName').value;
    const description = document.getElementById('prodDesc').value;
    const category = document.getElementById('prodCategory').value;
    const price = document.getElementById('prodPrice').value;
    const image = document.getElementById('prodImage').value;

    // Validacion
    if (!name || !price) {
        alert("Please fill in all required fields.");
        return;
    }

    // 2. Preparar datos (Payload)
    const payload = {
        id: id, // Si es una cadena vacia, PHP lo trata como null/nuevo
        name: name,
        description: description,
        category: category,
        price: price,
        image: image
    };

    // 3. Enviar a la API
    fetch('index.php?controller=Api&action=save_product', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 4. Cerrar Modal
                const modalEl = document.getElementById('productModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();

                // 5.Actualizar datos
                // Opcion A: Recargar todo (la mas facil)
                // location.reload(); 

                // Opcion B: Actualizacion inteligente (mas rapida)
                if (id) {
                    // ACTUALIZACION: Buscar un objeto en el array y actualizarlo
                    const product = arrayProducts.find(p => p.id == id);
                    product.name = name;
                    product.description = description;
                    product.category = category;
                    product.price = parseFloat(price);
                    // Volver a renderizar
                    renderTable(arrayProducts);
                } else {
                    // CREAR: Crear un nuevo objeto y agregarlo al array
                    const newProd = new Product(data.id, name, description, category, price, 1);
                    arrayProducts.push(newProd);
                    renderTable(arrayProducts);
                }

                alert(data.message);
            } else {
                alert("Error saving product.");
            }
        })
        .catch(error => console.error('Error:', error));
    //  GESTIÓN DE USUARIOS 
    // Clase que representa una entidad usuario
    class User {
        constructor(id, nombre, email, rol) {
            this.id = id;
            this.nombre = nombre;
            this.email = email;
            this.rol = rol;
        }
        getHtmlRow() {
            return `
            <tr id="user-row-${this.id}">
                <td>${this.id}</td>
                <td><strong>${this.nombre}</strong></td>
                <td>${this.email}</td>
                <td>${this.rol}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary me-2" onclick="openEditUserModal(${this.id})">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteUser(${this.id})">Delete</button>
                </td>
            </tr>
        `;
        }
    }

    const arrayUsers = [];

    // Obtiene la lista de usuarios desde la API y rellena la tabla
    function fetchUsers() {
        fetch('index.php?controller=Api&action=users')
            .then(r => r.json())
            .then(data => {
                data.forEach(item => {
                    const u = new User(item.id_usuario, item.nombre, item.email, item.rol);
                    arrayUsers.push(u);
                });
                renderUserTable(arrayUsers);
            })
            .catch(err => console.error('Error loading users:', err));
    }

    // Renderiza el array de usuarios en el cuerpo de la tabla HTML
    function renderUserTable(users) {
        const tbody = document.getElementById('usersTableBody');
        tbody.innerHTML = '';
        users.forEach(u => tbody.innerHTML += u.getHtmlRow());
    }

    // Elimina un usuario después de confirmar y actualiza la interfaz
    function deleteUser(id) {
        if (!confirm('¿Seguro que deseas eliminar este usuario?')) return;
        fetch('index.php?controller=Api&action=delete_user', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    const row = document.getElementById(`user-row-${id}`);
                    if (row) row.remove();
                    const idx = arrayUsers.findIndex(u => u.id === id);
                    if (idx > -1) arrayUsers.splice(idx, 1);
                } else {
                    alert('Error: ' + res.message);
                }
            })
            .catch(err => console.error(err));
    }

    // Open the edit modal pre‑filled with the selected user's data
    function openEditUserModal(id) {
        const user = arrayUsers.find(u => u.id === id);
        if (!user) return;
        document.getElementById('userModalTitle').innerText = 'Editar Usuario';
        document.getElementById('userId').value = user.id;
        document.getElementById('userName').value = user.nombre;
        document.getElementById('userEmail').value = user.email;
        document.getElementById('userRole').value = user.rol;
        const modal = new bootstrap.Modal(document.getElementById('userModal'));
        modal.show();
    }

    // Send the new/edited user data to the server and refresh the table
    function saveUser() {
        const id = document.getElementById('userId').value;
        const nombre = document.getElementById('userName').value;
        const email = document.getElementById('userEmail').value;
        const rol = document.getElementById('userRole').value;
        if (!nombre || !email) { alert('Complete all fields'); return; }
        const payload = { id, nombre, email, rol };
        fetch('index.php?controller=Api&action=save_user', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    const modalEl = document.getElementById('userModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();
                    // Update local array
                    if (id) {
                        const u = arrayUsers.find(u => u.id == id);
                        u.nombre = nombre; u.email = email; u.rol = rol;
                    } else {
                        const newUser = new User(res.id, nombre, email, rol);
                        arrayUsers.push(newUser);
                    }
                    renderUserTable(arrayUsers);
                } else {
                    alert('Error: ' + res.message);
                }
            })
            .catch(err => console.error(err));
    }

    // GESTION DE PEDIDOS 
    // Clase que representa una entidad pedido
    class Order {
        constructor(id, usuario, total, fecha, local, recoger) {
            this.id = id;
            this.usuario = usuario; // nombre del usuario
            this.total = parseFloat(total);
            this.fecha = fecha;
            this.local = local;
            this.recoger = recoger;
        }
        getHtmlRow() {
            const tipo = this.local ? 'Local' : (this.recoger ? 'Para Llevar' : '');
            return `
            <tr id="order-row-${this.id}">
                <td>${this.id}</td>
                <td>${this.usuario}</td>
                <td>${this.total.toFixed(2)} €</td>
                <td>${this.fecha}</td>
                <td>${tipo}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary me-2" onclick="openEditOrderModal(${this.id})">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteOrder(${this.id})">Delete</button>
                </td>
            </tr>
        `;
        }
    }

    const arrayOrders = [];

    // Load orders from the API and render them
    function fetchOrders() {
        fetch('index.php?controller=Api&action=orders')
            .then(r => r.json())
            .then(data => {
                data.forEach(item => {
                    const o = new Order(item.id_pedido, item.nombre_usuario, item.importe_total, item.fecha, item.local, item.recoger);
                    arrayOrders.push(o);
                });
                renderOrderTable(arrayOrders);
            })
            .catch(err => console.error('Error loading orders:', err));
    }

    // Populate the orders table with data
    function renderOrderTable(orders) {
        const tbody = document.getElementById('ordersTableBody');
        tbody.innerHTML = '';
        orders.forEach(o => tbody.innerHTML += o.getHtmlRow());
    }

    // Remove an order after user confirmation
    function deleteOrder(id) {
        if (!confirm('¿Eliminar este pedido?')) return;
        fetch('index.php?controller=Api&action=delete_order', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    const row = document.getElementById(`order-row-${id}`);
                    if (row) row.remove();
                    const idx = arrayOrders.findIndex(o => o.id === id);
                    if (idx > -1) arrayOrders.splice(idx, 1);
                } else {
                    alert('Error: ' + res.message);
                }
            })
            .catch(err => console.error(err));
    }

    // Open modal to edit an existing order
    function openEditOrderModal(id) {
        const order = arrayOrders.find(o => o.id === id);
        if (!order) return;
        document.getElementById('orderModalTitle').innerText = 'Editar Pedido';
        document.getElementById('orderId').value = order.id;
        document.getElementById('orderUser').value = order.usuario;
        document.getElementById('orderTotal').value = order.total;
        document.getElementById('orderDate').value = order.fecha;
        document.getElementById('orderTipo').value = order.local ? 'local' : (order.recoger ? 'recoger' : '');
        const modal = new bootstrap.Modal(document.getElementById('orderModal'));
        modal.show();
    }

    // Save new or edited order data to the server
    function saveOrder() {
        const id = document.getElementById('orderId').value;
        const usuario = document.getElementById('orderUser').value;
        const total = parseFloat(document.getElementById('orderTotal').value);
        const fecha = document.getElementById('orderDate').value;
        const tipo = document.getElementById('orderTipo').value;
        const local = tipo === 'local' ? 1 : 0;
        const recoger = tipo === 'recoger' ? 1 : 0;
        const payload = { id, usuario, total, fecha, local, recoger };
        fetch('index.php?controller=Api&action=save_order', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    const modalEl = document.getElementById('orderModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();
                    if (id) {
                        const o = arrayOrders.find(o => o.id == id);
                        o.usuario = usuario; o.total = total; o.fecha = fecha; o.local = local; o.recoger = recoger;
                    } else {
                        const newOrder = new Order(res.id, usuario, total, fecha, local, recoger);
                        arrayOrders.push(newOrder);
                    }
                    renderOrderTable(arrayOrders);
                } else {
                    alert('Error: ' + res.message);
                }
            })
            .catch(err => console.error(err));
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', () => {
        fetchUsers();
        fetchOrders();
    });

}