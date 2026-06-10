<?php
include_once 'database/database.php';

class LogDAO
{
    // Insertar una nueva accion en el historial de logs
    public static function insertLog($usuario, $accion)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO logs (usuario, accion) VALUES (?, ?)");
        $stmt->bind_param('ss', $usuario, $accion);
        $status = $stmt->execute();
        $stmt->close();
        $con->close();
        return $status;
    }

    // Obtener todo el historial de logs ordenados por fecha descendente
    public static function getLogs()
    {
        $con = DataBase::connect();
        $result = $con->query("SELECT * FROM logs ORDER BY fecha DESC");
        
        $listaLogs = [];
        while ($row = $result->fetch_assoc()) {
            $listaLogs[] = [
                'id_log' => (int)$row['id_log'],
                'usuario' => $row['usuario'],
                'accion' => $row['accion'],
                'fecha' => $row['fecha']
            ];
        }
        
        $con->close();
        return $listaLogs;
    }
}
?>
