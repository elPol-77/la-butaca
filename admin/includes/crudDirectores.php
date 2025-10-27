<?php
require_once("database.php");
class Directores {
    public function getAll() {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM directores ORDER BY nombre ASC";
        $result = $conn->query($sql);
        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getDirectorById($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM directores WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $db->closeConnection($conn);
        return $result ? $result->fetch_assoc() : null;
    }

    public function insertarDirector($nombre, $fecha_nacimiento, $biografia) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "INSERT INTO directores (nombre, fecha_nacimiento, biografia) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $fecha_nacimiento, $biografia);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    public function actualizarDirector($id, $nombre, $fecha_nacimiento, $biografia) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "UPDATE directores SET nombre=?, fecha_nacimiento=?, biografia=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $fecha_nacimiento, $biografia, $id);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    public function eliminarDirector($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "DELETE FROM directores WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    public function showDirectores() {
    $db = new Connection();
    $conn = $db->getConnection();
    $sql = "SELECT id, nombre FROM directores ORDER BY nombre ASC";
    $result = $conn->query($sql);
    $db->closeConnection($conn);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

}
?>
