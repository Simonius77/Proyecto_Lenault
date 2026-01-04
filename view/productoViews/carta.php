<div class="d-flex row g-0">
    <?php foreach ($listaproductos as $producto): ?>
        <div class="col-12 col-md-3 d-flex justify-content-center mb-4">
            <div class="contenido-producto mb-5" style="width:24rem;">
                <img src="Imagenes/<?= $producto->getImagen() ?>" class="card-img">
                <div class="linea-amarilla"></div>
                <div class="cuerpo-productos">
                    <h4 class="titulo-producto"><?= $producto->getNombre() ?></h4>
                    <p class="descripcion-producto"><?= $producto->getDescripcion() ?></p>
                    <p><strong><?= $producto->getPrecio() ?> €</strong></p>
                    <button class="boton-agregar">
                        <a class="texto-boton" href="#">Agregar</a>
                    </button>
                </div>
                <div class="linea-amarilla"></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>