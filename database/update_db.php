<?php
require_once 'database/database.php';

$con = DataBase::connect();

if ($con->connect_error) {
    die("Database connection failed: " . $con->connect_error . "\n");
}

echo "Connected successfully to MySQL.\n";

// 1. Añadir columna 'fecha' a la tabla 'pedido' si no existe
$result = $con->query("SHOW COLUMNS FROM `pedido` LIKE 'fecha'");
if ($result->num_rows == 0) {
    echo "Adding 'fecha' column to 'pedido' table...\n";
    $q = "ALTER TABLE `pedido` ADD COLUMN `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
    if ($con->query($q)) {
        echo "'fecha' column added successfully.\n";
    } else {
        echo "Error adding 'fecha' column: " . $con->error . "\n";
    }
} else {
    echo "'fecha' column already exists in 'pedido' table.\n";
}

// 2. Crear tabla 'logs'
echo "Checking 'logs' table...\n";
$q = "CREATE TABLE IF NOT EXISTS `logs` (
    `id_log` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario` VARCHAR(100) NOT NULL,
    `accion` VARCHAR(255) NOT NULL,
    `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($con->query($q)) {
    echo "'logs' table is ready.\n";
} else {
    echo "Error creating 'logs' table: " . $con->error . "\n";
}

$con->close();
echo "Database migration complete!\n";
?>
