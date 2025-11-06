<?php
session_start();
require_once('admin/includes/database.php');
require_once('admin/includes/crudActores.php');

// Instanciar la clase
$actoresObj = new Actores();

// Capturar la letra seleccionada desde la URL
$letraSeleccionada = isset($_GET['letra']) ? strtoupper($_GET['letra']) : null;

// Obtener actores con paginación
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$actores_por_pagina = 18;

// Obtener todos los actores
$todosLosActores = $actoresObj->getAll();

// Filtrar por letra si está seleccionada
if ($letraSeleccionada && strlen($letraSeleccionada) === 1) {
    $todosLosActores = array_filter($todosLosActores, function ($actor) use ($letraSeleccionada) {
        return strtoupper(substr($actor['nombre'], 0, 1)) === $letraSeleccionada;
    });
}

$total_actores = count($todosLosActores);
$total_paginas = ceil($total_actores / $actores_por_pagina);

// Calcular offset
$offset = ($pagina - 1) * $actores_por_pagina;

// Obtener actores de la página actual
$actoresPagina = array_slice($todosLosActores, $offset, $actores_por_pagina);

// Función auxiliar para calcular edad
function calcularEdad($fecha_nacimiento)
{
    if (!$fecha_nacimiento)
        return null;
    $nacimiento = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    return $hoy->diff($nacimiento)->y;
}

// Función para obtener iniciales del alfabeto con actores
function getLetrasDisponibles($actores)
{
    $letras = [];
    foreach ($actores as $actor) {
        $inicial = strtoupper(substr($actor['nombre'], 0, 1));
        if (!in_array($inicial, $letras)) {
            $letras[] = $inicial;
        }
    }
    sort($letras);
    return $letras;
}

