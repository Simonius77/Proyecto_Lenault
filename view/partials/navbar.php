<!--barra de navegacion principal-->
<nav class="navbar">
    <div class="container">
        <a class="navbar-logo" href="home.php">

        </a>
        <!--boton para colapsar el nav en el movil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!--menu lado izquierdo-->
        <div>
            <ul class="nav-izquierdo">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="http://localhost/Proyecto_Lenault/?controller=Producto&action=Producto">Carta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/Proyecto_Lenault/?controller=Home&action=aboutus">Quienes
                        somos</a>
                </li>
            </ul>
        </div>
        <!--menu lado derecho-->
        <div>
            <ul class="nav-derecho">
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/Proyecto_Lenault/?controller=Home&action=login">My
                        Lenault</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="carrito.php">Carrito</a>
                </li>
            </ul>
        </div>
    </div>
</nav>