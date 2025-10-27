<?php
require_once("database.php");

class Actores {
    public function showActores() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();
            $sql = "SELECT id, nombre, fecha_nacimiento, biografia, imagen_id FROM actores";
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
        $sql = "SELECT id, nombre, fecha_nacimiento, biografia, imagen_id FROM actores WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $db->closeConnection($conn);
        return $result->fetch_assoc();
    }

    public function insertarActor($nombre, $fecha_nacimiento, $biografia, $imagen_id = null) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "INSERT INTO actores (nombre, fecha_nacimiento, biografia, imagen_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $fecha_nacimiento, $biografia, $imagen_id);
        $stmt->execute();
        $db->closeConnection($conn);
    }

    public function actualizarActor($id, $nombre, $fecha_nacimiento, $biografia, $imagen_id = null) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "UPDATE actores SET nombre = ?, fecha_nacimiento = ?, biografia = ?, imagen_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $nombre, $fecha_nacimiento, $biografia, $imagen_id, $id);
        $stmt->execute();
        $db->closeConnection($conn);
    }

    public function eliminarActor($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "DELETE FROM actores WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $db->closeConnection($conn);
    }
}
?>