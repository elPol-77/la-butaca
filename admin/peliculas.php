<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "./includes/crudPeliculas.php";
require_once "./includes/crudDirectores.php";
require_once "./includes/crudGeneros.php";
require_once "./includes/crudPlataformas.php";
require_once "./includes/crudActores.php";

$peliculasObj = new Peliculas();
$directoresObj = new Directores();
$generosObj = new Generos();
$plataformasObj = new Plataformas();
$actoresObj = new Actores();

$listaPeliculas = $peliculasObj->getAll();
$listaGeneros = $generosObj->getAll();
$listaPlataformas = $plataformasObj->getAll();
$listaActores = $actoresObj->showActores();

require_once "./includes/crudUsuarios.php";
$usuariosObj = new Usuarios();
$listaUsuarios = $usuariosObj->showUsuarios();

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
    'titulo' => '',
    'descripcion' => '',
    'anio' => '',
    'duracion' => '',
    'director_id' => '',
    'plataforma_id' => '',
    'imagen' => '',
    'fecha_estreno' => '',
];

$generosSeleccionados = [];
$actoresSeleccionados = [];

// Si acción editar, carga datos
if ($accion === "editar" && $id) {
    $peliculaAEditar = $peliculasObj->getPeliculaById($id);
    if ($peliculaAEditar) {
        $datosFormulario = $peliculaAEditar;
        $generosSeleccionados = $peliculasObj->getGenerosByPelicula($id);
        $actoresSeleccionados = $peliculasObj->getActoresByPelicula($id);
    }
}

// Procesar formularios POST (crear/editar)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errores = [];

    // VALIDACIONES CON isset()
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
    $anio = isset($_POST['anio']) ? trim($_POST['anio']) : '';
    $duracion = isset($_POST['duracion']) ? trim($_POST['duracion']) : '';
    $director_id = isset($_POST['director_id']) ? trim($_POST['director_id']) : '';
    $plataforma_id = isset($_POST['plataforma_id']) ? trim($_POST['plataforma_id']) : '';
    $fecha_estreno = isset($_POST['fecha_estreno']) ? trim($_POST['fecha_estreno']) : '';
    $generos = isset($_POST['generos']) ? $_POST['generos'] : [];
    $actores = isset($_POST['actores']) ? $_POST['actores'] : [];
    $link = isset($_POST['LINK']) ? $_POST['LINK'] : [];

    // Validar título
    if (empty($titulo)) {
        $errores[] = "El título es obligatorio.";
    }

    // Validar descripción
    if (empty($descripcion)) {
        $errores[] = "La descripción es obligatoria.";
    }

    // Validar año
    if (empty($anio) || !is_numeric($anio)) {
        $errores[] = "El año es obligatorio y debe ser un número válido.";
    }

    // Validar duración
    if (empty($duracion) || !is_numeric($duracion)) {
        $errores[] = "La duración es obligatoria y debe ser un número válido.";
    }

    // Validar director
    if (empty($director_id) || !is_numeric($director_id)) {
        $errores[] = "Debes seleccionar un director.";
    }

    // Validar plataforma
    if (empty($plataforma_id) || !is_numeric($plataforma_id)) {
        $errores[] = "Debes seleccionar una plataforma.";
    }

    // Validar géneros
    if (empty($generos)) {
        $errores[] = "Debes seleccionar al menos un género.";
    }

    // Validar actores
    if (empty($actores)) {
        $errores[] = "Debes seleccionar al menos un actor.";
    }

    // Validar fecha de estreno
    if (empty($fecha_estreno)) {
        $errores[] = "La fecha de estreno es obligatoria.";
    }

    // Procesar subida de imagen
    $nombreImagen = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $archivoTemporal = $_FILES['imagen']['tmp_name'];
        $nombreOriginal = $_FILES['imagen']['name'];
        $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
        
        // Crear nombre basado en título: "Pesadilla en Navidad" -> "pesadillaennavidad.jpg"
        $nombreLimpio = strtolower(str_replace(' ', '', $titulo));
        $nombreLimpio = preg_replace('/[^a-z0-9]/', '', $nombreLimpio); // Eliminar caracteres especiales
        $nombreImagen = $nombreLimpio . '.' . $extension;
        $rutaDestino = "../imagenes/portadas_pelis/" . $nombreImagen;
        
        // Validar que sea imagen
        $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array(strtolower($extension), $tiposPermitidos)) {
            if (move_uploaded_file($archivoTemporal, $rutaDestino)) {
                // Imagen subida correctamente
            } else {
                $errores[] = "Error al subir la imagen.";
                $nombreImagen = '';
            }
        } else {
            $errores[] = "Solo se permiten imágenes (jpg, jpeg, png, gif, webp).";
            $nombreImagen = '';
        }
    } else if ($accion === "editar") {
        // Si es edición y no se subió nueva imagen, mantener la existente
        $nombreImagen = $datosFormulario['imagen'];
    } else if ($accion === "crear") {
        // Si es creación y no hay imagen
        $errores[] = "Debes seleccionar una imagen de portada.";
    }
    
    // Si es edición y se subió nueva imagen, borrar la antigua
    if ($accion === "editar" && isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK && !empty($datosFormulario['imagen'])) {
        $rutaImagenAntigua = "../imagenes/portadas_pelis/" . $datosFormulario['imagen'];
        if (file_exists($rutaImagenAntigua)) {
            unlink($rutaImagenAntigua);
        }
    }

    // Si hay errores, mostrar mensaje
    if (!empty($errores)) {
        $mensaje = implode('<br>', $errores);
    } else {
        // No hay errores, proceder a guardar
        if ($accion === "crear" && !empty($nombreImagen)) {
            $nuevoId = $peliculasObj->insertarPelicula($titulo, $descripcion, $anio, $duracion, $director_id, $plataforma_id, $nombreImagen, $fecha_estreno,$link);
            if ($nuevoId) {
                $peliculasObj->asociarGeneros($nuevoId, $generos);
                $peliculasObj->asociarActores($nuevoId, $actores);
                header("Location: peliculas.php");
                exit();
            } else {
                $mensaje = "Error al insertar la película. Verifica los datos.";
            }
        } elseif ($accion === "editar" && $id) {
            $exito = $peliculasObj->actualizarPelicula($id, $titulo, $descripcion, $anio, $duracion, $director_id, $plataforma_id, $nombreImagen, $fecha_estreno,$link);
            if ($exito) {
                $peliculasObj->asociarGeneros($id, $generos);
                $peliculasObj->asociarActores($id, $actores);
                header("Location: peliculas.php");
                exit();
            } else {
                $mensaje = "Error al actualizar la película. Verifica los datos.";
            }
        }
    }
}

