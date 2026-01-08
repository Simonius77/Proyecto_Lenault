
<!--pagina home-->
<!-- Banner Principal -->
<div class="container-fluid p-0 mb-5">
    <img src="Imagenes/banner_home.png" alt="Banner Lenault" class="img-fluid w-100" style="height: 400px; object-fit: cover;">
</div>

<section class="container">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="titulo-seccion">Nuestros Platos</h2>
            <hr class="w-25 mx-auto">
        </div>
    </div>

    <!-- Grid de Productos (Reutilizando estilo de Carta) -->
    <div class="d-flex row g-0">
        <?php if (!empty($listaproductos)): ?>
            <?php foreach ($listaproductos as $producto): ?>
                <div class="col-12 col-md-3 d-flex justify-content-center mb-4">
                    <div class="contenido-producto mb-5" style="width:24rem;">
                        <img src="Imagenes/<?= $producto->getImagen() ?>" class="card-img" alt="<?= $producto->getNombre() ?>">
                        <div class="linea-amarilla"></div>
                        <div class="cuerpo-productos">
                            <h4 class="titulo-producto"><?= $producto->getNombre() ?></h4>
                            <p class="descripcion-producto"><?= $producto->getDescripcion() ?></p>
                            <p><strong><?= $producto->getPrecio() ?> €</strong></p>
                            <button class="boton-agregar">
                                <a class="texto-boton" href="?controller=Producto&action=Producto">Ver en Carta</a>
                            </button>
                        </div>
                        <div class="linea-amarilla"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No hay productos disponibles por el momento.</p>
        <?php endif; ?>
    </div>
</section>
    
