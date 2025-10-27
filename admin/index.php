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
    <title>Panel de administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../logo.png">

</head>
<body>

<?php include("./menu_privado.php"); ?>

<!-- Contenido principal centrado -->
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4">Bienvenido al panel de administración de LA BUTACA</h2>
            <p>Hola, <strong><?=$usuario ?></strong>. Has accedido correctamente al área privada.</p>
        </div>
    </div>
</div>

<?php include("../footer.php"); ?>
