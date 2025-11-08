<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "./includes/crudActores.php";
$actoresObj = new Actores();
$listaActores = $actoresObj->getAll();

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
    'fecha_nacimiento' => '',
    'biografia' => '',
    'imagen' => '',
];

// Si acción editar, carga datos
if ($accion === "editar" && $id) {
    $actorAEditar = $actoresObj->getActorById($id);
    if ($actorAEditar) {
        $datosFormulario = $actorAEditar;
    }
}

// Procesar formularios POST (crear/editar)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errores = [];

    // VALIDACIONES CON isset()
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? trim($_POST['fecha_nacimiento']) : '';
    $biografia = isset($_POST['biografia']) ? trim($_POST['biografia']) : '';

    // Validar nombre
    if (empty($nombre)) {
        $errores[] = "El nombre del actor es obligatorio.";
    }

    // Validar fecha de nacimiento
    if (empty($fecha_nacimiento)) {
        $errores[] = "La fecha de nacimiento es obligatoria.";
    }

    // Validar biografía
    if (empty($biografia)) {
        $errores[] = "La biografía es obligatoria.";
    }

    // Procesar subida de imagen
    $nombreImagen = '';
    $imagenSubidaExitosa = false;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $archivoTemporal = $_FILES['imagen']['tmp_name'];
        $nombreOriginal = $_FILES['imagen']['name'];
        $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);

        $nombreLimpio = strtolower(str_replace(' ', '', $nombre));
        $nombreLimpio = preg_replace('/[^a-z0-9]/', '', $nombreLimpio);
        $nombreImagen = $nombreLimpio . '.' . $extension;
        $rutaDestino = "../imagenes/actores/" . $nombreImagen;

        // Validar que sea imagen
        $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array(strtolower($extension), $tiposPermitidos)) {
            if (move_uploaded_file($archivoTemporal, $rutaDestino)) {
                // Imagen subida correctamente
                $imagenSubidaExitosa = true;

                if ($accion === "editar" && !empty($datosFormulario['imagen']) && $datosFormulario['imagen'] !== $nombreImagen) {
                    $rutaImagenAntigua = "../imagenes/actores/" . $datosFormulario['imagen'];
                    if (file_exists($rutaImagenAntigua)) {
                        unlink($rutaImagenAntigua);
                    }
                }
            } else {
                $errores[] = "Error al subir la imagen.";
                $nombreImagen = '';
            }
        } else {
            $errores[] = "Solo se permiten imágenes (jpg, jpeg, png, gif, webp).";
            $nombreImagen = '';
        }
    }

    // Si no se subió nueva imagen en edición, mantener la existente
    if ($accion === "editar" && !$imagenSubidaExitosa) {
        $nombreImagen = $datosFormulario['imagen'];
    }

    // Si es creación y no hay imagen
    if ($accion === "crear" && !$imagenSubidaExitosa) {
        $errores[] = "Debes seleccionar una imagen del actor.";
    }


    // Validar nombre duplicado al crear
    if ($accion === "crear") {
        $actorExistente = $actoresObj->getActorByNombre($nombre);
        if ($actorExistente) {
            $errores[] = "Ya existe un actor con el nombre '" . htmlspecialchars($nombre) . "'.";
        }
    }

    // Si hay errores, mostrar mensaje
    if (!empty($errores)) {
        $mensaje = implode('<br>', $errores);

        // Mantener los datos introducidos para no perderlos
        $datosFormulario['nombre'] = $nombre;
        $datosFormulario['fecha_nacimiento'] = $fecha_nacimiento;
        $datosFormulario['biografia'] = $biografia;
        $datosFormulario['imagen'] = $nombreImagen;
    } else {
        if ($accion === "crear" && !empty($nombreImagen)) {
            $nuevoId = $actoresObj->insertarActor($nombre, $fecha_nacimiento, $biografia, $nombreImagen);
            if ($nuevoId) {
                header("Location: actores.php");
                exit();
            } else {
                $mensaje = "Error al insertar el actor. Verifica los datos.";
            }
        } elseif ($accion === "editar" && $id) {
            $exito = $actoresObj->actualizarActor($id, $nombre, $fecha_nacimiento, $biografia, $nombreImagen);
            if ($exito) {
                header("Location: actores.php");
                exit();
            } else {
                $mensaje = "Error al actualizar el actor. Verifica los datos.";
            }
        }
    }
}

