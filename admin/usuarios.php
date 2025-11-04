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

// Verificar que el usuario sea administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$currentUserId = $sesion->getUserId();
$accion = $_GET['accion'] ?? null;
$id = $_GET['id'] ?? null;
$mensaje = "";

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

// Procesar formularios POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errores = [];

    // VALIDACIONES CON isset()
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $password_confirm = isset($_POST['password_confirm']) ? trim($_POST['password_confirm']) : '';
    $rol = isset($_POST['rol']) ? trim($_POST['rol']) : '';

    if ($accion === "crear") {
        // Validar username
        if (empty($username)) {
            $errores[] = "El nombre de usuario es obligatorio.";
        }

        // Validar email
        if (empty($email)) {
            $errores[] = "El email es obligatorio.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El email no es válido.";
        }

        // Validar rol
        if (empty($rol)) {
            $errores[] = "Debes seleccionar un rol.";
        }

        // Validar contraseña
        if (empty($password)) {
            $errores[] = "La contraseña es obligatoria.";
        } elseif (strlen($password) < 6) {
            $errores[] = "La contraseña debe tener al menos 6 caracteres.";
        }

        // Validar confirmación de contraseña
        if ($password !== $password_confirm) {
            $errores[] = "Las contraseñas no coinciden.";
        }

        // Si no hay errores, crear usuario
        if (empty($errores)) {
            $usuariosObj->insertarUsuario($username, $email, $password, $rol);
            header("Location: usuarios.php");
            exit();
        } else {
            $mensaje = implode('<br>', $errores);
        }

    } elseif ($accion === "editar" && $id) {
        // Validar username
        if (empty($username)) {
            $errores[] = "El nombre de usuario es obligatorio.";
        }

        // Validar email
        if (empty($email)) {
            $errores[] = "El email es obligatorio.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El email no es válido.";
        }

        // Validar rol
        if (empty($rol)) {
            $errores[] = "Debes seleccionar un rol.";
        }

        // Si no hay errores, actualizar usuario
        if (empty($errores)) {
            $usuariosObj->actualizarUsuario($id, $username, $email, $rol);
            header("Location: usuarios.php");
            exit();
        } else {
            $mensaje = implode('<br>', $errores);
        }

    } elseif ($accion === "editar_password" && $id) {
        // Validar contraseña
        if (empty($password)) {
            $errores[] = "La contraseña es obligatoria.";
        } elseif (strlen($password) < 6) {
            $errores[] = "La contraseña debe tener al menos 6 caracteres.";
        }

        // Validar confirmación de contraseña
        if ($password !== $password_confirm) {
            $errores[] = "Las contraseñas no coinciden.";
        }

        // Si no hay errores, actualizar contraseña
        if (empty($errores)) {
            $usuariosObj->actualizarPassword($id, $password);
            header("Location: usuarios.php");
            exit();
        } else {
            $mensaje = implode('<br>', $errores);
        }
    }
}

