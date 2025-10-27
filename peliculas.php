<?php
require_once('includes/database.php');
include 'menu.php';
$sql = "SELECT * FROM peliculas LIMIT 12";
$result = $conn->query($sql);
?>
<div class="container mt-5">
  <h2>Catálogo de películas</h2>
  <div class="row">
    <?php while ($f = $result->fetch_assoc()): ?>
    <div class="col-md-3 mb-4">
      <div class="card">
        <img src="imagenes/<?php echo $f['imagen_id'];?>.jpg" class="card-img-top" alt="<?php echo $f['titulo']; ?>">
        <div class="card-body">
          <h5 class="card-title"><?php echo $f['titulo']; ?></h5>
          <a href="detalle.php?id=<?php echo $f['id'];?>" class="btn btn-info">Ver detalles</a>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>
<?php include 'footer.php'; ?>
