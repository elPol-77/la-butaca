<?php
session_start();
include 'admin/includes/database.php'; 
require_once 'admin/includes/crudPeliculas.php'; 
require_once 'admin/includes/crudResenas.php';
require_once 'admin/includes/crudActores.php';
require_once 'admin/includes/crudDirectores.php';

$peliculaObj = new Peliculas();
$resenasObj = new Resenas();
$actorObj = new Actores();
$directorObj = new Directores();

$peliculasPopulares = $peliculaObj->getPopulares(8);

// Función auxiliar para obtener clase de color según puntuación
function getColorClase($puntuacion) {
    if ($puntuacion === null) return 'sin-valoracion';
    if ($puntuacion < 45) return 'valoracion-roja';
    if ($puntuacion < 70) return 'valoracion-amarilla';
    return 'valoracion-verde';
}
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
    
    <!-- Estilos personalizados -->
    <style>
        /* MEJORA DEL CARRUSEL HERO */
        .hero__items {
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            min-height: 500px;
            position: relative;
        }
        
        .hero__items::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, 
                rgba(0, 0, 0, 0.85) 0%, 
                rgba(0, 0, 0, 0.6) 50%, 
                rgba(0, 0, 0, 0.3) 100%);
            z-index: 1;
        }
        
        .hero__text {
            position: relative;
            z-index: 2;
        }
        
        /* GRID PRINCIPAL CON OBJECT-FIT */
        .product__item__pic {
            cursor: pointer;
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
            height: 350px;
            width: 100%;
            background: #000;
        }

        .product__item__pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            display: block;
        }
        
        .product__item__pic:hover {
            transform: scale(1.05);
        }
        
        .product__item__pic a.imagen-enlace {
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
        }
        
        /* ESTILOS PARA VALORACIÓN - GRID PRINCIPAL */
        .valoracion-badge {
            position: absolute !important;
            bottom: 10px !important;
            right: 10px !important;
            width: 50px !important;
            height: 50px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-weight: bold !important;
            font-size: 18px !important;
            border-radius: 6px !important;
            z-index: 999 !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4) !important;
            pointer-events: none !important;
        }

        .valoracion-roja {
            background-color: #e74c3c !important;
            color: white !important;
        }

        .valoracion-amarilla {
            background-color: #f39c12 !important;
            color: white !important;
        }

        .valoracion-verde {
            background-color: #27ae60 !important;
            color: white !important;
        }

        .sin-valoracion {
            background-color: #95a5a6 !important;
            color: white !important;
        }

        /* SIDEBAR CON OBJECT-FIT */
        .product__sidebar__view__item {
            cursor: pointer;
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
            height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            margin-bottom: 20px;
            border-radius: 8px;
            background: #000;
        }

        .product__sidebar__view__item img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
            display: block;
            z-index: 0;
        }
        
        .product__sidebar__view__item:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        
        /* Degradado para mejor legibilidad del título en sidebar */
        .product__sidebar__view__item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 70%;
            background: linear-gradient(to top,
                rgba(0, 0, 0, 0.95) 0%,
                rgba(0, 0, 0, 0.7) 40%,
                rgba(0, 0, 0, 0.3) 70%,
                transparent 100%);
            pointer-events: none;
            z-index: 1;
        }
        
        /* Título del sidebar mejor posicionado */
        .product__sidebar__view__item h5 {
            position: relative;
            z-index: 2;
            margin: 0;
            padding: 15px 12px;
            color: white !important;
            font-weight: bold !important;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.9);
            line-height: 1.3;
            font-size: 15px;
        }
        
        /* Duración en sidebar */
        .product__sidebar__view__item .ep {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 3;
        }

        /* ESTILOS PARA VALORACIÓN - SIDEBAR */
        .product__sidebar__view__item .valoracion-badge-sidebar {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
            border: 2px solid;
            background: rgba(0, 0, 0, 0.8);
            z-index: 3;
        }

        .product__sidebar__view__item .valoracion-badge-sidebar.valoracion-roja {
            color: #ff4444;
            border-color: #ff4444;
        }

        .product__sidebar__view__item .valoracion-badge-sidebar.valoracion-amarilla {
            color: #ffcc00;
            border-color: #ffcc00;
        }

        .product__sidebar__view__item .valoracion-badge-sidebar.valoracion-verde {
            color: #00ff00;
            border-color: #00ff00;
        }

        .product__sidebar__view__item .valoracion-badge-sidebar.sin-valoracion {
            color: #999;
            border-color: #999;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .product__item__pic {
                height: 300px;
            }
            
            .product__sidebar__view__item {
                height: 180px;
            }
            
            .hero__items {
                min-height: 400px;
            }
        }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
