<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "./includes/crudGeneros.php";
$generosObj = new Generos();
$listaGeneros = $generosObj->getAll();

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
];

// Si acción editar, carga datos
if ($accion === "editar" && $id) {
    $generoAEditar = $generosObj->getGeneroById($id);
    if ($generoAEditar) {
        $datosFormulario = $generoAEditar;
    }
}

// Procesar formularios POST (crear/editar)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errores = [];

    // VALIDACIONES CON isset()
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';

    // Validar nombre
    if (empty($nombre)) {
        $errores[] = "El nombre del género es obligatorio.";
    }

    // Validar nombre duplicado al crear
    if ($accion === "crear") {
        $generoExistente = $generosObj->getGeneroByNombre($nombre);
        if ($generoExistente) {
            $errores[] = "Ya existe un género con el nombre '" . htmlspecialchars($nombre) . "'.";
        }
    }

    // Si hay errores, mostrar mensaje
    if (!empty($errores)) {
        $mensaje = implode('<br>', $errores);
    } else {
        // No hay errores, proceder a guardar
        if ($accion === "crear") {
            $nuevoId = $generosObj->insertarGenero($nombre);
            if ($nuevoId) {
                header("Location: generos.php");
                exit();
            } else {
                $mensaje = "Error al insertar el género. Verifica los datos.";
            }
        } elseif ($accion === "editar" && $id) {
            $exito = $generosObj->actualizarGenero($id, $nombre);
            if ($exito) {
                header("Location: generos.php");
                exit();
            } else {
                $mensaje = "Error al actualizar el género. Verifica los datos.";
            }
        }
    }
}

// Eliminar género
if ($accion == "eliminar" && $id) {
    // Obtener datos del género antes de eliminar
    $generoAEliminar = $generosObj->getGeneroById($id);
    
    // Intentar eliminar el género de la base de datos
    $eliminado = $generosObj->eliminarGenero($id);
    
    if ($eliminado) {
        header("Location: generos.php");
        exit();
    } else {
        // No se pudo eliminar porque tiene películas asociadas
        $mensaje = "No se puede eliminar el género '" . htmlspecialchars($generoAEliminar['nombre']) . "' porque tiene películas asociadas. Primero elimina o reasigna sus películas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gestión de Géneros - Admin">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestión de Géneros - La Butaca Admin</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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

        .btn-add-genero {
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

        .btn-add-genero:hover {
            background: #c20711;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(229, 9, 20, 0.4);
        }

        .genero-table-wrapper {
            background: #1a1d3a;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            overflow-x: auto;
        }

        .genero-table {
            width: 100%;
            color: #fff;
        }

        .genero-table thead {
            background: linear-gradient(135deg, #e50914 0%, #8b0000 100%);
        }

        .genero-table thead th {
            padding: 15px 10px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            border: none;
            white-space: nowrap;
        }

        .genero-table tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s;
        }

        .genero-table tbody tr:hover {
            background: rgba(229, 9, 20, 0.1);
        }

        .genero-table tbody td {
            padding: 15px 10px;
            vertical-align: middle;
            font-size: 13px;
        }

        .genero-table tbody td:first-child {
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
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
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
            border: 1px solid rgba(255,255,255,0.2);
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
            color: rgba(255,255,255,0.5);
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
            color: rgba(255,255,255,0.6);
            font-size: 12px;
            margin-top: 5px;
            font-style: italic;
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
                        <h4>Gestión de Géneros</h4>
                    </div>

                    <?php if (!empty($mensaje)): ?>
                        <div class="alert-message">
                            <?= $mensaje ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($accion !== "crear" && $accion !== "editar"): ?>
                        <a href="generos.php?accion=crear" class="btn-add-genero">
                            <i class="fa fa-plus"></i> Añadir Nuevo Género
                        </a>

                        <div class="genero-table-wrapper">
                            <table class="genero-table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($listaGeneros as $genero): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($genero['nombre'] ?? '') ?></td>
                                        <td style="white-space: nowrap;">
                                            <a href="generos.php?accion=editar&id=<?= $genero['id'] ?>" class="btn-action btn-edit">
                                                <i class="fa fa-edit"></i> Editar
                                            </a>
                                            <a href="generos.php?accion=eliminar&id=<?= $genero['id'] ?>" 
                                               class="btn-action btn-delete" 
                                               onclick="return confirm('¿Estás seguro de eliminar este género?')">
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
                                <?php if($accion === "crear"): ?>
                                    <i class="fa fa-plus-circle"></i> Nuevo Género
                                <?php else: ?>
                                    <i class="fa fa-edit"></i> Editar: <?= htmlspecialchars($datosFormulario['nombre']) ?>
                                <?php endif; ?>
                            </h3>
                            
                            <form method="post">
                                <div class="form-group">
                                    <label>Nombre del Género *</label>
                                    <input type="text" name="nombre" class="form-control" 
                                           value="<?= htmlspecialchars($datosFormulario['nombre'] ?? '') ?>" 
                                           placeholder="Ej: Acción, Drama, Comedia...">
                                    <small class="form-hint">El nombre debe ser único y descriptivo</small>
                                </div>

                                <div class="form-group" style="margin-top: 30px;">
                                    <button type="submit" class="btn-submit">
                                        <i class="fa fa-save"></i> Guardar Género
                                    </button>
                                    <a href="generos.php" class="btn-cancel">
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
