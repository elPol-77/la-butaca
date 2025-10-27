<?php
require_once('includes/database.php');
include 'menu.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM peliculas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$pelicula = $stmt->get_result()->fetch_assoc();
?>
<div class="container mt-5">
  <?php if ($pelicula): ?>
    <h2><?php echo $pelicula['titulo']; ?></h2>
    <img src="imagenes/<?php echo $pelicula['imagen_id']; ?>.jpg" style="max-width:300px;">
    <p><?php echo $pelicula['descripcion']; ?></p>
    <ul>
      <li>Año: <?php echo $pelicula['anio']; ?></li>
      <li>Duración: <?php echo $pelicula['duracion']; ?> min</li>
    </ul>
  <?php else: ?>
    <p>Película no encontrada.</p>
  <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