<?php include 'head.php'; ?>

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
                                <div class="section-title">
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
                            <?php foreach(array_slice($peliculasPopulares, 0, 6) as $pelicula): 
                                $estadisticas = $resenasObj->getEstadisticasPelicula($pelicula['id']);
                                $valoracion = $estadisticas['promedio_imdb'] ? round($estadisticas['promedio_imdb']) : null;
                                $colorClase = getColorClase($valoracion);
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic">
                                        <img src="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>" 
                                             alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
                                        <a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>" class="imagen-enlace"></a>
                                        <div class="ep"><?= htmlspecialchars($pelicula['duracion'] ?? '0') ?> min</div>
                                        <div class="comment"><i class="fa fa-comments"></i> <?= $estadisticas['total_resenas'] ?? 0 ?></div>
                                        
                                        <!-- VALORACIÓN -->
                                        <div class="valoracion-badge <?= $colorClase ?>">
                                            <?= $valoracion !== null ? $valoracion : 'N/A' ?>
                                        </div>
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

                    <!-- Actores Destacados -->
                    <div class="recent__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Actores Destacados</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="./actores.php" class="primary-btn">Ver Todos <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php 
                            $actoresAleatorios = $actorObj->getActoresAlAzar(6);
                            foreach($actoresAleatorios as $actor): 
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic">
                                        <img src="imagenes/actores/<?= htmlspecialchars($actor['imagen'] ?? 'default-actor.jpg') ?>" 
                                             alt="<?= htmlspecialchars($actor['nombre']) ?>">
                                        <a href="actor-detalle.php?id=<?= $actor['id'] ?>" class="imagen-enlace"></a>
                                    </div>
                                    <div class="product__item__text">
                                        <ul>
                                            <li>Actor</li>
                                        </ul>
                                        <h5><a href="actor-detalle.php?id=<?= $actor['id'] ?>"><?= htmlspecialchars($actor['nombre']) ?></a></h5>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Directores Destacados -->
                    <div class="recent__product" style="margin-top: 40px;">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Directores Destacados</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="./directores.php" class="primary-btn">Ver Todos <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php 
                            $directoresAleatorios = $directorObj->getDirectoresAlAzar(6);
                            foreach($directoresAleatorios as $director): 
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic">
                                        <img src="imagenes/directores/<?= htmlspecialchars($director['imagen'] ?? 'default-director.jpg') ?>" 
                                             alt="<?= htmlspecialchars($director['nombre']) ?>">
                                        <a href="director-detalle.php?id=<?= $director['id'] ?>" class="imagen-enlace"></a>
                                    </div>
                                    <div class="product__item__text">
                                        <ul>
                                            <li>Director</li>
                                        </ul>
                                        <h5><a href="director-detalle.php?id=<?= $director['id'] ?>"><?= htmlspecialchars($director['nombre']) ?></a></h5>
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
                            <div class="section-title">
                                <h5>Recomendaciones</h5>
                            </div>
                            <div class="filter__gallery">
                                <?php 
                                $peliculasAzar = $peliculaObj->getPeliculasAlAzar(5);
                                foreach($peliculasAzar as $pelicula): 
                                    $estadisticasVista = $resenasObj->getEstadisticasPelicula($pelicula['id']);
                                    $valoracionVista = $estadisticasVista['promedio_imdb'] ? round($estadisticasVista['promedio_imdb']) : null;
                                    $colorClaseVista = getColorClase($valoracionVista);
                                ?>
                                <a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>">
                                    <div class="product__sidebar__view__item">
                                        <img src="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>" 
                                             alt="<?= htmlspecialchars($pelicula['titulo']) ?>">
                                        <div class="ep"><?= htmlspecialchars($pelicula['duracion'] ?? '0') ?> min</div>
                                        
                                        <!-- VALORACIÓN EN SIDEBAR -->
                                        <div class="valoracion-badge-sidebar <?= $colorClaseVista ?>">
                                            <?= $valoracionVista !== null ? $valoracionVista : 'N/A' ?>
                                        </div>
                                        
                                        <h5><?= htmlspecialchars($pelicula['titulo']) ?></h5>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

<?php include 'footer.php'; ?>

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form" action="buscar.php" method="GET">
                <input type="text" name="q" id="search-input" placeholder="Buscar películas.....">
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
