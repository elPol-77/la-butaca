<?php
session_start();
include 'admin/includes/database.php'; 
require_once 'admin/includes/crudPeliculas.php'; 

$peliculaObj = new Peliculas();
$peliculasPopulares = $peliculaObj->getPopulares(8); // Aumentamos para llenar mejor las secciones
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
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="./index.php">
                            <img src="logobutaca.png" alt="labutacalogo" width="50px">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li class="active"><a href="./index.php">Home</a></li>
                                <li><a href="./categories.php">Categorías</a></li>
                                <li><a href="#">Películas <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="./peliculas.php">Todas las Películas</a></li>
                                        <li><a href="./pelicula-detalle.php">Detalle Película</a></li>
                                    </ul>
                                </li>
                                <li><a href="./blog.php">Blog</a></li>
                                <li><a href="./contacto.php">Contacto</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right">
                        <a href="" class="search-switch"><span class="icon_search"></span></a>
                        <?php if(isset($_SESSION['usuario_id'])): ?>
                            <a href="./perfil.php"><span class="icon_profile"></span></a>
                        <?php else: ?>
                            <a href="./login.php"><span class="icon_profile"></span></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->

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
                            // Obtener las últimas películas agregadas
                            $peliculasRecientes = array_slice($peliculasPopulares, 0, 6);
                            foreach($peliculasRecientes as $pelicula): 
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>">
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
                                <div class="product__sidebar__view__item set-bg mix <?= $filter ?>" data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>">
                                    <div class="ep"><?= htmlspecialchars($pelicula['duracion'] ?? '0') ?> min</div>
                                    <div class="view"><i class="fa fa-eye"></i> <?= rand(5000, 15000) ?></div>
                                    <h5><a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>"><?= htmlspecialchars($pelicula['titulo']) ?></a></h5>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="product__sidebar__comment">
                            <div class="section__title">
                                <h5>Nuevos Comentarios</h5>
                            </div>
                            <?php foreach(array_slice($peliculasPopulares, 0, 4) as $pelicula): ?>
                            <div class="product__sidebar__comment__item">
                                <div class="product__sidebar__comment__item__pic">
                                    <img src="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>" alt="" style="width: 50px; height: 70px; object-fit: cover;">
                                </div>
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

    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="page-up">
            <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer__logo">
                        <a href="./index.php"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer__nav">
                        <ul>
                            <li class="active"><a href="./index.php">Home</a></li>
                            <li><a href="./categories.php">Categorías</a></li>
                            <li><a href="./blog.php">Blog</a></li>
                            <li><a href="./contacto.php">Contacto</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                      Copyright &copy;<script>document.write(new Date().getFullYear());</script> Todos los derechos reservados | Plantilla de <a href="https://colorlib.com" target="_blank">Colorlib</a>
                      <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Buscar películas.....">
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
