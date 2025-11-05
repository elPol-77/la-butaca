<?php
session_start();
require_once 'admin/includes/database.php';
require_once 'admin/includes/crudActores.php';
require_once 'admin/includes/crudPeliculas.php';

// Verificar que se recibió el ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: actores.php");
    exit();
}

$id = (int)$_GET['id'];

// Instanciar las clases
$actorObj = new Actores();
$peliculaObj = new Peliculas();

// Obtener datos del actor
$actor = $actorObj->getActorById($id);

if (!$actor) {
    header("Location: actores.php");
    exit();
}

// Obtener películas del actor
$db = new Connection();
$conn = $db->getConnection();
$peliculas = [];
$stmt_peliculas = $conn->prepare("SELECT p.id, p.titulo, p.imagen, p.anio, p.duracion 
                                   FROM peliculas p 
                                   INNER JOIN pelicula_actor pa ON p.id = pa.pelicula_id 
                                   WHERE pa.actor_id = ? 
                                   ORDER BY p.anio DESC");
if ($stmt_peliculas) {
    $stmt_peliculas->bind_param("i", $id);
    $stmt_peliculas->execute();
    $result_peliculas = $stmt_peliculas->get_result();
    while ($row = $result_peliculas->fetch_assoc()) {
        $peliculas[] = $row;
    }
    $stmt_peliculas->close();
}
$db->closeConnection($conn);

// Función auxiliar para calcular edad
function calcularEdad($fecha_nacimiento) {
    if (!$fecha_nacimiento) return null;
    $nacimiento = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    return $hoy->diff($nacimiento)->y;
}

$edad = calcularEdad($actor['fecha_nacimiento']);

// Obtener actores aleatorios para sidebar (excluyendo el actual)
$actoresDestacados = $actorObj->getActoresAlAzarExcluyendo($id, 5);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="<?= htmlspecialchars($actor['nombre']) ?>">
    <meta name="keywords" content="Actor, cine, películas">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= htmlspecialchars($actor['nombre']) ?> - La Butaca</title>

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
        /* FOTO DEL ACTOR - Estilo similar a portada de película */
        .actor__details__pic {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .actor__details__pic img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .actor__stats {
            position: absolute;
            bottom: 15px;
            left: 15px;
            right: 15px;
            background: rgba(0, 0, 0, 0.8);
            padding: 12px 15px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .actor__stats__item {
            text-align: center;
        }

        .actor__stats__item span {
            display: block;
            color: #e53637;
            font-weight: bold;
            font-size: 1.3rem;
        }

        .actor__stats__item p {
            margin: 0;
            color: #fff;
            font-size: 0.85rem;
        }

        /* PELÍCULAS DEL ACTOR - Grid estilo catálogo */
        .actor__movies__grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .actor__movie__item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease;
            height: 220px;
            background-size: cover;
            background-position: center;
        }

        .actor__movie__item:hover {
            transform: scale(1.05);
        }

        .actor__movie__item::after {
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

        .actor__movie__info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px 10px;
            z-index: 2;
        }

        .actor__movie__info h6 {
            color: white;
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 3px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.9);
            line-height: 1.2;
        }

        .actor__movie__info p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 11px;
            margin: 0;
            text-shadow: 0 1px 4px rgba(0, 0, 0, 0.8);
        }

        .actor__movie__year {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(229, 54, 55, 0.9);
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            z-index: 2;
        }

        /* ACTORES SIDEBAR */
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

        /* INFO BOXES */
        .info-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .info-box h6 {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .info-box p {
            margin: 5px 0 0 0;
            font-size: 1.3rem;
            font-weight: bold;
        }

        .alert-custom {
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .actor__movies__grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                gap: 15px;
            }

            .actor__movie__item {
                height: 180px;
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
                        <a href="./actores.php">Actores</a>
                        <span><?= htmlspecialchars($actor['nombre']) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Actor Section Begin -->
    <section class="anime-details spad">
        <div class="container">
            <div class="anime__details__content">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="actor__details__pic">
                            <?php 
                            $imagenPath = !empty($actor['imagen']) ? 'imagenes/actores/' . htmlspecialchars($actor['imagen']) : 'imagenes/actores/default-actor.jpg';
                            ?>
                            <img src="<?= $imagenPath ?>" alt="<?= htmlspecialchars($actor['nombre']) ?>">
                        </div>
                        
                        <!-- Botón de editar solo para admin -->
                        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                        <div style="margin-top: 15px;">
                            <a href="admin/actores.php?accion=editar&id=<?= $id ?>" 
                               class="site-btn" 
                               style="width: 100%; background-color: #e36414; border: none; padding: 12px; text-align: center; display: block; border-radius: 5px; text-decoration: none; transition: all 0.3s;">
                                <i class="fa fa-edit"></i> Editar Actor
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-9">
                        <div class="anime__details__text">
                            <div class="anime__details__title">
                                <h3><?= htmlspecialchars($actor['nombre']) ?></h3>
                                <?php if ($actor['fecha_nacimiento']): ?>
                                <span>Nacido el <?= date('d/m/Y', strtotime($actor['fecha_nacimiento'])) ?></span>
                                <?php endif; ?>
                            </div>

                            <!-- Información destacada -->
                            <div class="row mt-4 mb-4">
                                <?php if ($actor['fecha_nacimiento']): ?>
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <h6><i class="fa fa-birthday-cake"></i> Fecha de Nacimiento</h6>
                                        <p><?= date('d/m/Y', strtotime($actor['fecha_nacimiento'])) ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($edad): ?>
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <h6><i class="fa fa-calendar"></i> Edad</h6>
                                        <p><?= $edad ?> años</p>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <h6><i class="fa fa-film"></i> Filmografía</h6>
                                        <p><?= count($peliculas) ?> película<?= count($peliculas) != 1 ? 's' : '' ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Biografía -->
                            <?php if (!empty($actor['biografia'])): ?>
                            <div class="anime__details__widget">
                                <h5 style="margin-bottom: 15px; color: white;"><i class="fa fa-user"></i> Biografía</h5>
                                <p style="line-height: 1.8; color: #b7b7b7;">
                                    <?= nl2br(htmlspecialchars($actor['biografia'])) ?>
                                </p>
                            </div>
                            <?php else: ?>
                            <div class="alert alert-info alert-custom">
                                <i class="fa fa-info-circle"></i> No hay biografía disponible para este actor.
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="anime__details__review">
                        <div class="section-title">
                            <h5><i class="fa fa-film"></i> Filmografía (<?= count($peliculas) ?>)</h5>
                        </div>

                        <?php if (empty($peliculas)): ?>
                        <div class="alert alert-warning alert-custom">
                            <i class="fa fa-exclamation-triangle"></i> 
                            Este actor aún no tiene películas registradas en nuestra base de datos.
                        </div>
                        <?php else: ?>
                        <div class="actor__movies__grid">
                            <?php foreach($peliculas as $pelicula): ?>
                            <a href="pelicula-detalle.php?id=<?= $pelicula['id'] ?>">
                                <div class="actor__movie__item set-bg" 
                                     data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>">
                                    <div class="actor__movie__year">
                                        <?= htmlspecialchars($pelicula['anio'] ?? 'N/A') ?>
                                    </div>
                                    <div class="actor__movie__info">
                                        <h6><?= htmlspecialchars($pelicula['titulo']) ?></h6>
                                        <p><?= htmlspecialchars($pelicula['duracion'] ?? '0') ?> min</p>
                                    </div>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4">
                    <div class="anime__details__sidebar">
                        <div class="section-title">
                            <h5>Otros Actores</h5>
                        </div>
                        <?php if (!empty($actoresDestacados)): ?>
                            <?php foreach($actoresDestacados as $destacado): 
                                $imagenDestacado = !empty($destacado['imagen']) ? 'imagenes/actores/' . htmlspecialchars($destacado['imagen']) : 'imagenes/actores/default-actor.jpg';
                            ?>
                            <a href="actor-detalle.php?id=<?= $destacado['id'] ?>">
                                <div class="actor__sidebar__item set-bg" data-setbg="<?= $imagenDestacado ?>">
                                    <h5><?= htmlspecialchars($destacado['nombre']) ?></h5>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <div class="alert alert-info alert-custom">
                            <i class="fa fa-info-circle"></i> No hay otros actores disponibles.
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Actor Section End -->

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
