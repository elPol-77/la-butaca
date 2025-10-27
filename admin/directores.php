<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "./includes/crudDirectores.php";
$directoresObj = new Directores();
$listaDirectores = $directoresObj->getAll();

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
    'nombre' => '',
    'fecha_nacimiento' => '',
    'biografia' => '',
];

// Si acción editar, carga datos
if ($accion === "editar" && $id) {
    $directorAEditar = $directoresObj->getDirectorById($id);
    if ($directorAEditar) {
        $datosFormulario = $directorAEditar;
    }
}

// Procesar formularios POST (crear/editar)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $biografia = $_POST['biografia'] ?? '';

    if ($accion === "crear") {
        $directoresObj->insertarDirector($nombre, $fecha_nacimiento, $biografia);
        header("Location: directores.php");
        exit();
    } elseif ($accion === "editar" && $id) {
        $directoresObj->actualizarDirector($id, $nombre, $fecha_nacimiento, $biografia);
        header("Location: directores.php");
        exit();
    }
}

// Eliminar director
if ($accion == "eliminar" && $id) {
    $directoresObj->eliminarDirector($id);
    $mensaje = "Director eliminado correctamente.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Directores</title>
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
                        <h2 class="mb-0">Directores</h2>
                    </div>
                    <div class="card-body bg-light">
                        <?php if (!empty($mensaje)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars($mensaje) ?>
                            </div>
                        <?php endif; ?>
                        <a href="directores.php?accion=crear" class="btn btn-danger mb-3">Añadir nuevo Director</a>
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-danger">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Biografía</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($listaDirectores as $director) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($director['nombre'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($director['fecha_nacimiento'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($director['biografia'] ?? '') ?></td>
                                    <td>
                                        <a href="directores.php?accion=editar&id=<?= $director['id'] ?>" class="btn btn-sm btn-info">Editar</a>
                                        <a href="directores.php?accion=eliminar&id=<?= $director['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        </div>
                        <?php if ($accion === "crear" || $accion === "editar"): ?>
                            <h3 class="mt-4">
                                <?= $accion === "crear" ? "Nuevo Director" : "Editar Director: " . htmlspecialchars($datosFormulario['nombre']) ?>
                            </h3>
                            <form method="post" class="mb-4 p-4 rounded border border-danger" style="max-width: 600px; background: #fff;">
                                <div class="mb-2">
                                    <label class="form-label">Nombre:</label>
                                    <input type="text" name="nombre" class="form-control"
                                    value="<?= htmlspecialchars($datosFormulario['nombre'] ?? '') ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Fecha de nacimiento:</label>
                                    <input type="date" name="fecha_nacimiento" class="form-control"
                                    value="<?= htmlspecialchars($datosFormulario['fecha_nacimiento'] ?? '') ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Biografía:</label>
                                    <textarea name="biografia" class="form-control" required><?= htmlspecialchars($datosFormulario['biografia'] ?? '') ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger">Guardar</button>
                                <a href="directores.php" class="btn btn-secondary ms-2">Cancelar</a>
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
