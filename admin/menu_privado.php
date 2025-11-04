<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$logueado = isset($_SESSION['usuario']) && isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador';
$usuario = $_SESSION['usuario'] ?? 'Admin';
?>

<!-- Header Section Begin -->
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="header__logo">
                    <a href="./index.php">
                        <img src="../logobutaca.png" alt="labutacalogo" width="50px">
                    </a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="header__nav">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="active"><a href="./index.php">Dashboard</a></li>
                            <li><a href="#">Gestión <span class="arrow_carrot-down"></span></a>
                                <ul class="dropdown">
                                    <li><a href="./peliculas.php">Películas</a></li>
                                    <li><a href="./actores.php">Actores</a></li>
                                    <li><a href="./directores.php">Directores</a></li>
                                    <li><a href="./generos.php">Géneros</a></li>
                                    <li><a href="./usuarios.php">Usuarios</a></li>
                                </ul>
                            </li>
                            <li><a href="../index.php">Ver Sitio Público</a></li>
                            <li><a href="./includes/logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="header__right">
                    <a href="#" class="search-switch"><span class="icon_search"></span></a>
                    <?php if($logueado): ?>
                        <a href="./includes/logout.php" title="Cerrar sesión"><span class="icon_profile"></span></a>
                    <?php else: ?>
                        <a href="../login.php"><span class="icon_profile"></span></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div id="mobile-menu-wrap"></div>
    </div>
</header>
<!-- Header End -->