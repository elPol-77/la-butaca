<?php
session_start();
require_once 'admin/includes/database.php';
require_once 'admin/includes/crudPeliculas.php';

// Verificar que se recibió el ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

// Instanciar la clase Peliculas
$peliculaObj = new Peliculas();

// Obtener datos de la película usando el CRUD
$pelicula = $peliculaObj->getPeliculaById($id);

if (!$pelicula) {
    header("Location: index.php");
    exit();
}

// Obtener géneros relacionados usando el CRUD
$generosArray = $peliculaObj->getNombresGenerosByPelicula($id);
$pelicula['generos'] = !empty($generosArray) ? implode(', ', $generosArray) : 'Sin género';

// Obtener actores relacionados
$db = new Connection();
$conn = $db->getConnection();
$actores = [];
$stmt_actores = $conn->prepare("SELECT a.nombre 
                                 FROM actores a 
                                 INNER JOIN pelicula_actor pa ON a.id = pa.actor_id 
                                 WHERE pa.pelicula_id = ?");
if ($stmt_actores) {
    $stmt_actores->bind_param("i", $id);
    $stmt_actores->execute();
    $result_actores = $stmt_actores->get_result();
    while ($row = $result_actores->fetch_assoc()) {
        $actores[] = $row['nombre'];
    }
    $stmt_actores->close();
}
$pelicula['actores'] = !empty($actores) ? implode(', ', $actores) : 'Desconocidos';
$db->closeConnection($conn);

// Obtener películas relacionadas usando el CRUD
$peliculasRelacionadas = $peliculaObj->getPopulares(6);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="<?= htmlspecialchars($pelicula['titulo']) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($pelicula['generos'] ?? 'Película') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= htmlspecialchars($pelicula['titulo']) ?> - La Butaca</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="anime-main/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/plyr.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php include 'head.php'; ?>

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                        <a href="./peliculas.php">Películas</a>
                        <span><?= htmlspecialchars($pelicula['titulo']) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->
    <section class="anime-details spad">
        <div class="container">
            <div class="anime__details__content">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="anime__details__pic set-bg" data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>">
                            <div class="comment"><i class="fa fa-comments"></i> <?= rand(10, 100) ?></div>
                            <div class="view"><i class="fa fa-eye"></i> <?= rand(5000, 25000) ?></div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="anime__details__text">
                            <div class="anime__details__title">
                                <h3><?= htmlspecialchars($pelicula['titulo']) ?></h3>
                                <span><?= htmlspecialchars($pelicula['titulo_original'] ?? $pelicula['titulo']) ?></span>
                            </div>
                            <div class="anime__details__rating">
                                <div class="rating">
                                    <?php 
                                    // Convertir calificación IMDb (0-10) a estrellas (0-5)
                                    $calificacion = isset($pelicula['calificacion']) ? floatval($pelicula['calificacion']) : 0;
                                    $estrellas = ($calificacion / 10) * 5;
                                    $estrellasCompletas = floor($estrellas);
                                    $mediaEstrella = ($estrellas - $estrellasCompletas) >= 0.5;
                                    
                                    for($i = 0; $i < $estrellasCompletas; $i++): ?>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    <?php endfor; ?>
                                    
                                    <?php if($mediaEstrella): ?>
                                        <a href="#"><i class="fa fa-star-half-o"></i></a>
                                    <?php endif; ?>
                                    
                                    <?php for($i = ceil($estrellas); $i < 5; $i++): ?>
                                        <a href="#"><i class="fa fa-star-o"></i></a>
                                    <?php endfor; ?>
                                </div>
                                <span><?= number_format($calificacion, 1) ?> Puntuación</span>
                            </div>
                            <p><?= htmlspecialchars($pelicula['descripcion'] ?? 'Sin descripción disponible.') ?></p>
                            <div class="anime__details__widget">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Género:</span> <?= htmlspecialchars($pelicula['generos']) ?></li>
                                            <li><span>Año:</span> <?= htmlspecialchars($pelicula['anio'] ?? 'N/A') ?></li>
                                            <li><span>Duración:</span> <?= htmlspecialchars($pelicula['duracion'] ?? '0') ?> min</li>
                                            <li><span>Calificación:</span> <?= number_format($calificacion, 1) ?> / 10</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Director:</span> <?= htmlspecialchars($pelicula['director'] ?? 'Desconocido') ?></li>
                                            <li><span>Actores:</span> <?= htmlspecialchars($pelicula['actores']) ?></li>
                                            <li><span>Vistas:</span> <?= rand(10000, 50000) ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="anime__details__btn">
                                <a href="#" class="follow-btn"><i class="fa fa-heart-o"></i> Agregar a Favoritos</a>
                                <a href="<?php echo $pelicula['LINK']; ?>" target="_blank" class="watch-btn"><span>Ver Ahora</span> <i class="fa fa-angle-right"></i></a>                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="anime__details__review">
                        <div class="section-title">
                            <h5>Reseñas</h5>
                        </div>
                        
                        <?php if(isset($_SESSION['usuario_id'])): ?>
                        <!-- Formulario para agregar reseña -->
                        <div class="anime__review__item">
                            <div class="anime__review__item__text">
                                <h6>Agregar tu reseña</h6>
                                <form action="agregar_resena.php" method="POST">
                                    <input type="hidden" name="pelicula_id" value="<?= $pelicula['id'] ?>">
                                    <textarea name="comentario" placeholder="Escribe tu comentario..." rows="4" class="form-control mb-3" required></textarea>
                                    <button type="submit" class="site-btn">Publicar Reseña</button>
                                </form>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-info">
                            <a href="login.php">Inicia sesión</a> para dejar tu reseña.
                        </div>
                        <?php endif; ?>

                        <!-- Ejemplo de reseñas -->
                        <div class="anime__review__item">
                            <div class="anime__review__item__pic">
                                <img src="anime-main/img/anime/review-1.jpg" alt="">
                            </div>
                            <div class="anime__review__item__text">
                                <h6>Usuario123 - <span>Hace 1 hora</span></h6>
                                <p>¡Excelente película! La trama es cautivadora y las actuaciones son impecables. Totalmente recomendada.</p>
                            </div>
                        </div>
                        <div class="anime__review__item">
                            <div class="anime__review__item__pic">
                                <img src="anime-main/img/anime/review-2.jpg" alt="">
                            </div>
                            <div class="anime__review__item__text">
                                <h6>CineAmante - <span>Hace 5 horas</span></h6>
                                <p>Una obra maestra del cine. La dirección y cinematografía son de primer nivel.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="anime__details__sidebar">
                        <div class="section-title">
                            <h5>También te puede gustar</h5>
                        </div>
                        <?php foreach($peliculasRelacionadas as $relacionada): ?>
                        <a href="pelicula-detalle.php?id=<?= $relacionada['id'] ?>">
                            <div class="product__sidebar__view__item set-bg" data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($relacionada['imagen']) ?>">
                                <div class="ep"><?= htmlspecialchars($relacionada['duracion'] ?? '0') ?> min</div>
                                <div class="view"><i class="fa fa-eye"></i> <?= rand(3000, 12000) ?></div>
                                <h5 style="color: white ; font-weight: bold;"><?= htmlspecialchars($relacionada['titulo']) ?></h5>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Anime Section End -->

    <?php include 'footer.php'; ?>

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form" action="buscar.php" method="GET">
                <input type="text" name="q" id="search-input" placeholder="Buscar películas....." required>
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="anime-main/js/jquery-3.3.1.min.js"></script>
    <script src="anime-main/js/bootstrap.min.js"></script>
    <script src="anime-main/js/player.js"></script>
    <script src="anime-main/js/jquery.nice-select.min.js"></script>
    <script src="anime-main/js/mixitup.min.js"></script>
    <script src="anime-main/js/jquery.slicknav.js"></script>
    <script src="anime-main/js/owl.carousel.min.js"></script>
    <script src="anime-main/js/main.js"></script>

</body>
</html>
