<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "./includes/crudUsuarios.php";
$usuariosObj = new Usuarios();
$listaUsuarios = $usuariosObj->showUsuarios();

require_once "./includes/sessions.php";
$sesion = new Sessions();
if (!$sesion->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}

$currentUserId = $sesion->getUserId();
$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";

// Eliminar usuario
if ($accion == "eliminar" && $id) {
    if ((int)$id !== (int)$currentUserId) {
        $usuariosObj->eliminarUsuario($id);
        $mensaje = "Usuario eliminado correctamente.";
    } else {
        $mensaje = "Error: No puedes eliminar tu propia cuenta mientras estás logueado.";
    }
}

// Formulario datos
$datosFormulario = [
    'id' => '',
    'username' => '',
    'email' => '',
    'password' => '',
    'rol' => '',
    'fecha_registro' => ''
];

if (($accion === "editar" || $accion === "editar_password") && $id) {
    $usuarioAEditar = $usuariosObj->getById($id);
    if ($usuarioAEditar) {
        $datosFormulario = $usuarioAEditar;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $rol = $_POST['rol'] ?? '';

    if ($accion === "crear") {
        if ($password !== $password_confirm) {
            $mensaje = "Error: Las contraseñas no coinciden.";
        } elseif (empty($password)) {
            $mensaje = "Error: La contraseña no puede estar vacía.";
        } else {
            $usuariosObj->insertarUsuario($username, $email, $password, $rol);
            header("Location: usuarios.php");
            exit();
        }
    } elseif ($accion === "editar" && $id) {
        $usuariosObj->actualizarUsuario($id, $username, $email, $rol);
        header("Location: usuarios.php");
        exit();
    } elseif ($accion === "editar_password" && $id) {
        if (empty($password) || $password !== $password_confirm) {
            $mensaje = "Error: La contraseña no puede estar vacía o las contraseñas no coinciden.";
        } else {
            $usuariosObj->actualizarPassword($id, $password);
            header("Location: usuarios.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../logo.png">
    <link rel="stylesheet" href="../css/estilos.css"> <!-- Tu hoja estilos personalizada -->
</head>
<body class="bg-white text-dark"> <!-- Color fondo y texto global según tu plantilla -->
    <?php include("./menu_privado.php"); ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <main class="col-md-10">
                <div class="card shadow-lg border-danger mb-4">
                    <div class="card-header bg-danger text-white">
                        <h2 class="mb-0">Usuarios</h2>
                    </div>
                    <div class="card-body bg-light">
                        <?php if (!empty($mensaje)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars($mensaje) ?>
                            </div>
                        <?php endif; ?>
                        <a href="usuarios.php?accion=crear" class="btn btn-danger mb-3">Añadir nuevo Usuario</a>
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-danger">
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($listaUsuarios as $user) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['username'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($user['rol'] ?? '') ?></td>
                                    <td>
                                        <a href="usuarios.php?accion=editar&id=<?= $user['id'] ?>" class="btn btn-sm btn-info">Editar</a>
                                        <a href="usuarios.php?accion=editar_password&id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">Editar Password</a>
                                        <?php
                                        // Mostrar Eliminar solo si es superadmin y NO para el usuario admin
                                        if (
                                            isset($currentUserId, $_SESSION['usuario'], $user['username']) &&
                                            $currentUserId == 1 &&
                                            $_SESSION['usuario'] === 'admin' &&
                                            $user['username'] !== 'admin'
                                        ) :
                                        ?>
                                            <a href="usuarios.php?accion=eliminar&id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        </div>
                        <?php if ($accion === "crear" || $accion === "editar" || $accion === "editar_password"): ?>
                            <h3 class="mt-4">
                                <?php 
                                    if ($accion === "crear") echo "Nuevo Usuario";
                                    elseif ($accion === "editar") echo "Editar Usuario: " . htmlspecialchars($datosFormulario['username']);
                                    elseif ($accion === "editar_password") echo "Cambiar Contraseña: " . htmlspecialchars($datosFormulario['username']);
                                ?>
                            </h3>
                            <form method="post" class="mb-4 p-4 rounded border border-danger" style="max-width: 400px; background: #fff;">
                                <?php if ($accion === "crear" || $accion === "editar"): ?>
                                <div class="mb-2">
                                    <label class="form-label">Username:</label>
                                    <input type="text" name="username" class="form-control"
                                    value="<?= htmlspecialchars($datosFormulario['username'] ?? '') ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Email:</label>
                                    <input type="email" name="email" class="form-control"
                                    value="<?= htmlspecialchars($datosFormulario['email'] ?? '') ?>" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Rol:</label>
                                    <select name="rol" class="form-control" required>
                                        <option value="admin" <?= (isset($datosFormulario['rol']) && $datosFormulario['rol'] === 'admin') ? 'selected' : '' ?>>admin</option>
                                        <option value="usuario" <?= (isset($datosFormulario['rol']) && $datosFormulario['rol'] === 'usuario') ? 'selected' : '' ?>>usuario</option>
                                    </select>
                                </div>
                                <?php endif; ?>
                                <?php if ($accion === "crear" || $accion === "editar_password"): ?>
                                <div class="mb-2">
                                    <label class="form-label">Nueva Contraseña:</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Repetir Contraseña:</label>
                                    <input type="password" name="password_confirm" class="form-control" required>
                                </div>
                                <?php endif; ?>
                                <button type="submit" class="btn btn-danger">Guardar</button>
                                <a href="usuarios.php" class="btn btn-secondary ms-2">Cancelar</a>
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
