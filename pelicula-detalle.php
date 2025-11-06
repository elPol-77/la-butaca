<?php
session_start();
require_once 'admin/includes/database.php';
require_once 'admin/includes/crudPeliculas.php';
require_once 'admin/includes/crudResenas.php';

// Verificar que se recibió el ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];

// Instanciar las clases
$peliculaObj = new Peliculas();
$resenaObj = new Resenas();

// Obtener datos de la película usando el CRUD
$pelicula = $peliculaObj->getPeliculaById($id);

if (!$pelicula) {
    header("Location: index.php");
    exit();
}

// Obtener géneros relacionados usando el CRUD
$generosArray = $peliculaObj->getNombresGenerosByPelicula($id);
$pelicula['generos'] = !empty($generosArray) ? implode(', ', $generosArray) : 'Sin género';

// Obtener actores relacionados CON IDs usando el CRUD
$actoresIds = $peliculaObj->getActoresByPelicula($id);
$actores = [];

if (!empty($actoresIds)) {
    $db = new Connection();
    $conn = $db->getConnection();
    $placeholders = implode(',', array_fill(0, count($actoresIds), '?'));
    $sql = "SELECT id, nombre FROM actores WHERE id IN ($placeholders)";
    $stmt = $conn->prepare($sql);

    // Bind dinámico para múltiples parámetros
    $types = str_repeat('i', count($actoresIds));
    $stmt->bind_param($types, ...$actoresIds);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $actores[] = $row;
    }
    $stmt->close();
    $db->closeConnection($conn);
}

// Obtener director con ID (ya viene en getPeliculaById)
$director = [
    'id' => $pelicula['director_id'] ?? null,
    'nombre' => $pelicula['director'] ?? 'Desconocido'
];

$mensaje_exito = '';
$mensaje_error = '';

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['enviar_resena'], $_POST['puntuacion_estrellas'], $_POST['puntuacion_imdb']) && 
    isset($_SESSION['id'])
) {
    $usuario_id = (int) $_SESSION['id'];
    $pelicula_id = $id;
    $puntuacion_estrellas = (int) $_POST['puntuacion_estrellas'];
    $puntuacion_imdb = (int) $_POST['puntuacion_imdb'];
    $comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : '';

    // Validación
    if (
        $puntuacion_estrellas >= 1 && $puntuacion_estrellas <= 5 &&
        $puntuacion_imdb >= 0 && $puntuacion_imdb <= 100
    ) {

        // Verificar si ya existe una reseña usando CRUD
        if ($resenaObj->usuarioYaReseño($usuario_id, $pelicula_id)) {
            // Actualizar reseña existente
            if ($resenaObj->updateResena($usuario_id, $pelicula_id, $puntuacion_estrellas, $puntuacion_imdb, $comentario)) {
                $mensaje_exito = "Tu reseña ha sido actualizada correctamente.";
            } else {
                $mensaje_error = "Error al actualizar la reseña.";
            }
        } else {
            // Insertar nueva reseña
            if ($resenaObj->insertResena($usuario_id, $pelicula_id, $puntuacion_estrellas, $puntuacion_imdb, $comentario)) {
                $mensaje_exito = "Tu reseña ha sido publicada correctamente.";
            } else {
                $mensaje_error = "Error al publicar la reseña.";
            }
        }
    } else {
        $mensaje_error = "Valores inválidos. Por favor, verifica los datos.";
    }
}

// Obtener datos de reseñas usando CRUD
$resena_usuario = null;
if (isset($_SESSION['id'])) {
    $resena_usuario = $resenaObj->getResenaUsuarioPelicula($_SESSION['id'], $id);
}

$todas_resenas = $resenaObj->getResenasPorPelicula($id);
$estadisticas = $resenaObj->getEstadisticasPelicula($id);

// Obtener películas relacionadas del mismo género
$peliculasRelacionadas = $peliculaObj->getPeliculasMismoGenero($id, 3);

