<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "./includes/crudPeliculas.php";
require_once "./includes/crudDirectores.php";
$peliculasObj = new Peliculas();
$directoresObj = new Directores();
$listaPeliculas = $peliculasObj->getAll();

require_once "./includes/sessions.php";
$sesion = new Sessions();
if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
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
    'imagen_id' => '',
    'fecha_estreno' => '',
];

// Si acción editar, carga datos
if ($accion === "editar" && $id) {
    $peliculaAEditar = $peliculasObj->getPeliculaById($id);
    if ($peliculaAEditar) {
        $datosFormulario = $peliculaAEditar;
    }
}

// Procesar formularios POST (crear/editar)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $anio = $_POST['anio'] ?? '';
    $duracion = $_POST['duracion'] ?? '';
    $director_id = $_POST['director_id'] ?? '';
    $imagen_id = $_POST['imagen_id'] ?? '';
    $fecha_estreno = $_POST['fecha_estreno'] ?? '';

    if ($accion === "crear") {
        $peliculasObj->insertarPelicula($titulo, $descripcion, $anio, $duracion, $director_id, $imagen_id, $fecha_estreno, '');
        header("Location: peliculas.php");
        exit();
    } elseif ($accion === "editar" && $id) {
        $peliculasObj->actualizarPelicula($id, $titulo, $descripcion, $anio, $duracion, $director_id, $imagen_id, $fecha_estreno, '');
        header("Location: peliculas.php");
        exit();
    }
}

// Eliminar película
if ($accion == "eliminar" && $id) {
    $peliculasObj->eliminarPelicula($id);
    $mensaje = "Película eliminada correctamente.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Películas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../logo.png">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body class="bg-white text-dark">
    <?php include("./menu_privado.php"); ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <main class="col-md-10">
                <div class="card shadow-lg border-danger mb-4">
                    <div class="card-header bg-danger text-white">
                        <h2 class="mb-0">Películas</h2>
                    </div>
                    <div class="card-body bg-light">
                        <?php if (!empty($mensaje)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars($mensaje) ?>
                            </div>
                        <?php endif; ?>
                        <a href="peliculas.php?accion=crear" class="btn btn-danger mb-3">Añadir nueva Película</a>
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-danger">
                                <tr>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th>Año</th>
                                    <th>Duración</th>
                                    <th>Director</th>
                                    <th>Fecha Estreno</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($listaPeliculas as $peli) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($peli['titulo'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($peli['descripcion'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($peli['anio'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($peli['duracion'] ?? '') ?> min</td>
                                    <td><?= htmlspecialchars($peli['director'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($peli['fecha_estreno'] ?? '') ?></td>
                                    <td>
                                        <a href="peliculas.php?accion=editar&id=<?= $peli['id'] ?>" class="btn btn-sm btn-info">Editar</a>
                                        <a href="peliculas.php?accion=eliminar&id=<?= $peli['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        </div>
                        <?php if ($accion === "crear" || $accion === "editar"): ?>
                            <h3 class="mt-4">
                                <?= $accion === "crear" ? "Nueva Película" : "Editar Película: " . htmlspecialchars($datosFormulario['titulo']) ?>
                            </h3>
                            <form method="post" class="mb-4 p-4 rounded border border-danger" style="max-width: 600px; background: #fff;">
                                <div class="mb-2">
                                    <label class="form-label">Título:</label>
                                    <input type="text" name="titulo" class="form-control"
                                    value="<?= htmlspecialchars($datosFormulario['titulo'] ?? '') ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Descripción:</label>
                                    <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($datosFormulario['descripcion'] ?? '') ?></textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Año:</label>
                                    <input type="number" name="anio" class="form-control"
                                    value="<?= htmlspecialchars($datosFormulario['anio'] ?? '') ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Duración (min):</label>
                                    <input type="number" name="duracion" class="form-control"
                                    value="<?= htmlspecialchars($datosFormulario['duracion'] ?? '') ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Director:</label>
                                    <select name="director_id" class="form-select" required>
                                        <?php foreach($directoresObj->showDirectores() as $dir): ?>
                                            <option value="<?= $dir['id'] ?>" <?= ($datosFormulario['director_id'] ?? '') == $dir['id'] ? "selected" : "" ?>>
                                                <?= htmlspecialchars($dir['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Imagen ID:</label>
                                    <input type="number" name="imagen_id" class="form-control"
                                    value="<?= htmlspecialchars($datosFormulario['imagen_id'] ?? '') ?>">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Fecha de Estreno:</label>
                                    <input type="date" name="fecha_estreno" class="form-control"
                                    value="<?= htmlspecialchars($datosFormulario['fecha_estreno'] ?? '') ?>" required>
                                </div>
                                <button type="submit" class="btn btn-danger">Guardar</button>
                                <a href="peliculas.php" class="btn btn-secondary ms-2">Cancelar</a>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php include("../footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
