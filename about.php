<?php
session_start();
// Incluir clases para contar registros
require_once "./admin/includes/crudPeliculas.php";
require_once "./admin/includes/crudUsuarios.php";
require_once "./admin/includes/crudGeneros.php";
require_once "./admin/includes/crudValoraciones.php";



$peliculasObj = new Peliculas();
$usuariosObj = new Usuarios();
$generosObj = new Generos();

// Contar registros
$totalPeliculas = count($peliculasObj->getAll());
$totalUsuarios = count($usuariosObj->showUsuarios());
$totalGeneros = count($generosObj->getAll());

$valoracionesObj = new Valoraciones();
$totalValoraciones = count($valoracionesObj->getAll());
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Acerca de - La Butaca">
    <meta name="keywords" content="Acerca de, películas, streaming, sobre nosotros">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Acerca de - La Butaca</title>

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


    <style>
        .about-section {
            padding: 50px 0;
        }

        .about-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .about-card:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .about-card h4 {
            color: #e50914;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .about-card p {
            color: #b7b7b7;
            line-height: 1.8;
            margin-bottom: 0;
        }

        .feature-icon {
            font-size: 40px;
            color: #e50914;
            margin-bottom: 20px;
        }

        .team-member {
            text-align: center;
            margin-bottom: 30px;
        }

        .team-member img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 3px solid #e50914;
        }

        .team-member h5 {
            color: #fff;
            margin-bottom: 5px;
        }

        .team-member span {
            color: #e50914;
            font-size: 14px;
        }

        .stats-box {
            text-align: center;
            padding: 30px;
            background: linear-gradient(135deg, #e50914 0%, #c20812 100%);
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .stats-box h3 {
            color: #fff;
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stats-box p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
        }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php include 'head.php'; ?>

    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="imagenes/header.png">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Acerca de La Butaca</h2>
                        <p>Tu plataforma de descubrimiento cinematográfico</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- About Section Begin -->
    <section class="about-section spad">
        <div class="container">
            <!-- Misión y Visión -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="about-card">
                        <h4><i class="fa fa-film"></i> Nuestra Misión</h4>
                        <p>
                            La Butaca nace con el objetivo de ser tu compañero ideal en el mundo del cine.
                            Creemos que cada película cuenta una historia única y queremos ayudarte a descubrir
                            aquellas que resonarán contigo. Nuestra plataforma reúne información completa,
                            reseñas auténticas de usuarios y recomendaciones personalizadas para que encuentres
                            tu próxima película favorita.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Características -->
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="about-card text-center">
                        <div class="feature-icon">
                            <i class="fa fa-star"></i>
                        </div>
                        <h4>Reseñas Reales</h4>
                        <p>
                            Opiniones genuinas de usuarios como tú. Comparte tu experiencia y ayuda a otros
                            a encontrar grandes películas.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="about-card text-center">
                        <div class="feature-icon">
                            <i class="fa fa-search"></i>
                        </div>
                        <h4>Búsqueda Avanzada</h4>
                        <p>
                            Encuentra películas por género, director, año o actor. Nuestro sistema de filtros
                            te ayuda a descubrir exactamente lo que buscas.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="about-card text-center">
                        <div class="feature-icon">
                            <i class="fa fa-heart"></i>
                        </div>
                        <h4>Recomendaciones</h4>
                        <p>
                            Sugerencias personalizadas basadas en tus gustos y valoraciones.
                            Descubre películas similares a tus favoritas.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="row" style="margin-top: 50px;">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h4 style="text-align: center; margin-bottom: 40px;">La Butaca en Números</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stats-box">
                        <h3><i class="fa fa-film"></i></h3>
                        <h3><?= $totalPeliculas ?></h3>
                        <p>Películas en Catálogo</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-box">
                        <h3><i class="fa fa-users"></i></h3>
                        <h3><?= $totalUsuarios ?></h3>
                        <p>Usuarios Activos</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-box">
                        <h3><i class="fa fa-comments"></i></h3>
                        <h3><?= $totalValoraciones ?></h3>
                        <p>Reseñas Publicadas</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-box">
                        <h3><i class="fa fa-star"></i></h3>
                        <h3>4.8/5</h3>
                        <p>Valoración Promedio</p>
                    </div>
                </div>
            </div>

            <!-- Nuestra Historia -->
            <div class="row" style="margin-top: 50px;">
                <div class="col-lg-12">
                    <div class="about-card">
                        <h4><i class="fa fa-history"></i> Nuestra Historia</h4>
                        <p>
                            La Butaca comenzó como un proyecto de la asignatura de Servidor en 2025, impulsado por la
                            pasión por el cine
                            y el deseo de crear una comunidad donde los amantes del séptimo arte pudieran conectar.
                            Lo que empezó como una simple base de datos de películas, ha evolucionado hasta convertirse
                            en una plataforma completa con miles de usuarios que comparten su amor por el cine.
                        </p>
                        <p style="margin-top: 15px;">
                            Hoy, La Butaca es más que un simple catálogo de películas. Es un espacio donde los cinéfilos
                            pueden descubrir joyas ocultas, debatir sobre sus películas favoritas y ayudarse mutuamente
                            a encontrar su próxima gran experiencia cinematográfica.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Valores -->
            <div class="row" style="margin-top: 30px;">
                <div class="col-lg-6">
                    <div class="about-card">
                        <h4><i class="fa fa-shield"></i> Compromiso con la Calidad</h4>
                        <p>
                            Verificamos y actualizamos constantemente nuestra base de datos para ofrecerte
                            la información más precisa y actualizada sobre cada película.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-card">
                        <h4><i class="fa fa-users"></i> Comunidad Primero</h4>
                        <p>
                            Tu opinión importa. Valoramos cada reseña y trabajamos para crear un espacio
                            seguro y respetuoso para todos los amantes del cine.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="row" style="margin-top: 50px;">
                <div class="col-lg-12">
                    <div class="about-card text-center"
                        style="background: linear-gradient(135deg, #e50914 0%, #c20812 100%); border: none;">
                        <h4 style="color: #fff; margin-bottom: 20px;">¿Listo para Descubrir tu Próxima Película
                            Favorita?</h4>
                        <p style="color: rgba(255, 255, 255, 0.9); margin-bottom: 30px;">
                            Únete a nuestra comunidad de cinéfilos y comienza a explorar miles de películas.
                        </p>
                        <?php if (!isset($_SESSION['id'])): ?>
                            <a href="login.php" class="btn btn-light btn-lg" style="padding: 12px 40px; font-weight: bold;">
                                <i class="fa fa-sign-in"></i> Crear Cuenta
                            </a>
                        <?php else: ?>
                            <a href="peliculas.php" class="btn btn-light btn-lg"
                                style="padding: 12px 40px; font-weight: bold;">
                                <i class="fa fa-film"></i> Explorar Películas
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

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