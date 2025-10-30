<?php
session_start();
require_once 'admin/includes/database.php';

// Instanciar la conexión
$db = new Connection();
$conn = $db->getConnection();
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Resultados de búsqueda">
    <meta name="keywords" content="Películas, buscar">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Buscar: <?= htmlspecialchars($busqueda) ?> - MovieDB</title>

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

 <?php
  include 'head.php'; 
?>

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
                                    <div class="section__title">
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
                                <?php foreach ($resultados as $pelicula): ?>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item">
                                        <div class="product__item__pic set-bg" data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>">
                                            <div class="ep"><?= htmlspecialchars($pelicula['duracion'] ?? '0') ?> min</div>
                                            <div class="comment"><i class="fa fa-calendar"></i> <?= htmlspecialchars($pelicula['anio'] ?? 'N/A') ?></div>
                                            <div class="view"><i class="fa fa-eye"></i> <?= rand(1000, 9999) ?></div>
                                        </div>
                                        <div class="product__item__text">
                                            <ul>
                                                <li>Película</li>
                                            </ul>
                                            <h5><a href="pelicula.php?id=<?= $pelicula['id'] ?>"><?= htmlspecialchars($pelicula['titulo']) ?></a></h5>
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
                            <li><a href="./index.php">Home</a></li>
                            <li><a href="./categories.php">Categorías</a></li>
                            <li><a href="./about">About Me</a></li>
                            <li><a href="./contacto.php">Contacto</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> Todos los derechos reservados</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form" action="buscar.php" method="GET">
                <input type="text" name="q" id="search-input" placeholder="Buscar películas....." value="<?= htmlspecialchars($busqueda) ?>" required>
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
