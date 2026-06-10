<?php
include_once 'model/ProductoDAO.php';
include_once 'model/PedidoDAO.php';
include_once 'model/LogDAO.php';

class ProductoController
{
    // Mostrar la Carta / Catalogo de Productos
    public function Producto()
    {
        $listaproductos = ProductoDAO::getProductos();
        $view = "productoViews/carta.php";
        require_once __DIR__ . "/../view/plantilla.php";
    }

    // Mostrar el Carrito de Compra
    public function carrito()
    {
        $view = "productoViews/carrito.php";
        require_once __DIR__ . "/../view/plantilla.php";
    }

    // Agregar producto al Carrito (Sesiones PHP, sin JS)
    public function addCart()
    {
        $id_producto = isset($_GET['id_producto']) ? (int)$_GET['id_producto'] : 0;

        if ($id_producto > 0) {
            $producto = ProductoDAO::getProductoByID($id_producto);

            if ($producto) {
                // Inicializar carrito si no existe
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = [];
                }

                // Si ya existe, incrementamos la cantidad, si no lo creamos
                if (isset($_SESSION['carrito'][$id_producto])) {
                    $_SESSION['carrito'][$id_producto]['cantidad']++;
                } else {
                    $_SESSION['carrito'][$id_producto] = [
                        'producto' => $producto,
                        'cantidad' => 1
                    ];
                }
            }
        }

        // Redirigir de vuelta a la carta
        header("Location: ?controller=Producto&action=Producto");
        exit;
    }

    // Modificar cantidad o eliminar del Carrito
    public function removeCart()
    {
        $id_producto = isset($_GET['id_producto']) ? (int)$_GET['id_producto'] : 0;
        $action_type = isset($_GET['type']) ? $_GET['type'] : 'decrease'; // 'decrease' o 'remove'

        if ($id_producto > 0 && isset($_SESSION['carrito'][$id_producto])) {
            if ($action_type === 'remove' || $_SESSION['carrito'][$id_producto]['cantidad'] <= 1) {
                unset($_SESSION['carrito'][$id_producto]);
            } else {
                $_SESSION['carrito'][$id_producto]['cantidad']--;
            }
        }

        header("Location: ?controller=Producto&action=carrito");
        exit;
    }

    // Confirmar el pedido y guardarlo en la Base de Datos
    public function confirmOrder()
    {
        // 1. Verificar si el usuario ha iniciado sesion
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Debes iniciar sesión en tu cuenta de Lenault para finalizar el pedido.";
            header("Location: ?controller=Usuario&action=Login");
            exit;
        }

        // 2. Verificar si el carrito tiene productos
        if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
            $_SESSION['error'] = "El carrito de compra está vacío.";
            header("Location: ?controller=Producto&action=Producto");
            exit;
        }

        // 3. Obtener el tipo de entrega (Local o Para Llevar)
        $tipo_entrega = isset($_POST['tipo_entrega']) ? $_POST['tipo_entrega'] : 'recoger';
        $local = ($tipo_entrega === 'local') ? 1 : 0;
        $recoger = ($tipo_entrega === 'recoger') ? 1 : 0;

        // 4. Calcular el importe total
        $importe_total = 0;
        foreach ($_SESSION['carrito'] as $item) {
            $importe_total += $item['producto']->getPrecio() * $item['cantidad'];
        }

        $id_usuario = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];

        // 5. Guardar en Base de Datos
        $id_pedido = PedidoDAO::insert($id_usuario, $local, $recoger, $importe_total, $_SESSION['carrito']);

        if ($id_pedido) {
            // Guardar en logs
            LogDAO::insertLog($user_name, "Confirmó el pedido #$id_pedido por un total de " . number_format($importe_total, 2) . "€.");
            
            // Limpiar carrito
            unset($_SESSION['carrito']);
            
            $_SESSION['success'] = "¡Pedido realizado con éxito! Tu número de pedido es el #$id_pedido.";
            header("Location: ?controller=Home&action=Home");
            exit;
        } else {
            $_SESSION['error'] = "Ocurrió un error al procesar el pedido. Inténtalo de nuevo.";
            header("Location: ?controller=Producto&action=carrito");
            exit;
        }
    }
}
?>