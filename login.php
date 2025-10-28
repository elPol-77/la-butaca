<?php
require_once "./admin/includes/sessions.php";
$sesion = new Sessions();
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['username'];
    $clave = $_POST['password'];
    $datos = $sesion->comprobarCredenciales($usuario, $clave);

    if ($datos) {
        $sesion->crearSesion($datos);

        // Suponemos que $datos['rol'] contiene el tipo de usuario
        if (isset($datos['rol']) && $datos['rol'] == 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: index.php"); // Zona pública
        }
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Butaca - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="bg-white text-bla">
    <?php include 'menu.php'; ?>

    <main class="container my-5 p-4 rounded border border-danger text-dark shadow-lg" style="max-width: 400px;">
        <h2 class="mb-4 text-center">Iniciar sesión</h2>
        <form method="POST" class="mb-3">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input name="username" id="username" class="form-control" placeholder="Nombre de usuario" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input name="password" id="password" type="password" class="form-control" placeholder="Contraseña" required>
            </div>
            <button class="btn btn-danger w-100" type="submit">Entrar</button>
        </form>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <div class="text-center">
            <a href="registro.php" class="text-danger">¿No tienes cuenta? Regístrate</a>
        </div>
    </main>

<?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
