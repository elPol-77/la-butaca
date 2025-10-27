<?php
require_once("database.php");

class Directores {
    public function showDirectores() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();
            $sql = "SELECT id, nombre, fecha_nacimiento, biografia FROM directores";
            $result = $conn->query($sql);
            $db->closeConnection($conn);
            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        } catch (Exception $e) {
            return [];
        }
    }

    public function getById($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT id, nombre, fecha_nacimiento, biografia FROM directores WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $db->closeConnection($conn);
        return $result->fetch_assoc();
    }

    public function insertarDirector($nombre, $fecha_nacimiento, $biografia) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "INSERT INTO directores (nombre, fecha_nacimiento, biografia) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $fecha_nacimiento, $biografia);
        $stmt->execute();
        $db->closeConnection($conn);
    }

    public function actualizarDirector($id, $nombre, $fecha_nacimiento, $biografia) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "UPDATE directores SET nombre = ?, fecha_nacimiento = ?, biografia = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $fecha_nacimiento, $biografia, $id);
        $stmt->execute();
        $db->closeConnection($conn);
    }

    public function eliminarDirector($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "DELETE FROM directores WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $db->closeConnection($conn);
    }
}

?>
