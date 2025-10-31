<?php
require_once "./admin/includes/crudPeliculas.php";
require_once "./admin/includes/crudGeneros.php";

$peliculaObj = new Peliculas();
$generoObj = new Generos();

// Obtener el género seleccionado
if (!isset($_GET['genero'])) {
    header("Location:index.php");
    exit();
}

$genero_id = $_GET['genero'];
$genero = $generoObj->getGeneroById($genero_id);

if (!$genero) {
    header("Location:index.php");
    exit();
}

// Obtener películas de este género
$peliculas = $peliculaObj->getPeliculasByGenero($genero_id, 50);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas de <?= htmlspecialchars($genero['nombre']) ?> - La Butaca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="logo.png">
    <style>
        .card {
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card img {
            height: 400px;
            object-fit: cover;
        }
    </style>
</head>
<body class="bg-dark text-light">
<?php include("menu.php"); ?>

<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            Películas de <span class="badge bg-primary"><?= htmlspecialchars($genero['nombre']) ?></span>
        </h2>
        <span class="text-muted"><?= count($peliculas) ?> película(s)</span>
    </div>
    
    <?php if (empty($peliculas)): ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i>
            No hay películas disponibles en este género.
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($peliculas as $pelicula): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card bg-secondary h-100 shadow">
                        <a href="pelicula.php?id=<?= $pelicula['id_pelicula'] ?>">
                            <img src="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a href="pelicula.php?id=<?= $pelicula['id_pelicula'] ?>" 
                                   class="text-light text-decoration-none">
                                    <?= htmlspecialchars($pelicula['titulo']) ?>
                                </a>
                            </h5>
                            <p class="card-text text-muted">
                                <small><?= htmlspecialchars($pelicula['anio']) ?></small>
                            </p>
                            <?php if (!empty($pelicula['descripcion'])): ?>
                                <p class="card-text small">
                                    <?= htmlspecialchars(substr($pelicula['descripcion'], 0, 100)) ?>...
                                </p>
                            <?php endif; ?>
                            <div class="mt-auto">
                                <a href="pelicula.php?id=<?= $pelicula['id_pelicula'] ?>" 
                                   class="btn btn-primary btn-sm w-100">
                                    Ver detalles
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="mt-4">
        <a href="index.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver al inicio
        </a>
    </div>
</main>

<?php include("footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