// Eliminar actor
if ($accion == "eliminar" && $id) {
    // Obtener datos del actor antes de eliminar
    $actorAEliminar = $actoresObj->getActorById($id);

    // Eliminar el actor de la base de datos
    $eliminado = $actoresObj->eliminarActor($id);

    // Si se eliminó correctamente, borrar la imagen del servidor
    if ($eliminado && !empty($actorAEliminar['imagen'])) {
        $rutaImagen = "../imagenes/actores/" . $actorAEliminar['imagen'];
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }
    }

    header("Location: actores.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gestión de Actores - Admin">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestión de Actores - La Butaca Admin</title>

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

        .btn-add-actor {
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

        .btn-add-actor:hover {
            background: #c20711;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(229, 9, 20, 0.4);
        }

        .actor-table-wrapper {
            background: #1a1d3a;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            overflow-x: auto;
        }

        .actor-table {
            width: 100%;
            color: #fff;
        }

        .actor-table thead {
            background: linear-gradient(135deg, #e50914 0%, #8b0000 100%);
        }

        .actor-table thead th {
            padding: 15px 10px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            border: none;
            white-space: nowrap;
        }

        .actor-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
        }

        .actor-table tbody tr:hover {
            background: rgba(229, 9, 20, 0.1);
        }

        .actor-table tbody td {
            padding: 15px 10px;
            vertical-align: middle;
            font-size: 13px;
        }

        .actor-table tbody td:first-child {
            font-weight: 600;
            color: #e50914;
        }

        .actor-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.5);
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

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        input[type="file"].form-control {
            cursor: pointer;
            color: #fff;
        }

        input[type="file"].form-control::file-selector-button {
            background: #e50914;
            color: #ffffff;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 15px;
            font-weight: 600;
            transition: all 0.3s;
        }

        input[type="file"].form-control::file-selector-button:hover {
            background: #c20711;
        }

        input[type="file"].form-control::-webkit-file-upload-button {
            background: #e50914;
            color: #ffffff;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        input[type="file"].form-control::-webkit-file-upload-button:hover {
            background: #c20711;
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

        .current-image-preview {
            margin-top: 10px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 5px;
        }

        .current-image-preview img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.5);
        }

        .current-image-preview p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
            margin-top: 8px;
            margin-bottom: 0;
        }

        .biografia-cell {
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
                        <h4>Gestión de Actores</h4>
                    </div>

                    <?php if (!empty($mensaje)): ?>
                        <div class="alert-message">
                            <?= $mensaje ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($accion !== "crear" && $accion !== "editar"): ?>
                        <a href="actores.php?accion=crear" class="btn-add-actor">
                            <i class="fa fa-plus"></i> Añadir Nuevo Actor
                        </a>

                        <div class="actor-table-wrapper">
                            <table class="actor-table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Fecha de Nacimiento</th>
                                        <th>Biografía</th>
                                        <th>Imagen</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listaActores as $actor): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($actor['nombre'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($actor['fecha_nacimiento'] ?? '') ?></td>
                                            <td class="biografia-cell"
                                                title="<?= htmlspecialchars($actor['biografia'] ?? '') ?>">
                                                <?= htmlspecialchars($actor['biografia'] ?? '') ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($actor['imagen'])): ?>
                                                    <img src="../imagenes/actores/<?= htmlspecialchars($actor['imagen']) ?>"
                                                        alt="<?= htmlspecialchars($actor['nombre']) ?>" class="actor-img">
                                                <?php else: ?>
                                                    <span style="color: rgba(255,255,255,0.5);">Sin imagen</span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="white-space: nowrap;">
                                                <a href="actores.php?accion=editar&id=<?= $actor['id'] ?>"
                                                    class="btn-action btn-edit">
                                                    <i class="fa fa-edit"></i> Editar
                                                </a>
                                                <a href="actores.php?accion=eliminar&id=<?= $actor['id'] ?>"
                                                    class="btn-action btn-delete"
                                                    onclick="return confirm('¿Estás seguro de eliminar este actor?')">
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
                                    <i class="fa fa-plus-circle"></i> Nuevo Actor
                                <?php else: ?>
                                    <i class="fa fa-edit"></i> Editar: <?= htmlspecialchars($datosFormulario['nombre']) ?>
                                <?php endif; ?>
                            </h3>

                            <form method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nombre Completo *</label>
                                            <input type="text" name="nombre" class="form-control"
                                                value="<?= htmlspecialchars($datosFormulario['nombre'] ?? '') ?>"
                                                placeholder="Ej: Tom Hanks">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha de Nacimiento *</label>
                                            <input type="date" name="fecha_nacimiento" class="form-control"
                                                value="<?= htmlspecialchars($datosFormulario['fecha_nacimiento'] ?? '') ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Biografía *</label>
                                    <textarea name="biografia" class="form-control"
                                        placeholder="Escribe una biografía detallada del actor..."><?= htmlspecialchars($datosFormulario['biografia'] ?? '') ?></textarea>
                                    <small class="form-hint">Incluye información relevante sobre su carrera y logros</small>
                                </div>

                                <div class="form-group">
                                    <label>Imagen del Actor *</label>
                                    <input type="file" name="imagen" class="form-control" accept="image/*">
                                    <small class="form-hint">Formatos: JPG, JPEG, PNG, GIF, WEBP</small>

                                    <?php if ($accion === "editar" && !empty($datosFormulario['imagen'])): ?>
                                        <div class="current-image-preview">
                                            <p><strong>Imagen actual:</strong></p>
                                            <img src="../imagenes/actores/<?= htmlspecialchars($datosFormulario['imagen']) ?>"
                                                alt="Imagen actual">
                                            <p><?= htmlspecialchars($datosFormulario['imagen']) ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group" style="margin-top: 30px;">
                                    <button type="submit" class="btn-submit">
                                        <i class="fa fa-save"></i> Guardar Actor
                                    </button>
                                    <a href="actores.php" class="btn-cancel">
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