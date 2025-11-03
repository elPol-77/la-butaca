<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Header Section Begin -->
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="header__logo">
                    <a href="./index.php">
                        <img src="logobutaca.png" alt="labutacalogo" width="50px">
                    </a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="header__nav">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="active"><a href="./index.php">Home</a></li>
                            <li><a href="#">Películas <span class="arrow_carrot-down"></span></a>
                                <ul class="dropdown">
                                    <li><a href="./peliculas.php">Todas las Películas</a></li>
                                </ul>
                            </li>
                            <li><a href="./about.php">About me</a></li>
                            <li><a href="./contacto.php">Contacto</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="header__right">
                    <a href="#" class="search-switch"><span class="icon_search"></span></a>
                    <?php if(isset($_SESSION['id'])): ?>
                        <a href="./perfil.php"><span class="icon_profile"></span></a>
                    <?php else: ?>
                        <a href="./login.php"><span class="icon_profile"></span></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div id="mobile-menu-wrap"></div>
    </div>
</header>
<!-- Header End -->
