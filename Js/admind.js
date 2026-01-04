
// Página de Administración en JavaScript para consultas y administración de productos, pedidos y usuarios


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

    // Métodos de la clase Producto
    getHtmlRow() {
        const statusBadge = this.available == 1
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-danger">Hidden</span>';

        // ACTUALIZADO: añadir el botón de eliminar con la función onclick
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


// FETCH y gestión de datos 


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

            // Añade a nuestra Array
            arrayProducts.push(nuevoProducto);
        });

        // Una vez que tengamos los datos, renderizamos la tabla
        renderTable(arrayProducts);
    })
    .catch(error => console.error("Error loading products:", error));


// Función para dibujar la matriz en el HTML
function renderTable(productsList) {
    const tableBody = document.getElementById('productsTableBody');
    tableBody.innerHTML = ""; // Borrar contenido existente

    productsList.forEach(product => {
        // Usar el método de la clase para obtener el HTML
        tableBody.innerHTML += product.getHtmlRow();
    });
}


// Filtrar o buscar  requiere funciones de orden superior


const searchInput = document.getElementById('searchInput');

// Evento: Cuando el usuario escribe en la caja de búsqueda
searchInput.addEventListener('input', (e) => {
    const text = e.target.value.toLowerCase();

    // Usar .filter() (Función de orden superior)
    const filteredProducts = arrayProducts.filter(product => {
        return product.name.toLowerCase().includes(text);
    });

    // Redibujar la tabla con los resultados filtrados
    renderTable(filteredProducts);
});


// Funcion de borrado.


function deleteProduct(id) {
    // Confirmación del usuario
    if (!confirm("Are you sure you want to delete this product?")) return;

    // Enviar petición a la API
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
                // Manipulación del DOM: eliminar filas sin recargar
                const row = document.getElementById(`row-${id}`);
                if (row) {
                    row.remove();
                }

                // Opcional: Eliminar de nuestro array local también
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
    // 1. Cambiar Título
    document.getElementById('modalTitle').innerText = "New Product";

    // 2. Limpiar Campos
    document.getElementById('prodId').value = ""; // ID vacío significa "Crear"
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
    // 1. Buscar el producto en nuestro array JS (¡No es necesario volver a consultar la base de datos!)
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

    // Validación
    if (!name || !price) {
        alert("Please fill in all required fields.");
        return;
    }

    // 2. Preparar datos (Payload)
    const payload = {
        id: id, // Si es una cadena vacía, PHP lo trata como null/nuevo
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
                // Opción A: Recargar todo (la más fácil)
                // location.reload(); 

                // Opción B: Actualización inteligente (más rápida)
                if (id) {
                    // ACTUALIZACIÓN: Buscar un objeto en el array y actualizarlo
                    const product = arrayProducts.find(p => p.id == id);
                    product.name = name;
                    product.description = description;
                    product.category = category;
                    product.price = parseFloat(price);
                    // Volver a renderizar
                    renderTable(arrayProducts);
                } else {
                    // CREAR: Crear un nuevo objeto y añadirlo al array
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
}