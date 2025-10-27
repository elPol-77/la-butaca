<?php
require_once("sessions.php");
$session = new Sessions();
$session->cerrarSesion();
header("Location:../../login.php");
exit();