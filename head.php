<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
    .header__logo img {
        max-height: 60px;
        width: auto;
    }
    
    
    /* Hover con línea roja en el menú */
    .header__menu ul li {
        position: relative;
    }
    
    .header__menu ul li a {
        position: relative;
        display: inline-block;
        transition: all 0.3s ease;
    }
    
    .header__menu ul li a::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background-color: #e50914;
        transition: width 0.3s ease;
    }
    
    .header__menu ul li a:hover::after {
        width: 100%;
    }
</style>

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
                            <li><a href="./index.php">Home</a></li>
                            <li><a href="./peliculas.php">Películas</a></li>
                            <li><a href="./actores.php">Actores</a></li>
                            <li><a href="./directores.php">Directores</a></li>
                            <li><a href="./about.php">About me</a></li>
                            <li><a href="./contacto.php">Contacto</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="header__right">
                    <a href="#" class="search-switch"><span class="icon_search"></span></a>
                    <?php if (isset($_SESSION['id'])): ?>
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
