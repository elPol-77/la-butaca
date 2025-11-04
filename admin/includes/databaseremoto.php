<?php
class Connection {
    private $host = "localhost";
    private $user = "pablobenlloch_labutaca";
    private $pass = "@Proyecto_labutaca1";
    private $dbname = "pablobenlloch_labutaca";

public function getConnection() {
    $conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    $conn->set_charset("utf8");
    return $conn;
}

public function closeConnection($conn) {
    $conn->close();
    }
}
?>