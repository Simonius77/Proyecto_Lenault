<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Panel de administrador</title>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Barra lateral -->
      <nav class="col-12 col-md-3 col-lg-2 bg-light min-vh-100">
        <h4 class="p-3">Admin Restaurante</h4>
        <ul class="nav nav-pills flex-column" id="admin-menu" role="tablist">
          <li class="nav-item">
            <button class="nav-link active" id="usuarios-tab" data-bs-toggle="pill" data-bs-target="#usuarios"
              type="button" role="tab">
              Usuarios
            </button>
          </li>
          <li class="nav-item">
            <button class="nav-link" id="productos-tab" data-bs-toggle="pill" data-bs-target="#productos" type="button"
              role="tab">
              Productos
            </button>
          </li>
          <li class="nav-item">
            <button class="nav-link" id="pedidos-tab" data-bs-toggle="pill" data-bs-target="#pedidos" type="button"
              role="tab">
              Pedidos
            </button>
          </li>
        </ul>
      </nav>

      <?php
      if (isset($view)) {
        include_once "admindViews/" . $view;
      }
      ?>
    </div>
  </div>
  <script src="Js/admind.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>