// Eliminar usuario
if ($accion == "eliminar" && $id) {
    if ((int)$id !== (int)$currentUserId) {
        $usuariosObj->eliminarUsuario($id);
        header("Location: usuarios.php");
        exit();
    } else {
        $mensaje = "Error: No puedes eliminar tu propia cuenta mientras estás logueado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gestión de Usuarios - Admin">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestión de Usuarios - La Butaca Admin</title>

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


        .btn-add-user {
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

        .btn-add-user:hover {
            background: #c20711;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(229, 9, 20, 0.4);
        }

        .user-table-wrapper {
            background: #1a1d3a;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            overflow-x: auto;
        }

        .user-table {
            width: 100%;
            color: #fff;
        }

        .user-table thead {
            background: linear-gradient(135deg, #e50914 0%, #8b0000 100%);
        }

        .user-table thead th {
            padding: 15px 10px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            border: none;
            white-space: nowrap;
        }

        .user-table tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s;
        }

        .user-table tbody tr:hover {
            background: rgba(229, 9, 20, 0.1);
        }

        .user-table tbody td {
            padding: 15px 10px;
            vertical-align: middle;
            font-size: 13px;
        }

        .user-table tbody td:first-child {
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

        .btn-password {
            background: #17a2b8;
        }

        .btn-password:hover {
            background: #138496;
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
            padding: 12px 15px;
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

        select.form-select {
            background: #0b0c2a;
            border: 1px solid rgba(255,255,255,0.2);
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

        select.form-select option {
            background-color: #ffffff;
            color: #000000;
            padding: 10px;
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

        .role-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 600;
        }

        .role-badge.admin {
            background: rgba(229, 9, 20, 0.2);
            color: #e50914;
        }

        .role-badge.usuario {
            background: rgba(255, 165, 0, 0.2);
            color: #ffa500;
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
                        <h4>Gestión de Usuarios</h4>
                    </div>

                    <?php if (!empty($mensaje)): ?>
                        <div class="alert-message">
                            <?= $mensaje ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($accion !== "crear" && $accion !== "editar" && $accion !== "editar_password"): ?>
                        <a href="usuarios.php?accion=crear" class="btn-add-user">
                            <i class="fa fa-plus"></i> Añadir Nuevo Usuario
                        </a>

                        <div class="user-table-wrapper">
                            <table class="user-table">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($listaUsuarios as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['username'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                                        <td>
                                            <span class="role-badge <?= $user['rol'] ?>">
                                                <?= htmlspecialchars($user['rol'] ?? '') ?>
                                            </span>
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <a href="usuarios.php?accion=editar&id=<?= $user['id'] ?>" class="btn-action btn-edit">
                                                <i class="fa fa-edit"></i> Editar
                                            </a>
                                            <a href="usuarios.php?accion=editar_password&id=<?= $user['id'] ?>" class="btn-action btn-password">
                                                <i class="fa fa-key"></i> Contraseña
                                            </a>
                                            <?php
                                            // Mostrar Eliminar solo si es superadmin y NO para el usuario admin
                                            if (
                                                isset($currentUserId, $_SESSION['usuario'], $user['username']) &&
                                                $currentUserId == 1 &&
                                                $_SESSION['usuario'] === 'admin' &&
                                                $user['username'] !== 'admin'
                                            ):
                                            ?>
                                                <a href="usuarios.php?accion=eliminar&id=<?= $user['id'] ?>" 
                                                   class="btn-action btn-delete" 
                                                   onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                    <i class="fa fa-trash"></i> Eliminar
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <?php if ($accion === "crear" || $accion === "editar" || $accion === "editar_password"): ?>
                        <div class="form-container">
                            <h3>
                                <?php if($accion === "crear"): ?>
                                    <i class="fa fa-user-plus"></i> Nuevo Usuario
                                <?php elseif($accion === "editar"): ?>
                                    <i class="fa fa-edit"></i> Editar: <?= htmlspecialchars($datosFormulario['username']) ?>
                                <?php elseif($accion === "editar_password"): ?>
                                    <i class="fa fa-key"></i> Cambiar Contraseña: <?= htmlspecialchars($datosFormulario['username']) ?>
                                <?php endif; ?>
                            </h3>
                            
                            <form method="post">
                                <?php if ($accion === "crear" || $accion === "editar"): ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Username *</label>
                                            <input type="text" name="username" class="form-control" 
                                                   value="<?= htmlspecialchars($datosFormulario['username'] ?? '') ?>" 
                                                   placeholder="Ej: juanperez">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email *</label>
                                            <input type="email" name="email" class="form-control" 
                                                   value="<?= htmlspecialchars($datosFormulario['email'] ?? '') ?>" 
                                                   placeholder="Ej: usuario@email.com">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Rol *</label>
                                    <select name="rol" class="form-select">
                                        <option value="">Seleccionar rol</option>
                                        <option value="admin" <?= (isset($datosFormulario['rol']) && $datosFormulario['rol'] === 'admin') ? 'selected' : '' ?>>Administrador</option>
                                        <option value="usuario" <?= (isset($datosFormulario['rol']) && $datosFormulario['rol'] === 'usuario') ? 'selected' : '' ?>>Usuario</option>
                                    </select>
                                </div>
                                <?php endif; ?>

                                <?php if ($accion === "crear" || $accion === "editar_password"): ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nueva Contraseña *</label>
                                            <input type="password" name="password" class="form-control" 
                                                   placeholder="Mínimo 6 caracteres">
                                            <small class="form-hint">La contraseña debe tener al menos 6 caracteres</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Repetir Contraseña *</label>
                                            <input type="password" name="password_confirm" class="form-control" 
                                                   placeholder="Repite la contraseña">
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <div class="form-group" style="margin-top: 30px;">
                                    <button type="submit" class="btn-submit">
                                        <i class="fa fa-save"></i> Guardar Usuario
                                    </button>
                                    <a href="usuarios.php" class="btn-cancel">
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
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form" action="buscar.php" method="GET">
                <input type="text" name="q" id="search-input" placeholder="Buscar usuarios.....">
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