// Si no hay películas del mismo género, usar populares como fallback
if (empty($peliculasRelacionadas)) {
    $peliculasRelacionadas = $peliculaObj->getPopulares(3);
}

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
    <meta name="description" content="<?= htmlspecialchars($pelicula['titulo']) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($pelicula['generos'] ?? 'Película') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= htmlspecialchars($pelicula['titulo']) ?> - La Butaca</title>

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
        /* ESTILOS PARA VALORACIÓN - BADGE SIDEBAR */
        .valoracion-badge-sidebar {
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

        .valoracion-badge-sidebar.valoracion-roja {
            color: #ff4444;
            border-color: #ff4444;
        }

        .valoracion-badge-sidebar.valoracion-amarilla {
            color: #ffcc00;
            border-color: #ffcc00;
        }

        .valoracion-badge-sidebar.valoracion-verde {
            color: #00ff00;
            border-color: #00ff00;
        }

        .valoracion-badge-sidebar.sin-valoracion {
            color: #999;
            border-color: #999;
        }

        
        .product__sidebar__view__item {
            cursor: pointer;
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 250px;
            margin-bottom: 20px;
            border-radius: 8px;
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

        /* Duración en la parte superior izquierda */
        .product__sidebar__view__item .ep {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 2;
        }

        .anime__details__sidebar {
            margin-top: 20px;
        }

        .anime__details__sidebar .section-title {
            margin-bottom: 20px;
        }

        /* Estilos para el sistema de reseñas */
        .rating-stars {
            font-size: 2rem;
            cursor: pointer;
            display: inline-block;
            margin-bottom: 15px;
        }

        .rating-stars .star {
            color: #ddd;
            transition: color 0.2s;
            cursor: pointer;
        }

        .rating-stars .star.active {
            color: #ffc107;
        }

        .rating-stars .star:hover,
        .rating-stars .star:hover~.star {
            color: #ddd;
        }

        .rating-stars .star {
            display: inline-block;
        }

        .rating-stars:hover .star {
            color: #ffc107;
        }

        .rating-stars .star:hover~.star {
            color: #ddd;
        }


        .score-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: bold;
            display: inline-block;
            margin: 10px 5px;
        }

        .user-review-form {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            border: 2px solid #e9ecef;
        }

        .review-item {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 4px solid #e50914;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .review-user {
            font-weight: bold;
            color: #e50914;
            font-size: 1.1rem;
        }

        .review-date {
            color: #999;
            font-size: 0.9rem;
        }

        .review-rating {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .stars-display {
            color: #ffc107;
        }

        .alert-custom {
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        /* Enlaces de actores y directores */
        .link-detalle {
            color: #e50914;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border-bottom: 1px solid transparent;
        }

        .link-detalle:hover {
            color: #ff0a16;
            border-bottom: 1px solid #e50914;
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
                        <a href="./peliculas.php">Películas</a>
                        <span><?= htmlspecialchars($pelicula['titulo']) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->
    <section class="anime-details spad">
        <div class="container">
            <div class="anime__details__content">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="anime__details__pic set-bg"
                            data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($pelicula['imagen']) ?>">
                            <div class="comment"><i class="fa fa-comments"></i>
                                <?= $estadisticas['total_resenas'] ?? 0 ?></div>

                            <!-- VALORACIÓN EN PORTADA PRINCIPAL -->
                            <?php
                            $valoracionPortada = $estadisticas['promedio_imdb'] ? round($estadisticas['promedio_imdb']) : null;
                            $colorClasePortada = getColorClase($valoracionPortada);
                            ?>
                            <div class="valoracion-badge-sidebar <?= $colorClasePortada ?>">
                                <?= $valoracionPortada !== null ? $valoracionPortada : 'N/A' ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="anime__details__text">
                            <div class="anime__details__title">
                                <h3><?= htmlspecialchars($pelicula['titulo']) ?></h3>
                                <span><?= htmlspecialchars($pelicula['titulo_original'] ?? $pelicula['titulo']) ?></span>
                            </div>
                            <div class="anime__details__rating">
                                <div class="rating">
                                    <?php
                                    // Usar el promedio de usuarios si existe, sino usar la calificación original
                                    $calificacion_mostrar = ($estadisticas['total_resenas'] > 0)
                                        ? ($estadisticas['promedio_imdb'] / 10)
                                        : (isset($pelicula['calificacion']) ? floatval($pelicula['calificacion']) : 0);

                                    $estrellas = $calificacion_mostrar * 5;
                                    if ($estadisticas['total_resenas'] > 0) {
                                        $estrellas = floatval($estadisticas['promedio_estrellas']);
                                    }

                                    $estrellasCompletas = floor($estrellas);
                                    $mediaEstrella = ($estrellas - $estrellasCompletas) >= 0.5;

                                    for ($i = 0; $i < $estrellasCompletas; $i++): ?>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    <?php endfor; ?>

                                    <?php if ($mediaEstrella): ?>
                                        <a href="#"><i class="fa fa-star-half-o"></i></a>
                                    <?php endif; ?>

                                    <?php for ($i = ceil($estrellas); $i < 5; $i++): ?>
                                        <a href="#"><i class="fa fa-star-o"></i></a>
                                    <?php endfor; ?>
                                </div>
                                <span>
                                    <?php if ($estadisticas['total_resenas'] > 0): ?>
                                        <?= number_format($estadisticas['promedio_imdb'], 1) ?>/100
                                        (<?= $estadisticas['total_resenas'] ?>
                                        reseña<?= $estadisticas['total_resenas'] != 1 ? 's' : '' ?>)
                                    <?php else: ?>
                                        <?= number_format($calificacion_mostrar * 10, 1) ?>/100
                                    <?php endif; ?>
                                </span>
                            </div>
                            <p><?= htmlspecialchars($pelicula['descripcion'] ?? 'Sin descripción disponible.') ?></p>
                            <div class="anime__details__widget">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Género:</span> <?= htmlspecialchars($pelicula['generos']) ?></li>
                                            <li><span>Año:</span> <?= htmlspecialchars($pelicula['anio'] ?? 'N/A') ?>
                                            </li>
                                            <li><span>Duración:</span>
                                                <?= htmlspecialchars($pelicula['duracion'] ?? '0') ?> min</li>
                                            <li><span>Calificación:</span>
                                                <?php if ($estadisticas['total_resenas'] > 0): ?>
                                                    <?= number_format($estadisticas['promedio_imdb'], 1) ?>/100
                                                <?php else: ?>
                                                    <?= number_format($calificacion_mostrar * 10, 1) ?>/100
                                                <?php endif; ?>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li>
                                                <span>Director:</span>
                                                <?php if ($director['id']): ?>
                                                    <a href="director-detalle.php?id=<?= $director['id'] ?>"
                                                        class="link-detalle">
                                                        <?= htmlspecialchars($director['nombre']) ?>
                                                    </a>
                                                <?php else: ?>
                                                    <?= htmlspecialchars($director['nombre']) ?>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <span>Actores:</span>
                                                <?php if (!empty($actores)): ?>
                                                    <?php foreach ($actores as $index => $actor): ?>
                                                        <a href="actor-detalle.php?id=<?= $actor['id'] ?>" class="link-detalle">
                                                            <?= htmlspecialchars($actor['nombre']) ?>
                                                        </a><?= $index < count($actores) - 1 ? ', ' : '' ?>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    Desconocidos
                                                <?php endif; ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="anime__details__btn">
                                <a href="<?php echo $pelicula['LINK']; ?>" target="_blank" class="watch-btn"><span>Ver
                                        Ahora</span> <i class="fa fa-angle-right"></i></a>
                                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                                    <a href="admin/peliculas.php?accion=editar&id=<?= $id ?>" class="follow-btn"
                                        style="margin-left: 10px;">
                                        <i class="fa fa-edit"></i> Editar Película
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="anime__details__review">
                        <div class="section-title">
                            <h5>Reseñas (<?= count($todas_resenas) ?>)</h5>
                        </div>

                        <!-- Mensajes de éxito/error -->
                        <?php if ($mensaje_exito): ?>
                            <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                                <i class="fa fa-check-circle"></i> <?= $mensaje_exito ?>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        <?php endif; ?>

                        <?php if ($mensaje_error): ?>
                            <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                                <i class="fa fa-exclamation-triangle"></i> <?= $mensaje_error ?>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        <?php endif; ?>

                        <!-- Formulario para agregar/editar reseña (solo usuarios logueados y con rol 'usuario') -->
                        <?php if (isset($_SESSION['id']) && isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?>
                            <div class="user-review-form">
                                <h6 style="margin-bottom: 20px; font-size: 1.3rem;">
                                    <i class="fa fa-edit"></i>
                                    <?= $resena_usuario ? 'Editar mi reseña' : 'Agregar mi reseña' ?>
                                </h6>

                                <form method="POST" id="formResena">
                                    <input type="hidden" name="enviar_resena" value="1">

                                    <div class="mb-3">
                                        <label style="font-weight: bold; margin-bottom: 10px;">
                                            <i class="fa fa-star"></i> Calificación (1-5 estrellas)
                                        </label>
                                        <div class="rating-stars" id="ratingStars">
                                            <span class="star" data-rating="1">★</span>
                                            <span class="star" data-rating="2">★</span>
                                            <span class="star" data-rating="3">★</span>
                                            <span class="star" data-rating="4">★</span>
                                            <span class="star" data-rating="5">★</span>
                                        </div>

                                        <input type="hidden" name="puntuacion_estrellas" id="puntuacionEstrellas"
                                            value="<?= $resena_usuario['puntuacion_estrellas'] ?? 0 ?>" required>
                                        <input type="hidden" name="puntuacion_imdb" id="puntuacionImdb"
                                            value="<?= $resena_usuario['puntuacion_imdb'] ?? 0 ?>">

                                        <div id="puntuacionDisplay"
                                            style="margin-top: 10px; font-size: 1.1rem; color: #e50914; font-weight: bold;">
                                            <i class="fa fa-trophy"></i> Puntuación: <span id="scoreValue">0</span>/100
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label for="comentario" style="font-weight: bold; margin-bottom: 10px;">
                                            <i class="fa fa-comment"></i> Tu opinión (opcional)
                                        </label>
                                        <textarea name="comentario" id="comentario"
                                            placeholder="Comparte tu opinión sobre esta película..." rows="5"
                                            class="form-control"><?= $resena_usuario['comentario'] ?? '' ?></textarea>
                                    </div>

                                    <button type="submit" class="site-btn">
                                        <i class="fa fa-paper-plane"></i>
                                        <?= $resena_usuario ? 'Actualizar Reseña' : 'Publicar Reseña' ?>
                                    </button>

                                    <?php if ($resena_usuario): ?>
                                        <small class="text-muted ml-3">
                                            Última actualización:
                                            <?= date('d/m/Y H:i', strtotime($resena_usuario['fecha_actualizacion'])) ?>
                                        </small>
                                    <?php endif; ?>
                                </form>
                            </div>
                        <?php elseif (!isset($_SESSION['id'])): ?>
                            <div class="alert alert-info alert-custom">
                                <i class="fa fa-info-circle"></i>
                                <a href="login.php" style="color: #0056b3; font-weight: bold;">Inicia sesión</a> para dejar
                                tu reseña.
                            </div>
                        <?php endif; ?>

                        <!-- Mostrar todas las reseñas -->
                        <?php if (empty($todas_resenas)): ?>
                            <div class="alert alert-info alert-custom">
                                <i class="fa fa-info-circle"></i>
                                Aún no hay reseñas para esta película. ¡Sé el primero en dejar una!
                            </div>
                        <?php else: ?>
                            <?php foreach ($todas_resenas as $resena): ?>
                                <div class="review-item">
                                    <div class="review-header">
                                        <div>
                                            <div class="review-user">
                                                <i class="fa fa-user-circle"></i>
                                                <?= htmlspecialchars($resena['usuario_nombre']) ?>
                                            </div>
                                            <div class="review-date">
                                                <i class="fa fa-calendar"></i>
                                                <?= date('d/m/Y H:i', strtotime($resena['fecha_creacion'])) ?>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <div class="stars-display">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i
                                                        class="fa fa-star<?= $i <= $resena['puntuacion_estrellas'] ? '' : '-o' ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="score-badge"><?= $resena['puntuacion_imdb'] ?>/100</span>
                                        </div>
                                    </div>

                                    <?php if (!empty($resena['comentario'])): ?>
                                        <p style="margin: 0; color: #555; line-height: 1.6;">
                                            <?= nl2br(htmlspecialchars($resena['comentario'])) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="anime__details__sidebar">
                        <div class="section-title">
                            <h5>También te puede gustar</h5>
                        </div>
                        <?php foreach ($peliculasRelacionadas as $relacionada):
                            // Obtener valoración para películas relacionadas
                            $estadisticasRelacionada = $resenaObj->getEstadisticasPelicula($relacionada['id']);
                            $valoracionRelacionada = $estadisticasRelacionada['promedio_imdb'] ? round($estadisticasRelacionada['promedio_imdb']) : null;
                            $colorClaseRelacionada = getColorClase($valoracionRelacionada);
                            ?>
                            <a href="pelicula-detalle.php?id=<?= $relacionada['id'] ?>">
                                <div class="product__sidebar__view__item set-bg"
                                    data-setbg="imagenes/portadas_pelis/<?= htmlspecialchars($relacionada['imagen']) ?>">
                                    <div class="ep"><?= htmlspecialchars($relacionada['duracion'] ?? '0') ?> min</div>

                                    <!-- VALORACIÓN EN "TAMBIÉN TE PUEDE GUSTAR" -->
                                    <div class="valoracion-badge-sidebar <?= $colorClaseRelacionada ?>">
                                        <?= $valoracionRelacionada !== null ? $valoracionRelacionada : 'N/A' ?>
                                    </div>

                                    <h5><?= htmlspecialchars($relacionada['titulo']) ?></h5>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Anime Section End -->

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

    <script>
        const stars = document.querySelectorAll('.star');
        const puntuacionEstrellas = document.getElementById('puntuacionEstrellas');
        const puntuacionImdb = document.getElementById('puntuacionImdb');
        const scoreValue = document.getElementById('scoreValue');

        // Cargar rating existente
        const currentRating = parseInt(puntuacionEstrellas.value) || 0;
        if (currentRating > 0) {
            updateStars(currentRating);
            updateScore(currentRating);
        }

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const rating = parseInt(this.getAttribute('data-rating'));
                puntuacionEstrellas.value = rating;
                updateStars(rating);
                updateScore(rating);
            });

            star.addEventListener('mouseenter', function () {
                const rating = parseInt(this.getAttribute('data-rating'));
                updateStars(rating);
            });
        });

        document.querySelector('.rating-stars').addEventListener('mouseleave', function () {
            const currentRating = parseInt(puntuacionEstrellas.value) || 0;
            updateStars(currentRating);
        });

        function updateStars(rating) {
            stars.forEach(star => {
                const starRating = parseInt(star.getAttribute('data-rating'));
                if (starRating <= rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }

        function updateScore(rating) {
            // Convertir estrellas (1-5) a puntuación IMDb (0-100)
            const score = rating * 20;
            puntuacionImdb.value = score;
            scoreValue.textContent = score;
        }

        document.getElementById('formResena').addEventListener('submit', function (e) {
            const rating = parseInt(puntuacionEstrellas.value);

            if (rating < 1 || rating > 5) {
                e.preventDefault();
                alert('Por favor, selecciona una calificación de 1 a 5 estrellas.');
                return false;
            }
        });

    </script>
</body>

</html>