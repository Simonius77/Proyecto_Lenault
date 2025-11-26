
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Home</title>
</head>
<body>
    <header class="header">
    <!--Colocamos un include para llamar al navbar y asi con un solo nav lo 
    puedes montar entodas las paginas con solo una linea y los cambios que se realicaen los realiza en todas partes por igual-->
    <?php include_once __DIR__. '/partials/navbar.php'; ?>
    </header>
    <main>
        <section>

        </section>
        <section>

        </section>
        <section>

        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
<!--footer-->
<!--lo mismo que el navbar pero con el footer-->
<?php include_once __DIR__. '/partials/footer.php'; ?>
</html>