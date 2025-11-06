<?php
session_start();
require_once('admin/includes/database.php');
require_once('admin/includes/crudPeliculas.php');
require_once('admin/includes/crudGeneros.php');
require_once('admin/includes/crudResenas.php');

// Instanciar las clases
$peliculaObj = new Peliculas();
$generosObj = new Generos();
$resenasObj = new Resenas();
$generos = $generosObj->getAll();

// Capturar el género seleccionado desde la URL
$generoSeleccionado = isset($_GET['genero']) ? $_GET['genero'] : null;

// Obtener películas con paginación
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$peliculas_por_pagina = 18;

// Obtener todas las películas o filtradas por género
if ($generoSeleccionado) {
    // Filtrar películas por género
    $todasLasPeliculas = $peliculaObj->getPeliculasPorGenero($generoSeleccionado);
} else {
    // Obtener todas las películas
    $todasLasPeliculas = $peliculaObj->getAll();
}

$total_peliculas = count($todasLasPeliculas);
$total_paginas = ceil($total_peliculas / $peliculas_por_pagina);

// Calcular offset
$offset = ($pagina - 1) * $peliculas_por_pagina;

// Obtener películas de la página actual
$peliculasPagina = array_slice($todasLasPeliculas, $offset, $peliculas_por_pagina);

// Para el sidebar - películas populares
$peliculasMasVistas = $peliculaObj->getPopulares(5);

