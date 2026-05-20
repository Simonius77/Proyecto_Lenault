<?php
include_once 'model/Pedido.php';
include_once 'database/database.php';

class PedidoDAO
{
    // Obtener todos los pedidos con su usuario y sus líneas de pedido
    public static function getPedidos()
    {
        $con = DataBase::connect();
        
        // JOIN con la tabla usuario para obtener el nombre
        $query = "SELECT p.*, u.nombre AS nombre_usuario FROM pedido p LEFT JOIN usuario u ON p.id_usuario = u.id_usuario ORDER BY p.fecha DESC";
        $results = $con->query($query);
        
        $listaPedidos = [];
        
        while ($row = $results->fetch_assoc()) {
            $pedido = new Pedido();
            $pedido->setId_pedido($row['id_pedido']);
            $pedido->setId_usuario($row['id_usuario']);
            $pedido->setLocal($row['local']);
            $pedido->setRecoger($row['recoger']);
            $pedido->setImporte_total($row['importe_total']);
            $pedido->setFecha($row['fecha']);
            $pedido->setNombreUsuario($row['nombre_usuario']);
            
            // Cargar líneas de pedido
            $pedido->setLineas(self::getLineasPedido($row['id_pedido'], $con));
            
            $listaPedidos[] = $pedido;
        }
        
        $con->close();
        return $listaPedidos;
    }

    // Obtener las líneas de un pedido con el nombre de los productos
    private static function getLineasPedido($id_pedido, $con)
    {
        $stmt = $con->prepare("SELECT lp.*, prod.nombre AS nombre_producto FROM linea_pedido lp LEFT JOIN producto prod ON lp.id_producto = prod.id_producto WHERE lp.id_pedido = ?");
        $stmt->bind_param('i', $id_pedido);
        $stmt->execute();
        $results = $stmt->get_result();
        
        $lineas = [];
        while ($row = $results->fetch_assoc()) {
            $lineas[] = [
                'id_linea_pedido' => $row['id_linea_pedido'],
                'id_producto' => $row['id_producto'],
                'nombre_producto' => $row['nombre_producto'] ?: 'Producto no disponible',
                'precio' => (float)$row['precio']
            ];
        }
        $stmt->close();
        return $lineas;
    }

    // Obtener el último pedido de un usuario específico
    public static function getUltimoPedidoByUser($id_usuario)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT p.*, u.nombre AS nombre_usuario FROM pedido p LEFT JOIN usuario u ON p.id_usuario = u.id_usuario WHERE p.id_usuario = ? ORDER BY p.fecha DESC LIMIT 1");
        $stmt->bind_param('i', $id_usuario);
        $stmt->execute();
        $results = $stmt->get_result();
        
        if ($results->num_rows > 0) {
            $row = $results->fetch_assoc();
            $pedido = new Pedido();
            $pedido->setId_pedido($row['id_pedido']);
            $pedido->setId_usuario($row['id_usuario']);
            $pedido->setLocal($row['local']);
            $pedido->setRecoger($row['recoger']);
            $pedido->setImporte_total($row['importe_total']);
            $pedido->setFecha($row['fecha']);
            $pedido->setNombreUsuario($row['nombre_usuario']);
            
            // Cargar líneas
            $pedido->setLineas(self::getLineasPedido($row['id_pedido'], $con));
            
            $stmt->close();
            $con->close();
            return $pedido;
        }
        
        $stmt->close();
        $con->close();
        return null;
    }

    // Insertar un pedido completo con sus líneas a partir de una lista de productos
    public static function insert($id_usuario, $local, $recoger, $importe_total, $productos_carrito)
    {
        $con = DataBase::connect();
        
        // Empezar transacción para asegurar consistencia
        $con->begin_transaction();
        
        try {
            $stmt = $con->prepare("INSERT INTO pedido (id_usuario, local, recoger, importe_total) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('iiid', $id_usuario, $local, $recoger, $importe_total);
            $stmt->execute();
            $id_pedido = $con->insert_id;
            $stmt->close();
            
            // Insertar líneas de pedido
            $stmt_linea = $con->prepare("INSERT INTO linea_pedido (id_pedido, id_producto, precio) VALUES (?, ?, ?)");
            foreach ($productos_carrito as $item) {
                // $item['producto'] es un objeto Producto, y se repite según la cantidad
                $id_prod = $item['producto']->getId_producto();
                $precio = $item['producto']->getPrecio();
                $cantidad = $item['cantidad'];
                
                for ($i = 0; $i < $cantidad; $i++) {
                    $stmt_linea->bind_param('iid', $id_pedido, $id_prod, $precio);
                    $stmt_linea->execute();
                }
            }
            $stmt_linea->close();
            
            $con->commit();
            $con->close();
            return $id_pedido;
        } catch (Exception $e) {
            $con->rollback();
            $con->close();
            return false;
        }
    }

    // Modificar un pedido
    public static function update($id_pedido, $local, $recoger, $importe_total)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE pedido SET local = ?, recoger = ?, importe_total = ? WHERE id_pedido = ?");
        $stmt->bind_param('iidi', $local, $recoger, $importe_total, $id_pedido);
        $status = $stmt->execute();
        $stmt->close();
        $con->close();
        return $status;
    }

    // Eliminar un pedido y sus líneas asociadas
    public static function delete($id_pedido)
    {
        $con = DataBase::connect();
        $con->begin_transaction();
        
        try {
            // Eliminar líneas de pedido primero
            $stmt1 = $con->prepare("DELETE FROM linea_pedido WHERE id_pedido = ?");
            $stmt1->bind_param('i', $id_pedido);
            $stmt1->execute();
            $stmt1->close();
            
            // Eliminar el pedido
            $stmt2 = $con->prepare("DELETE FROM pedido WHERE id_pedido = ?");
            $stmt2->bind_param('i', $id_pedido);
            $stmt2->execute();
            $stmt2->close();
            
            $con->commit();
            $con->close();
            return true;
        } catch (Exception $e) {
            $con->rollback();
            $con->close();
            return false;
        }
    }
}
?>