$todosParaLetras = $actoresObj->getAll(); 
$letrasDisponibles = getLetrasDisponibles($todosParaLetras);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Catálogo de Actores">
    <meta name="keywords" content="Actores, cine, películas">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $letraSeleccionada ? 'Actores - ' . $letraSeleccionada : 'Catálogo de Actores' ?> - La Butaca</title>

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
    <style>
        /* TARJETAS DE ACTORES */
        .actor__item {
            margin-bottom: 30px;
        }

        .actor__item__pic {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease;
            height: 350px;
            background-size: cover;
            background-position: center top;
        }

        .actor__item__pic:hover {
            transform: scale(1.05);
        }

        .actor__item__pic::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 70%;
            background: linear-gradient(to top,
                    rgba(0, 0, 0, 0.95) 0%,
                    rgba(0, 0, 0, 0.75) 30%,
                    rgba(0, 0, 0, 0.4) 60%,
                    transparent 100%);
            pointer-events: none;
            z-index: 1;
        }

        .actor__item__text {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px 15px;
            z-index: 2;
        }

        .actor__item__text h5 {
            color: white;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.9);
        }

        .actor__item__text p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            margin: 0;
            text-shadow: 0 1px 4px rgba(0, 0, 0, 0.8);
        }

        .actor__item__text .edad {
            color: #e53637;
            font-weight: 500;
        }

        a.imagen-enlace {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 3;
        }

        /* ALFABETO SIDEBAR */
        .alfabeto-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 6px;
            margin-top: 15px;
        }

        .alfabeto-grid a {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
            color: #b7b7b7;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            transition: all 0.3s ease;
            text-decoration: none;
            min-height: 40px;
        }

        .alfabeto-grid a:hover {
            background: #e53637;
            color: white;
            transform: translateY(-2px);
        }

        .alfabeto-grid a.active {
            background: #e53637;
            color: white;
        }

        .alfabeto-grid a.disabled {
            opacity: 0.3;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* ACTORES DESTACADOS SIDEBAR */
        .actor__sidebar__item {
            cursor: pointer;
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 250px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .actor__sidebar__item:hover {
            transform: scale(1.02);
        }

        .actor__sidebar__item::after {
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

        .actor__sidebar__item h5 {
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

        /* Badge para mostrar letra seleccionada */
        .letra-badge {
            display: inline-block;
            background: #e53637;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 13px;
            margin-left: 10px;
        }

        .letra-badge .remove {
            margin-left: 8px;
            cursor: pointer;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .letra-badge .remove:hover {
            color: #ffcccc;
        }

        /* Espaciado entre secciones del sidebar */
        .product__sidebar>div {
            margin-bottom: 45px;
        }

        .product__sidebar>div:last-child {
            margin-bottom: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .alfabeto-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .actor__item__pic {
                height: 300px;
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
                        <?php if ($letraSeleccionada): ?>
                            <a href="./actores.php">Actores</a>
                            <span>Letra <?= htmlspecialchars($letraSeleccionada) ?></span>
                        <?php else: ?>
                            <span>Catálogo de Actores</span>
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
                <div class="col-lg-8">
                    <div class="product__page__content">
                        <div class="product__page__title">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-6">
                                    <div class="section-title">
                                        <h4>
                                            <?= $letraSeleccionada ? 'Actores - Letra ' . htmlspecialchars($letraSeleccionada) : 'Todos los Actores' ?>
                                            <?php if ($letraSeleccionada): ?>
                                                <span class="letra-badge">
                                                    <?= htmlspecialchars($letraSeleccionada) ?>
                                                    <a href="./actores.php" class="remove" title="Quitar filtro">✕</a>
                                                </span>
                                            <?php endif; ?>
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="product__page__filter">
                                        <p>Total: <?= $total_actores ?> actor<?= $total_actores != 1 ? 'es' : '' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Grid de Actores -->
                        <div class="row">
                            <?php
                            if (!empty($actoresPagina)):
                                foreach ($actoresPagina as $actor):
                                    $edad = calcularEdad($actor['fecha_nacimiento']);
                                    $imagenPath = !empty($actor['imagen']) ? 'imagenes/actores/' . htmlspecialchars($actor['imagen']) : 'imagenes/actores/default-actor.jpg';
                                    ?>
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="actor__item">
                                            <div class="actor__item__pic set-bg" data-setbg="<?= $imagenPath ?>">
                                                <a href="actor-detalle.php?id=<?= $actor['id'] ?>" class="imagen-enlace"></a>
                                                <div class="actor__item__text">
                                                    <h5><?= htmlspecialchars($actor['nombre']) ?></h5>
                                                    <?php if ($edad): ?>
                                                        <p><span class="edad"><?= $edad ?> años</span></p>
                                                    <?php endif; ?>
                                                </div>
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
                                        No hay actores
                                        disponibles<?= $letraSeleccionada ? ' para la letra "' . htmlspecialchars($letraSeleccionada) . '"' : '' ?>.
                                        <?php if ($letraSeleccionada): ?>
                                            <br><a href="./actores.php" class="btn btn-primary mt-3">Ver todos los actores</a>
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
                            $urlBase = './actores.php';
                            $parametros = [];
                            if ($letraSeleccionada) {
                                $parametros[] = 'letra=' . urlencode($letraSeleccionada);
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

                        <!-- Sección 1: ALFABETO -->
                        <div class="product__sidebar__view">
                            <div class="section-title">
                                <h5>Buscar por Inicial</h5>
                            </div>
                            <div class="alfabeto-grid">
                                <?php
                                $alfabeto = range('A', 'Z');
                                foreach ($alfabeto as $letra):
                                    $disponible = in_array($letra, $letrasDisponibles);
                                    $activo = ($letraSeleccionada === $letra);
                                    $clase = !$disponible ? 'disabled' : ($activo ? 'active' : '');
                                    ?>
                                    <a href="<?= $disponible ? './actores.php?letra=' . $letra : '#' ?>"
                                        class="<?= $clase ?>"
                                        title="<?= $disponible ? 'Ver actores con ' . $letra : 'No hay actores con ' . $letra ?>">
                                        <?= $letra ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Sección 2: Actores Destacados -->
                        <div class="product__sidebar__view">
                            <div class="section-title">
                                <h5>Actores Destacados</h5>
                            </div>

                            <div class="filter__gallery">
                                <?php
                                $actoresDestacados = array_slice($todosParaLetras, 0, 5);
                                if (!empty($actoresDestacados)):
                                    foreach ($actoresDestacados as $destacado):
                                        $imagenDestacado = !empty($destacado['imagen']) ? 'imagenes/actores/' . htmlspecialchars($destacado['imagen']) : 'imagenes/actores/default-actor.jpg';
                                        ?>
                                        <a href="actor-detalle.php?id=<?= $destacado['id'] ?>">
                                            <div class="actor__sidebar__item set-bg" data-setbg="<?= $imagenDestacado ?>">
                                                <h5><?= htmlspecialchars($destacado['nombre']) ?></h5>
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
                <input type="text" name="q" id="search-input" placeholder="Buscar actores.....">
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