// Función auxiliar para obtener clase de color según puntuación
function getColorClase($puntuacion)
{
    if ($puntuacion === null)
        return 'sin-valoracion';
    if ($puntuacion < 45)
        return 'valoracion-roja';
    if ($puntuacion < 70)
        return 'valoracion-amarilla';
    return 'valoracion-verde';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Catálogo de Películas">
    <meta name="keywords" content="Películas, cine, streaming">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?= $generoSeleccionado ? 'Películas de ' . htmlspecialchars($generoSeleccionado) : 'Catálogo de Películas' ?> -
        La Butaca
    </title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="anime-main/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/plyr.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/style.css" type="text/css">
    <link rel="icon" type="image/x-icon" href="./logobutaca.png">


    <!-- Estilos personalizados -->
    <!-- Estilos personalizados -->
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

        .product__item__pic>div {
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

        /* ESTILOS PARA VALORACIÓN - SIDEBAR "MÁS VISTAS" */
        .product__sidebar__view__item .valoracion-badge-sidebar {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
            border: 2px solid;
            background: rgba(0, 0, 0, 0.7);
            z-index: 3;
        }

        .product__sidebar__view__item .valoracion-badge-sidebar.valoracion-roja {
            color: #ff4444;
            border-color: #ff4444;
            background: rgba(0, 0, 0, 0.7);
        }

        .product__sidebar__view__item .valoracion-badge-sidebar.valoracion-amarilla {
            color: #ffcc00;
            border-color: #ffcc00;
            background: rgba(0, 0, 0, 0.7);
        }

        .product__sidebar__view__item .valoracion-badge-sidebar.valoracion-verde {
            color: #00ff00;
            border-color: #00ff00;
            background: rgba(0, 0, 0, 0.7);
        }

        .product__sidebar__view__item .valoracion-badge-sidebar.sin-valoracion {
            color: #999;
            border-color: #999;
            background: rgba(0, 0, 0, 0.7);
        }

        /* Contenedor de imágenes en "Más Vistas" */
        .product__sidebar__view__item {
            cursor: pointer;
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 250px;
        }

        .product__sidebar__view__item:hover {
            transform: scale(1.02);
        }

        /* Degradado negro de abajo hacia arriba */
        .product__sidebar__view__item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60%;
            background: linear-gradient(to top,
                    rgba(0, 0, 0, 0.95) 0%,
                    rgba(0, 0, 0, 0.75) 30%,
                    rgba(0, 0, 0, 0.4) 60%,
                    transparent 100%);
            pointer-events: none;
            z-index: 1;
        }

        /* Título posicionado abajo */
        .product__sidebar__view__item h5 {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 2;
            margin: 0;
            padding: 15px 12px;
            color: white !important;
            font-weight: bold !important;
            font-size: 14px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.9);
            line-height: 1.3;
        }

        /* Duración en la parte superior */
        .product__sidebar__view__item .ep {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 2;
        }

        /* Espaciado entre secciones del sidebar */
        .product__sidebar>div {
            margin-bottom: 45px;
        }

        /* Último elemento sin margen inferior */
        .product__sidebar>div:last-child {
            margin-bottom: 0;
        }

        /* GÉNEROS EN GRID - 4 columnas */
        .generos-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-top: 15px;
        }

        .generos-grid a {
            display: block;
            padding: 8px 10px;
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
            color: #b7b7b7;
            font-size: 13px;
            border-radius: 4px;
            transition: all 0.3s ease;
            text-decoration: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .generos-grid a:hover {
            background: #e53637;
            color: white;
            transform: translateY(-2px);
        }

        /* Género activo/seleccionado */
        .generos-grid a.active {
            background: #e53637;
            color: white;
            font-weight: bold;
        }

        /* ESTILOS PARA FILTROS DE TIEMPO - Botones horizontales */
        .time-filters {
            list-style: none;
            padding: 0;
            margin: 0 0 20px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .time-filters li {
            display: inline-block;
            cursor: pointer;
            padding: 8px 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            transition: all 0.3s;
            color: #b7b7b7;
            font-size: 14px;
        }

        .time-filters li:hover,
        .time-filters li.active {
            background: #e53637;
            color: white;
        }

        /* Asegurar que no haya conflictos */
        .product__sidebar__view {
            clear: both;
            overflow: hidden;
        }

        /* Badge para mostrar género seleccionado */
        .genre-badge {
            display: inline-block;
            background: #e53637;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 13px;
            margin-left: 10px;
        }

        .genre-badge .remove {
            margin-left: 8px;
            cursor: pointer;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .genre-badge .remove:hover {
            color: #ffcccc;
        }

        /* Responsive: En pantallas pequeñas, 2 columnas */
        @media (max-width: 768px) {
            .generos-grid {
                grid-template-columns: repeat(2, 1fr);
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

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                        <?php if ($generoSeleccionado): ?>
                            <a href="./peliculas.php">Películas</a>
                            <span><?= htmlspecialchars($generoSeleccionado) ?></span>
                        <?php else: ?>
                            <span>Catálogo de Películas</span>
                        <?php endif; ?>
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
                <!-- Columna Principal (Izquierda) - 8 columnas -->
                <div class="col-lg-8">
                    <div class="product__page__content">
                        <div class="product__page__title">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-6">
                                    <div class="section-title">
                                        <h4>
                                            <?= $generoSeleccionado ? 'Películas de ' . htmlspecialchars($generoSeleccionado) : 'Todas las Películas' ?>
                                            <?php if ($generoSeleccionado): ?>
                                                <span class="genre-badge">
                                                    <?= htmlspecialchars($generoSeleccionado) ?>
                                                    <a href="./peliculas.php" class="remove" title="Quitar filtro">✕</a>
                                                </span>
                                            <?php endif; ?>
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="product__page__filter">
                                        <p>Total: <?= $total_peliculas ?>
                                            película<?= $total_peliculas != 1 ? 's' : '' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Grid de Películas -->
                        <div class="row">
                            <?php
                            if (!empty($peliculasPagina)):
                                foreach ($peliculasPagina as $pelicula):
                                    // Obtener estadísticas de reseñas
                                    $estadisticas = $resenasObj->getEstadisticasPelicula($pelicula['id']);
                                    $valoracion = $estadisticas['promedio_imdb'] ? round($estadisticas['promedio_imdb']) : null;
                                    $colorClase = getColorClase($valoracion);
                                    ?>
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="product__item">
                                            <div class="product__item__pic set-bg"
                                                data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>">
                                                <a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>"
                                                    class="imagen-enlace"></a>
                                                <div class="ep"><?= htmlspecialchars($pelicula['duracion'] ?? '0') ?> min</div>
                                                <div class="comment"><i class="fa fa-calendar"></i>
                                                    <?= htmlspecialchars($pelicula['anio'] ?? 'N/A') ?>
                                                </div>

                                                <!-- VALORACIÓN ABAJO A LA DERECHA - CUADRADO SÓLIDO -->
                                                <div class="valoracion-badge <?= $colorClase ?>">
                                                    <?= $valoracion !== null ? $valoracion : 'N/A' ?>
                                                </div>
                                            </div>
                                            <div class="product__item__text">
                                                <ul>
                                                    <li>Película</li>
                                                    <?php if (!empty($pelicula['plataforma'])): ?>
                                                        <li><?= htmlspecialchars($pelicula['plataforma']) ?></li>
                                                    <?php endif; ?>
                                                </ul>
                                                <h5>
                                                    <a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>">
                                                        <?= htmlspecialchars($pelicula['titulo']) ?>
                                                    </a>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                endforeach;
                            else:
                                ?>
                                <div class="col-12">
                                    <div class="alert alert-warning text-center">
                                        <i class="fa fa-exclamation-triangle"></i>
                                        No hay películas
                                        disponibles<?= $generoSeleccionado ? ' para el género "' . htmlspecialchars($generoSeleccionado) . '"' : '' ?>.
                                        <?php if ($generoSeleccionado): ?>
                                            <br><a href="./peliculas.php" class="btn btn-primary mt-3">Ver todas las
                                                películas</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Paginación -->
                    <?php if ($total_paginas > 1): ?>
                        <div class="product__pagination">
                            <?php
                            // Construir URL base para paginación
                            $urlBase = './peliculas.php';
                            $parametros = [];
                            if ($generoSeleccionado) {
                                $parametros[] = 'genero=' . urlencode($generoSeleccionado);
                            }
                            $urlBase .= !empty($parametros) ? '?' . implode('&', $parametros) . '&pagina=' : '?pagina=';
                            ?>

                            <?php if ($pagina > 1): ?>
                                <a href="<?= $urlBase ?><?= $pagina - 1 ?>"><i class="fa fa-angle-double-left"></i></a>
                            <?php endif; ?>

                            <?php
                            // Mostrar máximo 5 páginas a la vez
                            $inicio = max(1, $pagina - 2);
                            $fin = min($total_paginas, $pagina + 2);

                            if ($inicio > 1): ?>
                                <a href="<?= $urlBase ?>1">1</a>
                                <?php if ($inicio > 2): ?>
                                    <span>...</span>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($i = $inicio; $i <= $fin; $i++): ?>
                                <a href="<?= $urlBase ?><?= $i ?>"
                                    class="<?= $i == $pagina ? 'current-page' : '' ?>"><?= $i ?></a>
                            <?php endfor; ?>

                            <?php if ($fin < $total_paginas): ?>
                                <?php if ($fin < $total_paginas - 1): ?>
                                    <span>...</span>
                                <?php endif; ?>
                                <a href="<?= $urlBase ?><?= $total_paginas ?>"><?= $total_paginas ?></a>
                            <?php endif; ?>

                            <?php if ($pagina < $total_paginas): ?>
                                <a href="<?= $urlBase ?><?= $pagina + 1 ?>"><i class="fa fa-angle-double-right"></i></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar (Derecha) - 4 columnas -->
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__sidebar">

                        <!-- Sección 1: GÉNEROS EN GRID 4 COLUMNAS -->
                        <div class="product__sidebar__view">
                            <div class="section-title">
                                <h5>Géneros</h5>
                            </div>
                            <div class="generos-grid">
                                <?php if (!empty($generos)): ?>
                                    <?php foreach ($generos as $genero): ?>
                                        <a href="./peliculas.php?genero=<?= urlencode($genero['nombre']) ?>"
                                            title="<?= htmlspecialchars($genero['nombre']) ?>"
                                            class="<?= ($generoSeleccionado == $genero['nombre']) ? 'active' : '' ?>">
                                            <?= htmlspecialchars($genero['nombre']) ?>
                                        </a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p style="grid-column: 1 / -1; text-align: center;">No hay géneros disponibles</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Sección 2: Populares -->
                        <div class="product__sidebar__view">
                            <div class="section-title">
                                <h5>Populares</h5>
                            </div>

                            <!-- Galería de películas Populares -->
                            <div class="filter__gallery">
                                <?php
                                if (!empty($peliculasMasVistas)):
                                    foreach ($peliculasMasVistas as $vista):
                                        // Obtener valoración para sidebar
                                        $estadisticasVista = $resenasObj->getEstadisticasPelicula($vista['id']);
                                        $valoracionVista = $estadisticasVista['promedio_imdb'] ? round($estadisticasVista['promedio_imdb']) : null;
                                        $colorClaseVista = getColorClase($valoracionVista);
                                        ?>
                                        <a href="pelicula-detalle.php?id=<?= $vista['id'] ?>">
                                            <div class="product__sidebar__view__item set-bg mix <?= $filterClass ?>"
                                                data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($vista['imagen']) ?>">
                                                <div class="ep"><?= htmlspecialchars($vista['duracion'] ?? '0') ?> min</div>

                                                <!-- VALORACIÓN EN SIDEBAR - ARRIBA CON BORDE -->
                                                <div class="valoracion-badge-sidebar <?= $colorClaseVista ?>">
                                                    <?= $valoracionVista !== null ? $valoracionVista : 'N/A' ?>
                                                </div>

                                                <h5>
                                                    <?= htmlspecialchars($vista['titulo']) ?>
                                                </h5>
                                            </div>
                                        </a>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Fin del Sidebar -->

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