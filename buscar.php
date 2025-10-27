<?php
include 'menu.php';
require_once 'admin/includes/database.php';

// Crea el objeto de conexión
$db = new Database();
$conn = $db->getConnection();

$busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';

$resultados = [];
if ($busqueda !== '') {
    $stmt = $conn->prepare("SELECT * FROM peliculas WHERE titulo LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("s", $busqueda);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $resultados[] = $row;
    }
    $stmt->close();
}

$db->closeConnection($conn);
?>

<div class="container py-4">
    <h2>Resultados para: <?= htmlspecialchars($busqueda) ?></h2>
    <div class="row">
        <?php if (empty($resultados)): ?>
            <div class="col-12">
                <p>No se encontraron películas con ese título.</p>
            </div>
        <?php else: ?>
            <?php foreach ($resultados as $pelicula): ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-light h-100">
                        <img src="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($pelicula['titulo']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($pelicula['descripcion']) ?></p>
                            <p class="card-text"><small>Año: <?= htmlspecialchars($pelicula['anio']) ?>, Duración: <?= htmlspecialchars($pelicula['duracion']) ?> min</small></p>
                            <a href="pelicula.php?id=<?= $pelicula['id'] ?>" class="btn btn-warning">Ver detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
