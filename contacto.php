<?php
session_start();

$success = "";
$error = "";

// Procesar formulario de contacto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Usar isset (con el operador ?? para valores por defecto vacíos)
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $asunto = trim($_POST['asunto'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    // Validaciones
    if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
        $error = "Todos los campos son obligatorios";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo electrónico no es válido";
    } else {
        $success = "¡Gracias por contactarnos! Te responderemos pronto.";
        // Limpiar campos después del envío exitoso
        $nombre = $email = $asunto = $mensaje = "";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Contacto - La Butaca">
    <meta name="keywords" content="Contacto, soporte, ayuda, películas">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contacto - La Butaca</title>

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
    <link rel="icon" type="image/x-icon" href="./logobutaca.png">

    <style>
    .contact-info-box {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 30px;
        margin-bottom: 30px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .contact-info-box:hover {
        background: rgba(255, 255, 255, 0.08);
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    }

    .contact-info-box i {
        font-size: 40px;
        color: #e50914;
        margin-bottom: 15px;
    }

    .contact-info-box h5 {
        color: #fff;
        margin-bottom: 10px;
        font-size: 18px;
    }

    .contact-info-box p {
        color: #b7b7b7;
        margin: 0;
    }

    .contact-info-box a {
        color: #b7b7b7;
        text-decoration: none;
        transition: color 0.3s;
    }

    .contact-info-box a:hover {
        color: #e50914;
    }

    .login__form textarea {
        width: 100%;
        background: transparent;
        border: 1px solid #b7b7b7;
        padding: 15px 55px 15px 20px;
        color: #b7b7b7;
        font-size: 14px;
        border-radius: 5px;
        margin-bottom: 20px;
        resize: vertical;
        min-height: 150px;
    }

    .login__form textarea:focus {
        border-color: #e50914;
        outline: none;
    }
    </style>
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
                        <h2>Contáctanos</h2>
                        <p>Estamos aquí para ayudarte</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Contact Section Begin -->
    <section class="login spad">
        <div class="container">
            <!-- Información de Contacto -->
            <div class="row" style="margin-bottom: 50px;">
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info-box">
                        <i class="fa fa-map-marker"></i>
                        <h5>Ubicación</h5>
                        <p>Calle Principal #123<br>Ciudad, País</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info-box">
                        <i class="fa fa-envelope"></i>
                        <h5>Email</h5>
                        <p><a href="mailto:contacto@labutaca.com">contacto@labutaca.com</a></p>
                        <p><a href="mailto:soporte@labutaca.com">soporte@labutaca.com</a></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info-box">
                        <i class="fa fa-phone"></i>
                        <h5>Teléfono</h5>
                        <p><a href="tel:+34123456789">+34 123 456 789</a></p>
                        <p>Lun - Vie: 9:00 - 18:00</p>
                    </div>
                </div>
            </div>

            <!-- Formulario de Contacto -->
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="login__form">
                        <h3>Envíanos un Mensaje</h3>

                        <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert"
                            style="background-color: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #dc3545; padding: 12px; border-radius: 5px; margin-bottom: 20px;">
                            <i class="fa fa-exclamation-triangle"></i>
                            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($success)): ?>
                        <div class="alert alert-success" role="alert"
                            style="background-color: rgba(40, 167, 69, 0.1); border: 1px solid #28a745; color: #28a745; padding: 12px; border-radius: 5px; margin-bottom: 20px;">
                            <i class="fa fa-check-circle"></i> <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                        <?php endif; ?>

                        <form method="POST" action="contacto.php">
                            <div class="input__item">
                                <input type="text" name="nombre" placeholder="Tu Nombre"
                                    value="<?= htmlspecialchars($nombre ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                <span class="icon_profile"></span>
                            </div>
                            <div class="input__item">
                                <input type="email" name="email" placeholder="Tu Correo Electrónico"
                                    value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                <span class="icon_mail"></span>
                            </div>
                            <div class="input__item">
                                <input type="text" name="asunto" placeholder="Asunto"
                                    value="<?= htmlspecialchars($asunto ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                <span class="icon_comment"></span>
                            </div>
                            <div style="position: relative; margin-bottom: 20px;">
                                <textarea name="mensaje"
                                    placeholder="Tu Mensaje"><?= htmlspecialchars($mensaje ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                            </div>

                            <button type="submit" class="site-btn">Enviar Mensaje</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preguntas Frecuentes -->
            <div class="row" style="margin-top: 60px;">
                <div class="col-lg-12">
                    <div class="login__form">
                        <h3 style="text-align: center; margin-bottom: 30px;">Preguntas Frecuentes</h3>

                        <div class="row">
                            <div class="col-lg-6">
                                <div style="margin-bottom: 25px;">
                                    <h5 style="color: #e50914; margin-bottom: 10px;">
                                        <i class="fa fa-question-circle"></i> ¿Cómo puedo agregar una reseña?
                                    </h5>
                                    <p style="color: #b7b7b7; line-height: 1.6;">
                                        Simplemente inicia sesión, busca la película que quieres reseñar y haz clic en
                                        "Agregar Reseña" en la página de detalles.
                                    </p>
                                </div>

                                <div style="margin-bottom: 25px;">
                                    <h5 style="color: #e50914; margin-bottom: 10px;">
                                        <i class="fa fa-question-circle"></i> ¿Es gratuito registrarse?
                                    </h5>
                                    <p style="color: #b7b7b7; line-height: 1.6;">
                                        Sí, el registro y uso de La Butaca es completamente gratuito para todos los
                                        usuarios.
                                    </p>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div style="margin-bottom: 25px;">
                                    <h5 style="color: #e50914; margin-bottom: 10px;">
                                        <i class="fa fa-question-circle"></i> ¿Cómo actualizo mi perfil?
                                    </h5>
                                    <p style="color: #b7b7b7; line-height: 1.6;">
                                        Ve a la sección "Mi Perfil" desde el menú principal y allí podrás actualizar tu
                                        información personal y contraseña.
                                    </p>
                                </div>

                                <div style="margin-bottom: 25px;">
                                    <h5 style="color: #e50914; margin-bottom: 10px;">
                                        <i class="fa fa-question-circle"></i> ¿Puedo sugerir películas?
                                    </h5>
                                    <p style="color: #b7b7b7; line-height: 1.6;">
                                        ¡Por supuesto! Envíanos un mensaje con tu sugerencia y la consideraremos para
                                        agregarla a nuestro catálogo.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Redes Sociales -->
            <div class="row" style="margin-top: 40px;">
                <div class="col-lg-12">
                    <div
                        style="text-align: center; padding: 30px; background: rgba(255, 255, 255, 0.05); border-radius: 10px;">
                        <h4 style="color: #fff; margin-bottom: 20px;">Síguenos en Redes Sociales</h4>
                        <div>
                            <a href="#"
                                style="display: inline-block; width: 50px; height: 50px; line-height: 50px; background: rgba(229, 9, 20, 0.2); border-radius: 50%; color: #e50914; font-size: 20px; margin: 0 10px; transition: all 0.3s;"
                                onmouseover="this.style.background='#e50914'; this.style.color='#fff'"
                                onmouseout="this.style.background='rgba(229, 9, 20, 0.2)'; this.style.color='#e50914'">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="#"
                                style="display: inline-block; width: 50px; height: 50px; line-height: 50px; background: rgba(229, 9, 20, 0.2); border-radius: 50%; color: #e50914; font-size: 20px; margin: 0 10px; transition: all 0.3s;"
                                onmouseover="this.style.background='#e50914'; this.style.color='#fff'"
                                onmouseout="this.style.background='rgba(229, 9, 20, 0.2)'; this.style.color='#e50914'">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="#"
                                style="display: inline-block; width: 50px; height: 50px; line-height: 50px; background: rgba(229, 9, 20, 0.2); border-radius: 50%; color: #e50914; font-size: 20px; margin: 0 10px; transition: all 0.3s;"
                                onmouseover="this.style.background='#e50914'; this.style.color='#fff'"
                                onmouseout="this.style.background='rgba(229, 9, 20, 0.2)'; this.style.color='#e50914'">
                                <i class="fa fa-instagram"></i>
                            </a>
                            <a href="#"
                                style="display: inline-block; width: 50px; height: 50px; line-height: 50px; background: rgba(229, 9, 20, 0.2); border-radius: 50%; color: #e50914; font-size: 20px; margin: 0 10px; transition: all 0.3s;"
                                onmouseover="this.style.background='#e50914'; this.style.color='#fff'"
                                onmouseout="this.style.background='rgba(229, 9, 20, 0.2)'; this.style.color='#e50914'">
                                <i class="fa fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <?php include 'footer.php'; ?>

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form" action="buscar.php" method="GET">
                <input type="text" name="q" id="search-input" placeholder="Buscar películas.....">
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