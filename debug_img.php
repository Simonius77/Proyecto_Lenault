<?php
include_once 'model/ProductoDAO.php';

echo "<h1>Debug de Imágenes</h1>";
$lista = ProductoDAO::getProductos();

echo "<table border='1'><tr><th>Nombre</th><th>Valor en BD</th><th>Existe Archivo?</th><th>Ruta Probada</th></tr>";

foreach ($lista as $p) {
    if (!$p)
        continue;
    $imgBD = $p->getImagen();
    $ruta = "Imagenes/" . $imgBD;
    $existe = file_exists($ruta) ? "SÍ" : "NO";

    echo "<tr>";
    echo "<td>" . $p->getNombre() . "</td>";
    echo "<td>[" . $imgBD . "]</td>";
    echo "<td>" . $existe . "</td>";
    echo "<td>" . $ruta . "</td>";
    echo "</tr>";
}
echo "</table>";
?>