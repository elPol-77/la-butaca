<?php
session_start();
// Redirige si no está logueado o no es usuario
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'usuario') {
    header("Location: login.php");
    exit();
}

require_once("admin/includes/database.php"); 

$userId = $_SESSION['id'];
$db = new Connection();
$conn = $db->getConnection();

$error = "";
$success = "";

$sql = "SELECT username, email FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

$usernameOld = $userData['username'];
$emailOld = $userData['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $passwordRepeat = $_POST['password_repeat'];

    if (empty($username) || empty($email)) {
        $error = "Usuario y correo son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo no es válido.";
    } elseif (!empty($password) && $password !== $passwordRepeat) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Actualiza datos según los campos recibidos
        if (!empty($password)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET username=?, email=?, password=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $username, $email, $hash, $userId);
        } else {
            $sql = "UPDATE usuarios SET username=?, email=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $username, $email, $userId);
        }
        if ($stmt->execute()) {
            $success = "Datos actualizados correctamente.";
            $_SESSION['usuario'] = $username; 
            $usernameOld = $username;
            $emailOld = $email;
        } else {
            $error = "Error al actualizar los datos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil | La Butaca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body class="bg-white">
    <?php include 'menu.php'; ?>
    <main class="container my-5 p-4 rounded border border-danger text-dark shadow-lg" style="max-width: 500px;">
        <h2 class="mb-4 text-center">
            <i class="bi bi-person-circle"></i> Mi perfil
        </h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <div class="mb-3">
                <label class="form-label fw-bold">Usuario:</label>
                <input class="form-control" name="username" value="<?php echo htmlspecialchars($usernameOld); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Correo:</label>
                <input class="form-control" type="email" name="email" value="<?php echo htmlspecialchars($emailOld); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Contraseña nueva (opcional):</label>
                <input class="form-control" type="password" name="password" placeholder="Nueva contraseña">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Repetir contraseña:</label>
                <input class="form-control" type="password" name="password_repeat" placeholder="Repetir contraseña">
            </div>
            <button class="btn btn-danger w-100" type="submit">Actualizar datos</button>
        </form>
        <div class="mt-4 text-center">
            <a href="admin/includes/logout.php" class="btn btn-danger">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </a>
        </div>
    </main>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
