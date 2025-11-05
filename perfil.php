<?php
require_once "./admin/includes/sessions.php";
require_once "./admin/includes/crudUsuarios.php";

$sesion = new Sessions();
$crudUsuarios = new Usuarios();

// Verificar que el usuario esté logueado
if (!$sesion->comprobarSesion()) {
    header("Location: login.php");
    exit();
}

$error = "";
$success = "";
$usuario_id = $sesion->getUserId();

// Obtener datos del usuario usando CRUD
$usuario = $crudUsuarios->getById($usuario_id);

// Procesar actualización de información
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_info'])) {
    $nuevo_username = $_POST['username'] ?? '';
    $nuevo_email = $_POST['email'] ?? '';

    // Validaciones
    if (empty($nuevo_username) || empty($nuevo_email)) {
        $error = "El nombre de usuario y el correo son obligatorios";
    } else {
        try {
            $crudUsuarios->actualizarUsuario($usuario_id, $nuevo_username, $nuevo_email, $usuario['rol']);
            $success = "Información actualizada correctamente";
            // Actualizar datos para mostrar
            $usuario = $crudUsuarios->getById($usuario_id);
        } catch (Exception $e) {
            $error = "Error al actualizar la información";
        }
    }
}

// Procesar cambio de contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cambiar_password'])) {
    $password_actual = $_POST['password_actual'] ?? '';
    $password_nueva = $_POST['password_nueva'] ?? '';
    $password_confirmar = $_POST['password_confirmar'] ?? '';

    // Validaciones
    if (empty($password_actual) || empty($password_nueva) || empty($password_confirmar)) {
        $error = "Todos los campos de contraseña son obligatorios";
    } else {
        // Verificar contraseña actual usando CRUD
        $password_correcta = $crudUsuarios->verificarPassword($usuario_id, $password_actual);

        if (!$password_correcta) {
            $error = "La contraseña actual es incorrecta";
        } elseif ($password_nueva !== $password_confirmar) {
            $error = "Las contraseñas nuevas no coinciden";
        } else {
            try {
                $crudUsuarios->actualizarPassword($usuario_id, $password_nueva);
                $success = "Contraseña actualizada correctamente";
            } catch (Exception $e) {
                $error = "Error al actualizar la contraseña";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Perfil - La Butaca">
    <meta name="keywords" content="Perfil, películas, streaming">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mi Perfil - La Butaca</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="anime-main/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/plyr.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="anime-main/css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php include 'head.php'; ?>

    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="imagenes/header.png">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Mi Perfil</h2>
                        <p>Administra tu cuenta de La Butaca</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Perfil Section Begin -->
    <section class="login spad">
        <div class="container">
            <div class="row">
                <!-- Información del Usuario -->
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>Información de la Cuenta</h3>

                        <?php if (!empty($error) && !isset($_POST['cambiar_password'])): ?>
                            <div class="alert alert-danger" role="alert"
                                style="background-color: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #dc3545; padding: 12px; border-radius: 5px; margin-bottom: 20px;">
                                <i class="fa fa-exclamation-triangle"></i>
                                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($success) && !isset($_POST['cambiar_password'])): ?>
                            <div class="alert alert-success" role="alert"
                                style="background-color: rgba(40, 167, 69, 0.1); border: 1px solid #28a745; color: #28a745; padding: 12px; border-radius: 5px; margin-bottom: 20px;">
                                <i class="fa fa-check-circle"></i> <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="perfil.php">
                            <div class="input__item">
                                <input type="text" name="username"
                                    value="<?= htmlspecialchars($usuario['username'], ENT_QUOTES, 'UTF-8') ?>"
                                    placeholder="Nombre de Usuario">
                                <span class="icon_profile"></span>
                            </div>

                            <div class="input__item">
                                <input type="email" name="email"
                                    value="<?= htmlspecialchars($usuario['email'], ENT_QUOTES, 'UTF-8') ?>"
                                    placeholder="Correo Electrónico">
                                <span class="icon_mail"></span>
                            </div>

                            <button type="submit" name="actualizar_info" class="site-btn">Actualizar
                                Información</button>
                            <?php if ($usuario['rol'] === 'admin'): ?>
                                <a href="admin/index.php" class="site-btn"
                                    style="display: block; text-align: center; margin-top: 15px; background-color: #e36414; text-decoration: none;">
                                    <i class="fa fa-dashboard"></i> Panel de Administración
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <!-- Cambiar Contraseña -->
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>Cambiar Contraseña</h3>

                        <?php if (!empty($error) && isset($_POST['cambiar_password'])): ?>
                            <div class="alert alert-danger" role="alert"
                                style="background-color: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #dc3545; padding: 12px; border-radius: 5px; margin-bottom: 20px;">
                                <i class="fa fa-exclamation-triangle"></i>
                                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($success) && isset($_POST['cambiar_password'])): ?>
                            <div class="alert alert-success" role="alert"
                                style="background-color: rgba(40, 167, 69, 0.1); border: 1px solid #28a745; color: #28a745; padding: 12px; border-radius: 5px; margin-bottom: 20px;">
                                <i class="fa fa-check-circle"></i> <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="perfil.php">
                            <div class="input__item">
                                <input type="password" name="password_actual" placeholder="Contraseña Actual">
                                <span class="icon_lock"></span>
                            </div>

                            <div class="input__item">
                                <input type="password" name="password_nueva" placeholder="Contraseña Nueva">
                                <span class="icon_lock-open"></span>
                            </div>

                            <div class="input__item">
                                <input type="password" name="password_confirmar"
                                    placeholder="Confirmar Contraseña Nueva">
                                <span class="icon_lock-open"></span>
                            </div>

                            <button type="submit" name="cambiar_password" class="site-btn">Cambiar Contraseña</button>
                        </form>

                        <div style="margin-top: 20px;">
                            <a href="admin/includes/logout.php" class="btn btn-outline-danger btn-block"
                                style="display: block; text-align: center; padding: 12px; border: 1px solid #dc3545; color: #dc3545; border-radius: 5px; text-decoration: none; transition: all 0.3s;">
                                <i class="fa fa-sign-out"></i> Cerrar Sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Perfil Section End -->

    <?php include 'footer.php'; ?>

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form" action="buscar.php" method="GET">
                <input type="text" name="q" id="search-input" placeholder="Buscar películas....." required>
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="anime-main/js/jquery-3.3.1.min.js"></script>
    <script src="anime-main/js/bootstrap.min.js"></script>
    <script src="anime-main/js/player.js"></script>
    <script src="anime-main/js/jquery.nice-select.min.js"></script>
    <script src="anime-main/js/mixitup.min.js"></script>
    <script src="anime-main/js/jquery.slicknav.js"></script>
    <script src="anime-main/js/owl.carousel.min.js"></script>
    <script src="anime-main/js/main.js"></script>
</body>

</html>