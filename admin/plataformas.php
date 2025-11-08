<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "./includes/crudPlataformas.php";

$plataformasObj = new Plataformas();
$listaPlataformas = $plataformasObj->getAll();

require_once "./includes/sessions.php";
$sesion = new Sessions();
if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}

// Verificar que el usuario sea administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";

$datosFormulario = [
    'id' => '',
    'nombre' => '',
    'descripcion' => '',
    'url' => '',
];

// Si acción editar, carga datos
if ($accion === "editar" && $id) {
    $plataformaAEditar = $plataformasObj->getPlataformaById($id);
    if ($plataformaAEditar) {
        $datosFormulario = $plataformaAEditar;
    }
}

// Procesar formularios POST (crear/editar)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errores = [];

    // VALIDACIONES
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
    $url = isset($_POST['url']) ? trim($_POST['url']) : '';

    // Validar nombre
    if (empty($nombre)) {
        $errores[] = "El nombre de la plataforma es obligatorio.";
    }

    // Si hay errores, mostrar mensaje
    if (!empty($errores)) {
        $mensaje = implode('<br>', $errores);

        // Mantener los datos introducidos para que no se pierdan al recargar
        $datosFormulario['nombre'] = $nombre;
        $datosFormulario['descripcion'] = $descripcion;
        $datosFormulario['url'] = $url;
    } else {
        // No hay errores, proceder a guardar
        if ($accion === "crear") {
            $exito = $plataformasObj->insertarPlataforma($nombre, $descripcion, $url);
            if ($exito) {
                header("Location: plataformas.php");
                exit();
            } else {
                $mensaje = "Error al insertar la plataforma. Verifica los datos.";
            }
        } elseif ($accion === "editar" && $id) {
            $exito = $plataformasObj->actualizarPlataforma($id, $nombre, $descripcion, $url);
            if ($exito) {
                header("Location: plataformas.php");
                exit();
            } else {
                $mensaje = "Error al actualizar la plataforma. Verifica los datos.";
            }
        }
    }
}

