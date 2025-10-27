<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "./admin/includes/crudUsuarios.php";
$usuariosObj = new Usuarios();

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $rol = $_POST['rol'] ?? 'usuario'; 

    // Validación
    if ($password !== $password_confirm) {
        $mensaje = "Las contraseñas no coinciden.";
    } elseif (empty($username) || empty($email) || empty($password)) {
        $mensaje = "Rellena todos los campos.";
    } else {
        $usuariosObj->insertarUsuario($username, $email, $password, $rol);
        header("Location: login.php?registro=ok");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="bg-white text-dark">
    <?php include("menu.php"); ?>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-danger">
                    <div class="card-header bg-danger text-white text-center">
                        <h2>Crear cuenta</h2>
                    </div>
                    <div class="card-body bg-light">
                        <?php if (!empty($mensaje)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($mensaje) ?></div>
                        <?php endif; ?>
                        <form method="POST" class="mb-3">
                            <div class="mb-3">
                                <label for="username" class="form-label">Usuario</label>
                                <input name="username" id="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">Repetir Contraseña</label>
                                <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
                            </div>
                            <button class="btn btn-danger w-100" type="submit">Registrarse</button>
                        </form>
                        <div class="text-center">
                            <a href="login.php" class="btn btn-link text-danger">¿Ya tienes cuenta? Iniciar sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include("footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
