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
    $nombre = $_POST['nombre'] ?? '';

    if ($accion === "crear") {
        $generosObj->insertarGenero($nombre);
        header("Location: generos.php");
        exit();
    } elseif ($accion === "editar" && $id) {
        $generosObj->actualizarGenero($id, $nombre);
        header("Location: generos.php");
        exit();
    }
}

// Eliminar género
if ($accion == "eliminar" && $id) {
    $generosObj->eliminarGenero($id);
    $mensaje = "Género eliminado correctamente.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Géneros</title>
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
                        <h2 class="mb-0">Géneros</h2>
                    </div>
                    <div class="card-body bg-light">
                        <?php if (!empty($mensaje)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars($mensaje) ?>
                            </div>
                        <?php endif; ?>
                        <a href="generos.php?accion=crear" class="btn btn-danger mb-3">Añadir nuevo Género</a>
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-danger">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($listaGeneros as $genero) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($genero['nombre'] ?? '') ?></td>
                                    <td>
                                        <a href="generos.php?accion=editar&id=<?= $genero['id'] ?>" class="btn btn-sm btn-info">Editar</a>
                                        <a href="generos.php?accion=eliminar&id=<?= $genero['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        </div>
                        <?php if ($accion === "crear" || $accion === "editar"): ?>
                            <h3 class="mt-4">
                                <?= $accion === "crear" ? "Nuevo Género" : "Editar Género: " . htmlspecialchars($datosFormulario['nombre']) ?>
                            </h3>
                            <form method="post" class="mb-4 p-4 rounded border border-danger" style="max-width: 600px; background: #fff;">
                                <div class="mb-2">
                                    <label class="form-label">Nombre:</label>
                                    <input type="text" name="nombre" class="form-control"
                                    value="<?= htmlspecialchars($datosFormulario['nombre'] ?? '') ?>" required>
                                </div>
                                <button type="submit" class="btn btn-danger">Guardar</button>
                                <a href="generos.php" class="btn btn-secondary ms-2">Cancelar</a>
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
