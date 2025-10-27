<?php
require_once "./admin/includes/crudPeliculas.php";
$peliculaObj = new Peliculas();

// Si hay id en la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $peliculaObj->sumarVisita($id); // Si quieres contar visitas
    $pelicula = $peliculaObj->getPeliculaById($id);
    if (!$pelicula) {
        header("Location:index.php");
        exit();
    }
} else {
    header("Location:index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pelicula['titulo']) ?> - La Butaca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="logo.png">
</head>
<body class="bg-dark text-light">
<?php include("menu.php"); ?>

<main class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <img src="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>" class="img-fluid rounded shadow" alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
        </div>
        <div class="col-md-8">
            <h2><?= htmlspecialchars($pelicula['titulo']) ?></h2>
            <p><strong>Año:</strong> <?= htmlspecialchars($pelicula['anio']) ?></p>
            <p><strong>Duración:</strong> <?= htmlspecialchars($pelicula['duracion']) ?> min</p>
            <p><strong>Descripción:</strong> <?= htmlspecialchars($pelicula['descripcion']) ?></p>
            <p><strong>Director:</strong> <?= htmlspecialchars($pelicula['director']) ?></p>
            <p><strong>Fecha de estreno:</strong> <?= date("d/m/Y", strtotime($pelicula['fecha_estreno'])) ?></p>
            <!-- Aquí puedes mostrar más datos, como género, actores, visitas, valoración, etc. -->
        </div>
    </div>
    <a href="index.php" class="btn btn-secondary mt-4">Volver</a>
</main>

<?php include("footer.php"); ?>
</body>
</html>
