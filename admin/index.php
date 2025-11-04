<?php 
require_once ("./includes/sessions.php");
$session = new Sessions();

if (!$session->comprobarSesion()) {
    header("Location: ../login.php");
    exit();
}
$usuario = $_SESSION['usuario']; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Panel de Administración - La Butaca">
    <meta name="keywords" content="admin, gestión, películas">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Panel de Administración - La Butaca</title>

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
    <link rel="icon" type="image/x-icon" href="../logo.png">
    <style>
        /* Hero Admin Section */
        .hero-admin {
            background: linear-gradient(90deg, #e50914 0%, #b20710 100%);
            padding: 80px 0 60px;
            margin-bottom: 40px;
        }
        
        .hero-admin h1 {
            color: #fff;
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 15px;
            font-family: 'Oswald', sans-serif;
        }
        
        .hero-admin p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 18px;
            margin-bottom: 0;
        }
        
        /* Admin Cards */
        .admin-section {
            padding: 40px 0 80px;
        }
        
        .admin-card {
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            border: 1px solid #eee;
            height: 100%;
            text-align: center;
        }
        
        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .admin-card-icon {
            font-size: 48px;
            color: #e50914;
            margin-bottom: 20px;
        }
        
        .admin-card h4 {
            color: #111;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 15px;
            font-family: 'Oswald', sans-serif;
        }
        
        .admin-card p {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .admin-card .btn-admin {
            background: #e50914;
            color: #fff;
            padding: 10px 30px;
            border-radius: 50px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        .admin-card .btn-admin:hover {
            background: #b20710;
            transform: scale(1.05);
        }
        
        /* Stats Cards */
        .stats-section {
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: #fff;
            border-radius: 8px;
            padding: 25px;
            text-align: center;
            border: 1px solid #eee;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }
        
        .stat-card i {
            font-size: 36px;
            color: #e50914;
            margin-bottom: 10px;
        }
        
        .stat-card .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #111;
            margin-bottom: 5px;
            font-family: 'Oswald', sans-serif;
        }
        
        .stat-card .stat-label {
            color: #666;
            font-size: 14px;
        }
        
    </style>
</head>
<body>

<?php include("./menu_privado.php"); ?>

<!-- Hero Admin Section -->
<section class="hero-admin">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1><i class="fa fa-user-shield"></i> Panel de Administración</h1>
                <p>Bienvenido, <strong><?= htmlspecialchars($usuario) ?></strong>. Gestiona el contenido y los usuarios de La Butaca</p>
            </div>
        </div>
    </div>
</section>

<!-- Admin Content Section -->
<section class="admin-section">
    <div class="container">
        <!-- Statistics Cards -->
        <div class="stats-section">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="stat-card">
                        <i class="fa fa-film"></i>
                        <div class="stat-number">-</div>
                        <div class="stat-label">Películas</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="stat-card">
                        <i class="fa fa-users"></i>
                        <div class="stat-number">-</div>
                        <div class="stat-label">Usuarios</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="stat-card">
                        <i class="fa fa-star"></i>
                        <div class="stat-number">-</div>
                        <div class="stat-label">Valoraciones</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="stat-card">
                        <i class="fa fa-tags"></i>
                        <div class="stat-number">-</div>
                        <div class="stat-label">Géneros</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Actions -->
        <div class="section-title">
            <h4>Herramientas de Gestión</h4>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="admin-card">
                    <div class="admin-card-icon">
                        <i class="fa fa-film"></i>
                    </div>
                    <h4>Gestionar Películas</h4>
                    <p>Añade, edita o elimina películas de la base de datos</p>
                    <a href="./peliculas.php" class="btn-admin">
                        <i class="fa fa-arrow-right"></i> Ir a Películas
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="admin-card">
                    <div class="admin-card-icon">
                        <i class="fa fa-user-tie"></i>
                    </div>
                    <h4>Gestionar Actores</h4>
                    <p>Administra el catálogo de actores y actrices</p>
                    <a href="./actores.php" class="btn-admin">
                        <i class="fa fa-arrow-right"></i> Ir a Actores
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="admin-card">
                    <div class="admin-card-icon">
                        <i class="fa fa-tags"></i>
                    </div>
                    <h4>Gestionar Géneros</h4>
                    <p>Organiza y mantén los géneros cinematográficos</p>
                    <a href="./generos.php" class="btn-admin">
                        <i class="fa fa-arrow-right"></i> Ir a Géneros
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="admin-card">
                    <div class="admin-card-icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <h4>Gestionar Usuarios</h4>
                    <p>Administra las cuentas y permisos de usuarios</p>
                    <a href="./usuarios.php" class="btn-admin">
                        <i class="fa fa-arrow-right"></i> Ir a Usuarios
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="admin-card">
                    <div class="admin-card-icon">
                        <i class="fa fa-star-half-alt"></i>
                    </div>
                    <h4>Ver Valoraciones</h4>
                    <p>Revisa las valoraciones de los usuarios</p>
                    <a href="./valoraciones.php" class="btn-admin">
                        <i class="fa fa-arrow-right"></i> Ir a Valoraciones
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="admin-card">
                    <div class="admin-card-icon">
                        <i class="fa fa-cog"></i>
                    </div>
                    <h4>Configuración</h4>
                    <p>Ajusta los parámetros del sistema</p>
                    <a href="./configuracion.php" class="btn-admin">
                        <i class="fa fa-arrow-right"></i> Configurar
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("../footer.php"); ?>

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