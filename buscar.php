<?php
session_start();
require_once 'admin/includes/database.php';
require_once 'admin/includes/crudResenas.php';

// Instanciar la conexión y CRUD de reseñas
$db = new Connection();
$conn = $db->getConnection();
$resenasObj = new Resenas();

$busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';
$resultados = [];
$busqueda_wildcard = "%{$busqueda}%";

if ($busqueda !== '') {
    $stmt = $conn->prepare("SELECT * FROM peliculas WHERE titulo LIKE ? OR descripcion LIKE ?");
    $stmt->bind_param("ss", $busqueda_wildcard, $busqueda_wildcard);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $resultados[] = $row;
    }
    $stmt->close();
}
$db->closeConnection($conn);

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
    <meta name="description" content="Resultados de búsqueda">
    <meta name="keywords" content="Películas, buscar">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Buscar: <?= htmlspecialchars($busqueda) ?> - La Butaca</title>

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
                        <span>Resultados de búsqueda: "<?= htmlspecialchars($busqueda) ?>"</span>
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
                <div class="col-lg-12">
                    <div class="product__page__content">
                        <div class="product__page__title">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-6">
                                    <div class="section-title">
                                        <h4>Resultados para: "<?= htmlspecialchars($busqueda) ?>"</h4>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="product__page__filter">
                                        <p>Total: <?= count($resultados) ?> película(s)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (empty($resultados)): ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-warning text-center" style="background-color: #f0ad4e; color: #fff; padding: 30px; border-radius: 8px;">
                                        <i class="fa fa-exclamation-triangle" style="font-size: 48px; margin-bottom: 15px;"></i>
                                        <h4>No se encontraron películas</h4>
                                        <p>No hay resultados para "<?= htmlspecialchars($busqueda) ?>"</p>
                                        <a href="./index.php" class="btn btn-light mt-3">Volver al inicio</a>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <?php foreach ($resultados as $pelicula): 
                                    // Obtener estadísticas de reseñas
                                    $estadisticas = $resenasObj->getEstadisticasPelicula($pelicula['id']);
                                    $valoracion = $estadisticas['promedio_imdb'] ? round($estadisticas['promedio_imdb']) : null;
                                    $colorClase = getColorClase($valoracion);
                                ?>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item">
                                        <div class="product__item__pic set-bg" data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>">
                                            <a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>" class="imagen-enlace"></a>
                                            <div class="ep"><?= htmlspecialchars($pelicula['duracion'] ?? '0') ?> min</div>
                                            <div class="comment"><i class="fa fa-calendar"></i> <?= htmlspecialchars($pelicula['anio'] ?? 'N/A') ?></div>
                                            
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
                        <?php endif; ?>
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
                <input type="text" name="q" id="search-input" placeholder="Buscar películas....." value="<?= htmlspecialchars($busqueda) ?>">
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
