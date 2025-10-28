<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$logueado = isset($_SESSION['usuario']) && isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Butaca - Plataforma de Cine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body class="bg-white text-white">
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-black shadow-lg"> 
        <div class="container-fluid container-xl px-4">
            <a class="navbar-brand p-0" href="index.php">
                <img src="logobutaca.png" alt="La Butaca" width="80px" class="d-inline-block align-text-top">
                <span class="visually-hidden">La Butaca</span>
            </a>
            <button class="btn btn-red text-white me-2" type="button" 
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span> Menú
            </button>
            <form class="d-none d-lg-flex flex-grow-1 mx-3" role="search" method="GET" action="buscar.php">
                <div class="input-group">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Todo
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="#">Películas</a></li>
                        <li><a class="dropdown-item" href="#">Actores</a></li>
                        <li><a class="dropdown-item" href="#">Comentarios</a></li>
                    </ul>
                    <input class="form-control" type="search" name="q" placeholder="Buscar en La Butaca" aria-label="Search">
                    <button class="btn btn-danger" type="submit">🔍</button>
                </div>
            </form>
            <ul class="navbar-nav d-none d-lg-flex mb-2 mb-lg-0 align-items-center ms-auto">
                <?php if ($logueado): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white ms-3 d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-4"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="usuario.php">
                                    <i class="bi bi-person"></i> Mi perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="admin/includes/logout.php">
                                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="login.php" class="btn btn-outline-danger ms-3">Iniciar sesión</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white ms-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ES
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="#">EN</a></li>
                    </ul>
                </li>
            </ul>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userMobileMenu" aria-controls="userMobileMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-danger" id="offcanvasNavbarLabel">Menú de La Butaca</h5>
            <button type="button" class="btn-close text-reset bg-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item"><a class="nav-link text-white" href="peliculas.php">Películas</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="actores.php">Actores</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="#">Lo más valorado</a></li>
            </ul>
            <hr class="bg-white">
            <?php if ($logueado): ?>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link text-white" href="usuario.php"><i class="bi bi-person"></i> Mi perfil</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="cerrar_sesion.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                </ul>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline-danger w-100 my-3">Iniciar sesión</a>
            <?php endif; ?>
        </div>
    </div>
</header>
