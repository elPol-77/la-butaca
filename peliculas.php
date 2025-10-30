<?php
session_start();
require_once('admin/includes/database.php');
require_once('admin/includes/crudPeliculas.php');

// Instanciar la clase Peliculas
$peliculaObj = new Peliculas();

// Obtener películas con paginación
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$peliculas_por_pagina = 18;

// Para la paginación, necesitamos obtener todas y luego paginarlas
$todasLasPeliculas = $peliculaObj->getAll();
$total_peliculas = count($todasLasPeliculas);
$total_paginas = ceil($total_peliculas / $peliculas_por_pagina);

// Calcular offset
$offset = ($pagina - 1) * $peliculas_por_pagina;

// Obtener películas de la página actual
$peliculasPagina = array_slice($todasLasPeliculas, $offset, $peliculas_por_pagina);

// Para el sidebar - películas populares
$peliculasMasVistas = $peliculaObj->getPopulares(5);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Catálogo de Películas">
    <meta name="keywords" content="Películas, cine, streaming">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Catálogo de Películas - La Butaca</title>

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
    
    <!-- Estilos para hacer las imágenes clickeables -->
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
    </style>
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
                        <span>Catálogo de Películas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Section Begin -->
    <section class="product-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="product__page__content">
                        <div class="product__page__title">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-6">
                                    <div class="section-title">
                                        <h4>Todas las Películas</h4>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="product__page__filter">
                                        <p>Total: <?= $total_peliculas ?> películas</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php 
                            if(!empty($peliculasPagina)):
                                foreach($peliculasPagina as $pelicula): 
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>">
                                        <a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>" class="imagen-enlace"></a>
                                        <div class="ep"><?= htmlspecialchars($pelicula['duracion'] ?? '0') ?> min</div>
                                        <div class="comment"><i class="fa fa-calendar"></i> <?= htmlspecialchars($pelicula['anio'] ?? 'N/A') ?></div>
                                        <div class="view"><i class="fa fa-eye"></i> <?= rand(1000, 9999) ?></div>
                                    </div>
                                    <div class="product__item__text">
                                        <ul>
                                            <li>Película</li>
                                            <?php if(!empty($pelicula['plataforma'])): ?>
                                            <li><?= htmlspecialchars($pelicula['plataforma']) ?></li>
                                            <?php endif; ?>
                                        </ul>
                                        <h5><a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>"><?= htmlspecialchars($pelicula['titulo']) ?></a></h5>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                endforeach;
                            else:
                            ?>
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    No hay películas disponibles en este momento.
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Paginación -->
                    <?php if($total_paginas > 1): ?>
                    <div class="product__pagination">
                        <?php if($pagina > 1): ?>
                            <a href="?pagina=<?= $pagina - 1 ?>"><i class="fa fa-angle-double-left"></i></a>
                        <?php endif; ?>
                        
                        <?php 
                        // Mostrar máximo 5 páginas a la vez
                        $inicio = max(1, $pagina - 2);
                        $fin = min($total_paginas, $pagina + 2);
                        
                        if($inicio > 1): ?>
                            <a href="?pagina=1">1</a>
                            <?php if($inicio > 2): ?>
                                <span>...</span>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php for($i = $inicio; $i <= $fin; $i++): ?>
                            <a href="?pagina=<?= $i ?>" class="<?= $i == $pagina ? 'current-page' : '' ?>"><?= $i ?></a>
                        <?php endfor; ?>
                        
                        <?php if($fin < $total_paginas): ?>
                            <?php if($fin < $total_paginas - 1): ?>
                                <span>...</span>
                            <?php endif; ?>
                            <a href="?pagina=<?= $total_paginas ?>"><?= $total_paginas ?></a>
                        <?php endif; ?>
                        
                        <?php if($pagina < $total_paginas): ?>
                            <a href="?pagina=<?= $pagina + 1 ?>"><i class="fa fa-angle-double-right"></i></a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__sidebar">
                        <div class="product__sidebar__view">
                            <div class="section-title">
                                <h5>Más Vistas</h5>
                            </div>
                            <ul class="filter__controls">
                                <li class="active" data-filter="*">Día</li>
                                <li data-filter=".week">Semana</li>
                                <li data-filter=".month">Mes</li>
                                <li data-filter=".years">Año</li>
                            </ul>
                            <div class="filter__gallery">
                                <?php 
                                if(!empty($peliculasMasVistas)):
                                    $filters = ['day', 'week', 'month', 'years', 'day'];
                                    $index = 0;
                                    foreach($peliculasMasVistas as $vista): 
                                ?>
                                <a href="pelicula-detalle.php?id=<?= $vista['id'] ?>">
                                    <div class="product__sidebar__view__item set-bg mix <?= $filters[$index] ?>" data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($vista['imagen']) ?>">
                                        <div class="ep"><?= htmlspecialchars($vista['duracion'] ?? '0') ?> min</div>
                                        <div class="view"><i class="fa fa-eye"></i> <?= rand(5000, 15000) ?></div>
                                        <h5><?= htmlspecialchars($vista['titulo']) ?></h5>
                                    </div>
                                </a>
                                <?php 
                                    $index++;
                                    endforeach;
                                endif; 
                                ?>
                            </div>
                        </div>
                        
                        <div class="product__sidebar__comment">
                            <div class="section-title">
                                <h5>Comentarios Recientes</h5>
                            </div>
                            <?php 
                            $count = 0;
                            foreach($peliculasMasVistas as $comentario): 
                                if($count >= 4) break;
                            ?>
                            <div class="product__sidebar__comment__item">
                                <a href="pelicula-detalle.php?id=<?= $comentario['id'] ?>">
                                    <div class="product__sidebar__comment__item__pic">
                                        <img src="imagenes/portadas_pelis/<?= htmlspecialchars($comentario['imagen']) ?>" alt="" style="width: 50px; height: 70px; object-fit: cover;">
                                    </div>
                                </a>
                                <div class="product__sidebar__comment__item__text">
                                    <ul>
                                        <li>Activa</li>
                                        <li>Película</li>
                                    </ul>
                                    <h5><a href="pelicula-detalle.php?id=<?= $comentario['id'] ?>"><?= htmlspecialchars($comentario['titulo']) ?></a></h5>
                                    <span><i class="fa fa-eye"></i> <?= rand(10000, 30000) ?> Vistas</span>
                                </div>
                            </div>
                            <?php 
                                $count++;
                            endforeach; 
                            ?>
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