// Eliminar plataforma
if ($accion == "eliminar" && $id) {
    $eliminado = $plataformasObj->eliminarPlataforma($id);

    if ($eliminado) {
        header("Location: plataformas.php");
        exit();
    } else {
        $mensaje = "Error al eliminar la plataforma.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gestión de Plataformas - Admin">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestión de Plataformas - La Butaca Admin</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
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
        body {
            background: #0b0c2a;
            min-height: 100vh;
        }

        .admin-container {
            padding: 40px 0;
        }

        .btn-add-platform {
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

        .btn-add-platform:hover {
            background: #c20711;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(229, 9, 20, 0.4);
        }

        .platform-table-wrapper {
            background: #1a1d3a;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            overflow-x: auto;
        }

        .platform-table {
            width: 100%;
            color: #fff;
        }

        .platform-table thead {
            background: linear-gradient(135deg, #e50914 0%, #8b0000 100%);
        }

        .platform-table thead th {
            padding: 15px 10px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            border: none;
            white-space: nowrap;
        }

        .platform-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
        }

        .platform-table tbody tr:hover {
            background: rgba(229, 9, 20, 0.1);
        }

        .platform-table tbody td {
            padding: 15px 10px;
            vertical-align: middle;
            font-size: 13px;
        }

        .platform-table tbody td:first-child {
            font-weight: 600;
            color: #e50914;
        }

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

        .btn-edit {
            background: #ffa500;
        }

        .btn-edit:hover {
            background: #ff8c00;
            color: #fff;
            transform: scale(1.05);
        }

        .btn-delete {
            background: #dc3545;
        }

        .btn-delete:hover {
            background: #c82333;
            color: #fff;
            transform: scale(1.05);
        }

        .form-container {
            background: #1a1d3a;
            border-radius: 10px;
            padding: 40px;
            margin-top: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .form-container h3 {
            color: #fff;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 30px;
            border-left: 4px solid #e50914;
            padding-left: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            color: #fff;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }

        .form-control {
            background: #0b0c2a;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .form-control:focus {
            background: #0b0c2a;
            border-color: #e50914;
            color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(229, 9, 20, 0.25);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .btn-submit {
            background: #e50914;
            color: #fff;
            padding: 12px 40px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s;
            margin-right: 10px;
        }

        .btn-submit:hover {
            background: #c20711;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(229, 9, 20, 0.4);
        }

        .btn-cancel {
            background: #6c757d;
            color: #fff;
            padding: 12px 40px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cancel:hover {
            background: #5a6268;
            color: #fff;
            transform: translateY(-2px);
        }

        .alert-message {
            background: rgba(229, 9, 20, 0.2);
            border-left: 4px solid #e50914;
            color: #fff;
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .form-hint {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
            margin-top: 5px;
            font-style: italic;
        }

        .description-cell {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php include("./menu_privado.php"); ?>

    <!-- Admin Section Begin -->
    <section class="admin-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h4>Gestión de Plataformas</h4>
                    </div>

                    <?php if (!empty($mensaje)): ?>
                        <div class="alert-message">
                            <?= $mensaje ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($accion !== "crear" && $accion !== "editar"): ?>
                        <a href="plataformas.php?accion=crear" class="btn-add-platform">
                            <i class="fa fa-plus"></i> Añadir Nueva Plataforma
                        </a>

                        <div class="platform-table-wrapper">
                            <table class="platform-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>URL</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listaPlataformas as $plat): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($plat['id']) ?></td>
                                            <td><?= htmlspecialchars($plat['nombre']) ?></td>
                                            <td class="description-cell" title="<?= htmlspecialchars($plat['descripcion']) ?>">
                                                <?= htmlspecialchars($plat['descripcion']) ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($plat['url'])): ?>
                                                    <a href="<?= htmlspecialchars($plat['url']) ?>" target="_blank"
                                                        style="color: #e50914;">
                                                        <i class="fa fa-external-link"></i> Visitar
                                                    </a>
                                                <?php else: ?>
                                                    <span style="color: rgba(255,255,255,0.5);">Sin URL</span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="white-space: nowrap;">
                                                <a href="plataformas.php?accion=editar&id=<?= $plat['id'] ?>"
                                                    class="btn-action btn-edit">
                                                    <i class="fa fa-edit"></i> Editar
                                                </a>
                                                <a href="plataformas.php?accion=eliminar&id=<?= $plat['id'] ?>"
                                                    class="btn-action btn-delete"
                                                    onclick="return confirm('¿Estás seguro de eliminar esta plataforma?')">
                                                    <i class="fa fa-trash"></i> Eliminar
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <?php if ($accion === "crear" || $accion === "editar"): ?>
                        <div class="form-container">
                            <h3>
                                <?php if ($accion === "crear"): ?>
                                    <i class="fa fa-plus-circle"></i> Nueva Plataforma
                                <?php else: ?>
                                    <i class="fa fa-edit"></i> Editar: <?= htmlspecialchars($datosFormulario['nombre']) ?>
                                <?php endif; ?>
                            </h3>

                            <form method="post">
                                <div class="form-group">
                                    <label>Nombre de la Plataforma *</label>
                                    <input type="text" name="nombre" class="form-control"
                                        value="<?= htmlspecialchars($datosFormulario['nombre'] ?? '') ?>"
                                        placeholder="Ej: Netflix, HBO Max, Disney+">
                                    <small class="form-hint">El nombre debe ser único</small>
                                </div>

                                <div class="form-group">
                                    <label>Descripción</label>
                                    <textarea name="descripcion" class="form-control" rows="3"
                                        placeholder="Descripción breve de la plataforma..."><?= htmlspecialchars($datosFormulario['descripcion'] ?? '') ?></textarea>
                                    <small class="form-hint">Opcional - Describe la plataforma</small>
                                </div>

                                <div class="form-group">
                                    <label>URL</label>
                                    <input type="url" name="url" class="form-control"
                                        value="<?= htmlspecialchars($datosFormulario['url'] ?? '') ?>"
                                        placeholder="https://www.netflix.com">
                                    <small class="form-hint">Opcional - Link al sitio web oficial</small>
                                </div>

                                <div class="form-group" style="margin-top: 30px;">
                                    <button type="submit" class="btn-submit">
                                        <i class="fa fa-save"></i> Guardar Plataforma
                                    </button>
                                    <a href="plataformas.php" class="btn-cancel">
                                        <i class="fa fa-times"></i> Cancelar
                                    </a>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>
    <!-- Admin Section End -->

    <?php include("./footer_privado.php"); ?>

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
    <script src="../anime-main/js/jquery-3.3.1.min.js"></script>
    <script src="../anime-main/js/bootstrap.min.js"></script>
    <script src="../anime-main/js/player.js"></script>
    <script src="../anime-main/js/jquery.nice-select.min.js"></script>
    <script src="../anime-main/js/mixitup.min.js"></script>
    <script src="../anime-main/js/jquery.slicknav.js"></script>
    <script src="../anime-main/js/owl.carousel.min.js"></script>
    <script src="../anime-main/js/main.js"></script>
</body>

</html>