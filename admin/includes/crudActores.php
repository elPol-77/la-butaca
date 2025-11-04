<?php
require_once("database.php");
class Actores {
    public function getAll() {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM actores ORDER BY nombre ASC";
        $result = $conn->query($sql);
        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getActorById($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM actores WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $db->closeConnection($conn);
        return $result ? $result->fetch_assoc() : null;
    }

    public function insertarActor($nombre, $fecha_nacimiento, $biografia, $imagen) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "INSERT INTO actores (nombre, fecha_nacimiento, biografia, imagen)
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $fecha_nacimiento, $biografia, $imagen);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    public function actualizarActor($id, $nombre, $fecha_nacimiento, $biografia, $imagen) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "UPDATE actores
                SET nombre=?, fecha_nacimiento=?, biografia=?, imagen=?
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $fecha_nacimiento, $biografia, $imagen, $id);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    public function eliminarActor($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "DELETE FROM actores WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    public function getActorByNombre($nombre) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM actores WHERE nombre = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        $actor = $result->fetch_assoc();
        $db->closeConnection($conn);
        return $actor;
    }
    public function showActores()
{
    $db = new Connection();
    $conn = $db->getConnection();
    $sql = "SELECT id, nombre FROM actores ORDER BY nombre ASC";
    $result = $conn->query($sql);
    $db->closeConnection($conn);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

}

?>
