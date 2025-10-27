<?php
require_once("database.php");

class Plataformas {

    public function getAll() {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM plataformas ORDER BY nombre ASC";
        $result = $conn->query($sql);
        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getPlataformaById($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM plataformas WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $db->closeConnection($conn);
        return $result ? $result->fetch_assoc() : null;
    }

    public function insertarPlataforma($nombre, $descripcion, $url) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "INSERT INTO plataformas (nombre, descripcion, url) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $descripcion, $url);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    public function actualizarPlataforma($id, $nombre, $descripcion, $url) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "UPDATE plataformas SET nombre=?, descripcion=?, url=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $descripcion, $url, $id);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    public function eliminarPlataforma($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "DELETE FROM plataformas WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }
}
?>
