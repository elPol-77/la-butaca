<?php
session_start();
include 'admin/includes/database.php'; 
require_once 'admin/includes/crudPeliculas.php'; 

$peliculaObj = new Peliculas();
$peliculasPopulares = $peliculaObj->getPopulares(8);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Plataforma de películas">
    <meta name="keywords" content="Películas, cine, streaming">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>La Butaca - Home</title>

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
    
    <!-- Estilos personalizados para hacer las imágenes clickeables -->
    <style>
        .product__item__pic {
            cursor: pointer;
            transition: transform 0.3s ease;
            position: relative;
        }
        
        .product__item__pic:hover {
            transform: scale(1.05);
        }
        
        a.imagen-enlace {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .product__item__pic > div {
            position: relative;
            z-index: 2;
            pointer-events: none;
        }
        
        .product__sidebar__view__item {
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .product__sidebar__view__item:hover {
            transform: scale(1.02);
        }
        
        .product__sidebar__comment__item__pic {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
<?php
  include 'head.php'; 
?>


    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="hero__slider owl-carousel">
                <?php foreach(array_slice($peliculasPopulares, 0, 3) as $pelicula): ?>
                <div class="hero__items set-bg" data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <div class="label"><?= htmlspecialchars($pelicula['genero'] ?? 'Película') ?></div>
                                <h2><?= htmlspecialchars($pelicula['titulo']) ?></h2>
                                <p><?= htmlspecialchars(substr($pelicula['descripcion'] ?? '', 0, 150)) ?>...</p>
                                <a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>"><span>Ver Ahora</span> <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Trending Now -->
                    <div class="trending__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section__title">
                                    <h4>Películas Populares</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="./peliculas.php" class="primary-btn">Ver Todas <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php foreach(array_slice($peliculasPopulares, 0, 6) as $pelicula): ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>">
                                        <a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>" class="imagen-enlace"></a>
                                        <div class="ep"><?= htmlspecialchars($pelicula['duracion'] ?? '0') ?> min</div>
                                        <div class="comment"><i class="fa fa-comments"></i> 11</div>
                                        <div class="view"><i class="fa fa-eye"></i> <?= rand(1000, 9999) ?></div>
                                    </div>
                                    <div class="product__item__text">
                                        <ul>
                                            <li>Película</li>
                                        </ul>
                                        <h5><a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>"><?= htmlspecialchars($pelicula['titulo']) ?></a></h5>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Recently Added Shows -->
                    <div class="recent__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section__title">
                                    <h4>Agregadas Recientemente</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="./peliculas.php" class="primary-btn">Ver Todas <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php 
                            $peliculasRecientes = array_slice($peliculasPopulares, 0, 6);
                            foreach($peliculasRecientes as $pelicula): 
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>">
                                        <a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>" class="imagen-enlace"></a>
                                        <div class="ep"><?= htmlspecialchars($pelicula['duracion'] ?? '0') ?> min</div>
                                        <div class="comment"><i class="fa fa-comments"></i> <?= rand(5, 50) ?></div>
                                        <div class="view"><i class="fa fa-eye"></i> <?= rand(1000, 9999) ?></div>
                                    </div>
                                    <div class="product__item__text">
                                        <ul>
                                            <li>Nueva</li>
                                            <li>Película</li>
                                        </ul>
                                        <h5><a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>"><?= htmlspecialchars($pelicula['titulo']) ?></a></h5>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__sidebar">
                        <div class="product__sidebar__view">
                            <div class="section__title">
                                <h5>Más Vistas</h5>
                            </div>
                            <ul class="filter__controls">
                                <li class="active" data-filter="*">Día</li>
                                <li data-filter=".week">Semana</li>
                                <li data-filter=".month">Mes</li>
                                <li data-filter=".years">Año</li>
                            </ul>
                            <div class="filter__gallery">
                                <?php foreach(array_slice($peliculasPopulares, 0, 5) as $index => $pelicula): 
                                    $filters = ['day', 'week', 'month', 'years'];
                                    $filter = $filters[$index % 4];
                                ?>
                                <a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>">
                                    <div class="product__sidebar__view__item set-bg mix <?= $filter ?>" data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>">
                                        <div class="ep"><?= htmlspecialchars($pelicula['duracion'] ?? '0') ?> min</div>
                                        <div class="view"><i class="fa fa-eye"></i> <?= rand(5000, 15000) ?></div>
                                        <h5><?= htmlspecialchars($pelicula['titulo']) ?></h5>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="product__sidebar__comment">
                            <div class="section__title">
                                <h5>Nuevos Comentarios</h5>
                            </div>
                            <?php foreach(array_slice($peliculasPopulares, 0, 4) as $pelicula): ?>
                            <div class="product__sidebar__comment__item">
                                <a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>">
                                    <div class="product__sidebar__comment__item__pic">
                                        <img src="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>" alt="" style="width: 50px; height: 70px; object-fit: cover;">
                                    </div>
                                </a>
                                <div class="product__sidebar__comment__item__text">
                                    <ul>
                                        <li>Activa</li>
                                        <li>Película</li>
                                    </ul>
                                    <h5><a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>"><?= htmlspecialchars($pelicula['titulo']) ?></a></h5>
                                    <span><i class="fa fa-eye"></i> <?= rand(10000, 30000) ?> Vistas</span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

<?php
  include 'footer.php'; 
?>

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
