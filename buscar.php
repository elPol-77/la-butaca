<?php
include 'menu.php';
require_once 'admin/includes/database.php';

// Instanciar la conexión
$db = new Connection();
$conn = $db->getConnection();
$busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';
echo $busqueda; // Línea de depuración
$resultados = [];
$busqueda_wildcard = "%{$busqueda}%";

if ($busqueda !== '') {
    $stmt = $conn->prepare("SELECT * FROM peliculas WHERE titulo LIKE ?");
    $stmt->bind_param("s", $busqueda_wildcard);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $resultados[] = $row;
    }
    $stmt->close();
}
$db->closeConnection($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar | La Butaca</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="bg-dark text-light">
<!-- El menú ya está incluido arriba -->

<div class="container min-vh-100 py-4">
    <div class="mb-4">
        <h2 class="fw-bold text-danger">Resultados de búsqueda</h2>
            </div>
    <div class="row">
        <?php if (empty($resultados)): ?>
            <div class="col-12">
                <div class="alert alert-danger shadow-sm text-center">No se encontraron películas con ese título.</div>
            </div>
        <?php else: ?>
            <?php foreach ($resultados as $pelicula): ?>
                <div class="col-sm-6 col-lg-4 col-xl-3 mb-4">
                    <div class="card bg-black text-light h-100 border-0 shadow-lg">
                        <img src="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>" class="card-img-top rounded-top" alt="<?= htmlspecialchars($pelicula['titulo']) ?>" style="max-height:330px; object-fit:cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold"><?= htmlspecialchars($pelicula['titulo']) ?></h5>
                            <p class="card-text small">
                                <?= htmlspecialchars($pelicula['descripcion']) ?>
                            </p>
                            <p class="card-text mb-2">
                                <span class="badge bg-danger me-2"><?= htmlspecialchars($pelicula['anio']) ?></span>
                                <span class="badge bg-secondary"><?= htmlspecialchars($pelicula['duracion']) ?> min</span>
                            </p>
                            <a href="pelicula.php?id=<?= $pelicula['id'] ?>" class="btn btn-warning mt-auto">Ver detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="mt-5">
        <a href="index.php" class="btn btn-outline-light">← Volver al inicio</a>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
