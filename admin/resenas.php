<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "./includes/crudResenas.php";
require_once "./includes/sessions.php";

$sesion = new Sessions();
if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$resenasObj = new Resenas();

$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";

if ($accion === 'eliminar' && $id) {
    $eliminado = $resenasObj->deleteResena($id);
    if ($eliminado) {
        header("Location: resenas.php");
        exit();
    } else {
        $mensaje = "Error al eliminar la reseña.";
    }
}

$listaResenas = $resenasObj->showResenas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gestión de Reseñas - Admin">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestión de Reseñas - La Butaca Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../anime-main/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../anime-main/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../anime-main/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="../anime-main/css/plyr.css" type="text/css">
    <link rel="stylesheet" href="../anime-main/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="../anime-main/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="../anime-main/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="../anime-main/css/style.css" type="text/css">
    <link rel="icon" type="image/x-icon" href="../logobutaca.png">
    <style>
        body {background: #0b0c2a; min-height: 100vh;}
        .admin-container {padding: 40px 0;}
        .btn-add-resena {
            background: #e50914;
            color: #fff;
            padding: 12px 30px;
            border-radius: 5px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 30px;
            transition: all 0.3s;
        }
        .btn-add-resena:hover {
            background: #c20711;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(229, 9, 20, 0.4);
        }
        .resena-table-wrapper {
            background: #1a1d3a;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            overflow-x: auto;
        }
        .resena-table {
            width: 100%;
            color: #fff;
        }
        .resena-table thead {
            background: linear-gradient(135deg, #e50914 0%, #8b0000 100%);
        }
        .resena-table thead th {
            padding: 15px 10px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            border: none;
            white-space: nowrap;
        }
        .resena-table tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s;
        }
        .resena-table tbody tr:hover {
            background: rgba(229, 9, 20, 0.08);
        }
        .resena-table tbody td {
            padding: 15px 10px;
            vertical-align: middle;
            font-size: 13px;
        }
        .resena-table tbody td:first-child {font-weight: 600; color: #e50914;}
        .btn-action {
            padding: 6px 12px;
            margin: 2px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s;
            display: inline-block;
            color: #fff;
        }
        .btn-delete {
            background: #dc3545;
        }
        .btn-delete:hover {
            background: #c82333;
            color: #fff;
            transform: scale(1.05);
        }
        .alert-message {
            background: rgba(229, 9, 20, 0.2);
            border-left: 4px solid #e50914;
            color: #fff;
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .comentario-cell {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div id="preloder"><div class="loader"></div></div>
    <?php include("./menu_privado.php"); ?>

    <section class="admin-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h4>Gestión de Reseñas</h4>
                    </div>
                    <?php if (!empty($mensaje)): ?>
                        <div class="alert-message">
                            <?= $mensaje ?>
                        </div>
                    <?php endif; ?>
                    <div class="resena-table-wrapper">
                        <table class="resena-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Película</th>
                                    <th>Usuario</th>
                                    <th>Puntuación Estrellas</th>
                                    <th>Puntuación IMDb</th>
                                    <th>Comentario</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listaResenas as $resena): ?>
                                <tr>
                                    <td><?= htmlspecialchars($resena['id'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($resena['titulo_pelicula'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($resena['username'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($resena['puntuacion_estrellas'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($resena['puntuacion_imdb'] ?? '') ?></td>
                                    <td class="comentario-cell" title="<?= htmlspecialchars($resena['comentario'] ?? '') ?>">
                                        <?= htmlspecialchars($resena['comentario'] ?? '') ?>
                                    </td>
                                    <td><?= htmlspecialchars($resena['fecha_creacion'] ?? '') ?></td>
                                    <td style="white-space: nowrap;">
                                        <a href="resenas.php?accion=eliminar&id=<?= $resena['id'] ?>"
                                           class="btn-action btn-delete"
                                           onclick="return confirm('¿Estás seguro de eliminar esta reseña?')">
                                            <i class="fa fa-trash"></i> Eliminar
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include("./footer_privado.php"); ?>
    <script src="../anime-main/js/jquery-3.3.1.min.js"></script>
    <script src="../anime-main/js/bootstrap.min.js"></script>
    <script src="../anime-main/js/main.js"></script>
</body>
</html>