// Eliminar película
if ($accion == "eliminar" && $id) {
    // Obtener datos de la película antes de eliminar
    $peliculaAEliminar = $peliculasObj->getPeliculaById($id);
    
    // Eliminar la película de la base de datos
    $eliminado = $peliculasObj->eliminarPelicula($id);
    
    // Si se eliminó correctamente, borrar la imagen del servidor
    if ($eliminado && !empty($peliculaAEliminar['imagen'])) {
        $rutaImagen = "../imagenes/portadas_pelis/" . $peliculaAEliminar['imagen'];
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen); // Elimina el archivo físicamente
        }
    }
    
    header("Location: peliculas.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gestión de Películas - Admin">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestión de Películas - La Butaca Admin</title>

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

    .btn-add-movie {
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

    .btn-add-movie:hover {
        background: #c20711;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(229, 9, 20, 0.4);
    }

    .movie-table-wrapper {
        background: #1a1d3a;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        overflow-x: auto;
    }

    .movie-table {
        width: 100%;
        color: #fff;
    }

    .movie-table thead {
        background: linear-gradient(135deg, #e50914 0%, #8b0000 100%);
    }

    .movie-table thead th {
        padding: 15px 10px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        border: none;
        white-space: nowrap;
    }

    .movie-table tbody tr {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s;
    }

    .movie-table tbody tr:hover {
        background: rgba(229, 9, 20, 0.1);
    }

    .movie-table tbody td {
        padding: 15px 10px;
        vertical-align: middle;
        font-size: 13px;
    }

    .movie-table tbody td:first-child {
        font-weight: 600;
        color: #e50914;
    }

    .movie-img {
        width: 50px;
        height: 70px;
        object-fit: cover;
        border-radius: 5px;
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

    /* ESTILOS PARA SELECT - FONDO OSCURO Y TEXTO BLANCO */
    select.form-select {
        background: #0b0c2a;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        padding: 12px 15px;
        border-radius: 5px;
        transition: all 0.3s;
    }

    select.form-select:focus {
        background: #0b0c2a;
        border-color: #e50914;
        color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(229, 9, 20, 0.25);
    }

    /* OPCIONES DEL SELECT - FONDO BLANCO Y TEXTO NEGRO */
    select.form-select option {
        background-color: #ffffff;
        color: #000000;
        padding: 10px;
    }

    /* Para navegadores webkit (Chrome, Safari) */
    select.form-select option:hover {
        background-color: #e50914;
        color: #ffffff;
    }

    input[type="file"].form-control {
        cursor: pointer;
        color: #fff;
    }

    input[type="file"].form-control::file-selector-button {
        background: #e50914;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
    }

    input[type="file"].form-control::file-selector-button:hover {
        background: #c20711;
    }

    /* Para navegadores Webkit (Chrome, Safari, Edge) */
    input[type="file"].form-control::-webkit-file-upload-button {
        background: #e50914;
        color: #ffffff;
        border: none;
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

    .genre-badge {
        display: inline-block;
        background: rgba(229, 9, 20, 0.2);
        color: #e50914;
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 11px;
        margin: 2px;
    }

    /* Estilos para checkboxes de géneros y actores */
    .genre-checkboxes,
    .actor-checkboxes {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        background: #0b0c2a;
        padding: 15px;
        border-radius: 5px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        max-height: 250px;
        overflow-y: auto;
    }

    .genre-checkbox-label,
    .actor-checkbox-label {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        background: rgba(229, 9, 20, 0.1);
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s;
        border: 1px solid transparent;
    }

    .genre-checkbox-label:hover,
    .actor-checkbox-label:hover {
        background: rgba(229, 9, 20, 0.2);
        border-color: #e50914;
    }

    .genre-checkbox-label input[type="checkbox"],
    .actor-checkbox-label input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin-right: 10px;
        cursor: pointer;
        accent-color: #e50914;
    }

    .genre-checkbox-text,
    .actor-checkbox-text {
        color: #fff;
        font-size: 14px;
        user-select: none;
    }

    .genre-checkbox-label input[type="checkbox"]:checked+.genre-checkbox-text,
    .actor-checkbox-label input[type="checkbox"]:checked+.actor-checkbox-text {
        font-weight: 600;
        color: #e50914;
    }

    .current-image-preview {
        margin-top: 10px;
        padding: 10px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 5px;
    }

    .current-image-preview img {
        width: 100px;
        height: auto;
        border-radius: 5px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.5);
    }

    .current-image-preview p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 13px;
        margin-top: 8px;
        margin-bottom: 0;
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
                        <h4>Gestión de Películas</h4>
                    </div>

                    <?php if (!empty($mensaje)): ?>
                    <div class="alert-message">
                        <?= $mensaje ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($accion !== "crear" && $accion !== "editar"): ?>
                    <a href="peliculas.php?accion=crear" class="btn-add-movie">
                        <i class="fa fa-plus"></i> Añadir Nueva Película
                    </a>

                    <div class="movie-table-wrapper">
                        <table class="movie-table">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Año</th>
                                    <th>Duración</th>
                                    <th>Director</th>
                                    <th>Actores</th>
                                    <th>Géneros</th>
                                    <th>Plataforma</th>
                                    <th>Portada</th>
                                    <th>Estreno</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($listaPeliculas as $peli): ?>
                                <tr>
                                    <td><?= htmlspecialchars($peli['titulo'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($peli['anio'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($peli['duracion'] ?? '') ?> min</td>
                                    <td><?= htmlspecialchars($peli['director'] ?? '') ?></td>
                                    <td>
                                        <?php
                                                $nombresActores = $peliculasObj->getNombresActoresByPelicula($peli['id']);
                                                foreach($nombresActores as $act) {
                                                    echo '<span class="genre-badge">' . htmlspecialchars($act) . '</span>';
                                                }
                                            ?>
                                    </td>
                                    <td>
                                        <?php
                                                $nombresGeneros = $peliculasObj->getNombresGenerosByPelicula($peli['id']);
                                                foreach($nombresGeneros as $gen) {
                                                    echo '<span class="genre-badge">' . htmlspecialchars($gen) . '</span>';
                                                }
                                            ?>
                                    </td>
                                    <td><?= htmlspecialchars($peli['plataforma'] ?? '') ?></td>
                                    <td>
                                        <img src="../imagenes/portadas_pelis/<?= htmlspecialchars($peli['imagen'] ?? '') ?>"
                                            alt="<?= htmlspecialchars($peli['titulo']) ?>" class="movie-img">
                                    </td>
                                    <td><?= htmlspecialchars($peli['fecha_estreno'] ?? '') ?></td>
                                    <td style="white-space: nowrap;">
                                        <a href="peliculas.php?accion=editar&id=<?= $peli['id'] ?>"
                                            class="btn-action btn-edit">
                                            <i class="fa fa-edit"></i> Editar
                                        </a>
                                        <a href="peliculas.php?accion=eliminar&id=<?= $peli['id'] ?>"
                                            class="btn-action btn-delete"
                                            onclick="return confirm('¿Estás seguro de eliminar esta película?')">
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
                            <i class="fa fa-plus-circle"></i> Nueva Película
                            <?php else: ?>
                            <i class="fa fa-edit"></i> Editar: <?= htmlspecialchars($datosFormulario['titulo']) ?>
                            <?php endif; ?>
                        </h3>

                        <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Título *</label>
                                        <input type="text" name="titulo" class="form-control"
                                            value="<?= htmlspecialchars($datosFormulario['titulo'] ?? '') ?>"
                                            placeholder="Ej: Avatar: Fire and Ash">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Año *</label>
                                        <input type="number" name="anio" class="form-control"
                                            value="<?= htmlspecialchars($datosFormulario['anio'] ?? '') ?>"
                                            placeholder="2025" min="1900" max="2100">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Descripción *</label>
                                <textarea name="descripcion" class="form-control" rows="4"
                                    placeholder="Descripción detallada de la película..."><?= htmlspecialchars($datosFormulario['descripcion'] ?? '') ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Duración (minutos) *</label>
                                        <input type="number" name="duracion" class="form-control"
                                            value="<?= htmlspecialchars($datosFormulario['duracion'] ?? '') ?>"
                                            placeholder="120" min="1">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Director *</label>
                                        <select name="director_id" class="form-select">
                                            <option value="">Seleccionar director</option>
                                            <?php foreach($directoresObj->showDirectores() as $dir): ?>
                                            <option value="<?= $dir['id'] ?>"
                                                <?= ($datosFormulario['director_id'] ?? '') == $dir['id'] ? "selected" : "" ?>>
                                                <?= htmlspecialchars($dir['nombre']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Plataforma *</label>
                                        <select name="plataforma_id" class="form-select">
                                            <option value="">Seleccionar plataforma</option>
                                            <?php foreach($listaPlataformas as $plat): ?>
                                            <option value="<?= $plat['id'] ?>"
                                                <?= ($datosFormulario['plataforma_id'] ?? '') == $plat['id'] ? "selected" : "" ?>>
                                                <?= htmlspecialchars($plat['nombre']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Géneros *</label>
                                        <div class="genre-checkboxes">
                                            <?php foreach($listaGeneros as $g): ?>
                                            <label class="genre-checkbox-label">
                                                <input type="checkbox" name="generos[]" value="<?= $g['id'] ?>"
                                                    <?= in_array($g['id'], $generosSeleccionados ?? []) ? "checked" : "" ?>>
                                                <span
                                                    class="genre-checkbox-text"><?= htmlspecialchars($g['nombre']) ?></span>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                        <small class="form-hint">Selecciona todos los géneros que apliquen</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha de Estreno *</label>
                                        <input type="date" name="fecha_estreno" class="form-control"
                                            value="<?= htmlspecialchars($datosFormulario['fecha_estreno'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Actores *</label>
                                        <div class="actor-checkboxes">
                                            <?php foreach($listaActores as $actor): ?>
                                            <label class="actor-checkbox-label">
                                                <input type="checkbox" name="actores[]" value="<?= $actor['id'] ?>"
                                                    <?= in_array($actor['id'], $actoresSeleccionados ?? []) ? "checked" : "" ?>>
                                                <span
                                                    class="actor-checkbox-text"><?= htmlspecialchars($actor['nombre']) ?></span>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                        <small class="form-hint">Selecciona todos los actores principales</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Imagen de Portada *</label>
                                        <input type="file" name="imagen" class="form-control" accept="image/*">
                                        <small class="form-hint">Formatos: JPG, JPEG, PNG, GIF, WEBP</small>

                                        <?php if($accion === "editar" && !empty($datosFormulario['imagen'])): ?>
                                        <div class="current-image-preview">
                                            <p><strong>Imagen actual:</strong></p>
                                            <img src="../imagenes/portadas_pelis/<?= htmlspecialchars($datosFormulario['imagen']) ?>"
                                                alt="Portada actual">
                                            <p><?= htmlspecialchars($datosFormulario['imagen']) ?></p>
                                        </div>
                                        <?php endif; ?>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Link *</label>
                                                    <input type="text" name="LINK" class="form-control"
                                                        value="<?= htmlspecialchars($datosFormulario['LINK'] ?? '') ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-top: 30px;">
                                    <button type="submit" class="btn-submit">
                                        <i class="fa fa-save"></i> Guardar Película
                                    </button>
                                    <a href="peliculas.php" class="btn-cancel">
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

    <?php include("../footer.php"); ?>

    <!-- Search model Begin -->

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