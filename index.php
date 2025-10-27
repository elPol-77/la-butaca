<?php
include 'menu.php';
include 'admin/includes/database.php'; // Aquí va tu conexión a la base de datos
require_once 'admin/includes/crudPeliculas.php'; // Tu clase modelo de películas

$peliculaObj = new Peliculas();
$peliculasPopulares = $peliculaObj->getPopulares(4); // Obtiene las 4 más populares
?>

<div class="container-fluid bg-dark text-light py-4 min-vh-100">
  <div class="row">
    <!-- Carrusel principal dinámico: populares -->
    <div class="col-lg-8 mb-4">
      <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner rounded shadow">
          <?php
          $primero = true;
          foreach ($peliculasPopulares as $pelicula): ?>
            <div class="carousel-item <?= $primero ? 'active' : '' ?>">
              <img src="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>" class="d-block w-100 img-fluid" style="max-height:500px;object-fit:cover;" alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
              <div class="carousel-caption d-none d-md-block text-start bg-dark bg-opacity-50 rounded p-3">
                <h2 class="fw-bold"><?= htmlspecialchars($pelicula['titulo']) ?></h2>
                <?php if(!empty($pelicula['descripcion'])): ?>
                  <p><?= htmlspecialchars($pelicula['descripcion']) ?></p>
                <?php endif; ?>
                <div>
                  <span><?= htmlspecialchars("Duracion : " . $pelicula['duracion']. " Min") ?></span>
                </div>
              </div>
            </div>
          <?php
            $primero = false;
          endforeach;
          ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
          <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
          <span class="visually-hidden">Siguiente</span>
        </button>
      </div>
    </div>
    <!-- Lista de Novedades (Próximamente) -->
    <div class="col-lg-4 mb-4">
      <div class="bg-black rounded shadow p-3 h-100">
        <h5 class="fw-bold text-warning mb-4">Novedades</h5>
        <div class="d-flex mb-3">
          <img src="imagenes/portadas_pelis/malice.jpg" width="60" height="60" class="rounded me-2" alt="Malice">
          <div>
            <div>
              <span class="badge bg-dark text-light me-1"><i class="bi bi-play-fill"></i> 1:46</span>
            </div>
            <a href="#" class="fw-bold text-light text-decoration-none">"Malice"</a>
            <div class="small">Watch the Trailer</div>
            <div>
              <span class="me-2"><i class="bi bi-hand-thumbs-up"></i> 48</span>
              <span><i class="bi bi-heart-fill text-danger"></i> 14</span>
            </div>
          </div>
        </div>
        <div class="d-flex mb-3">
          <img src="imagenes/portadas_pelis/imdb.jpg" width="60" height="60" class="rounded me-2" alt="IMDB Interviews">
          <div>
            <span class="badge bg-dark text-light me-1"><i class="bi bi-play-fill"></i> 4:20</span>
            <a href="#" class="fw-bold text-light text-decoration-none">Inside Guillermo del Toro's 'Frankenstein'</a>
            <div class="small">Watch the Interview</div>
            <div>
              <span class="me-2"><i class="bi bi-hand-thumbs-up"></i> 45</span>
              <span><i class="bi bi-heart-fill text-danger"></i> 30</span>
            </div>
          </div>
        </div>
        <div class="d-flex mb-3">
          <img src="imagenes/portadas_pelis/ellamccay.jpg" width="60" height="60" class="rounded me-2" alt="Ella McCay">
          <div>
            <span class="badge bg-dark text-light me-1"><i class="bi bi-play-fill"></i> 2:25</span>
            <a href="#" class="fw-bold text-light text-decoration-none">Ella McCay</a>
            <div class="small">Watch the Trailer</div>
            <div>
              <span class="me-2"><i class="bi bi-hand-thumbs-up"></i> 167</span>
              <span><i class="bi bi-heart-fill text-danger"></i> 81</span>
            </div>
          </div>
        </div>
        <a href="#" class="fw-bold text-warning mt-3 d-inline-block">Explorar tráilers <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>
  </div>

  <!-- DESTACADO HOY -->
  <section class="mt-4">
    <h4 class="ms-4">Destacado hoy</h4>
    <div class="d-flex overflow-auto ps-4">
      <div class="me-3">
        <img src="imagenes/portadas_pelis/pelicula1.jpg" width="120" height="180" class="rounded shadow" alt="...">
      </div>
      <div class="me-3">
        <img src="imagenes/portadas_pelis/pelicula2.jpg" width="120" height="180" class="rounded shadow" alt="...">
      </div>
      <!-- Más miniaturas aquí -->
    </div>
  </section>

  <!-- PERFILES POPULARES -->
  <section class="mt-4">
    <h5 class="ms-4">Actores Populares</h5>
    <div class="d-flex overflow-auto ps-4">
      <div class="me-3 text-center">
        <img src="imagenes/actores/actor1.jpg" width="70" height="70" class="rounded-circle border border-warning" alt="...">
        <div class="mt-2 small">Actor 1</div>
      </div>
      <div class="me-3 text-center">
        <img src="imagenes/actores/actor2.jpg" width="70" height="70" class="rounded-circle border border-warning" alt="...">
        <div class="mt-2 small">Actor 2</div>
      </div>
      <!-- Más perfiles aquí -->
    </div>
  </section>
  
  <!-- FICHAS PELÍCULAS (tipo tarjetas) -->
  <section class="mt-4">
    <h5 class="ms-4">Películas más populares esta semana</h5>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 px-4">
      <div class="col">
        <div class="card bg-dark text-white h-100">
          <img src="imagenes/portadas_pelis/pelicula3.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h6 class="card-title">A House of Dynamite</h6>
            <p class="card-text mb-1">2025 | Drama</p>
            <div class="d-flex justify-content-between align-items-center">
              <span class="badge bg-warning text-dark">8.3</span>
              <button class="btn btn-outline-light btn-sm">Ver más</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Más tarjetas aquí -->
    </div>
  </section>
</div>
<?php include 'footer.php'; ?>
