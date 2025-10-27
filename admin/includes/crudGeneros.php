<?php
require_once("database.php");

class Generos {
    public function showGeneros() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();
            $sql = "SELECT id, nombre FROM generos";
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
        $sql = "SELECT id, nombre FROM generos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $db->closeConnection($conn);
        return $result->fetch_assoc();
    }

    public function insertarGenero($nombre) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "INSERT INTO generos (nombre) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $db->closeConnection($conn);
    }

    public function actualizarGenero($id, $nombre) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "UPDATE generos SET nombre = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nombre, $id);
        $stmt->execute();
        $db->closeConnection($conn);
    }

    public function eliminarGenero($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "DELETE FROM generos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $db->closeConnection($conn);
    }
}
?>
