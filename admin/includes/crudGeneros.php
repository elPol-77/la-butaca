<?php
require_once("database.php");
class Generos {
    public function getAll() {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM generos ORDER BY nombre ASC";
        $result = $conn->query($sql);
        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getGeneroById($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM generos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $db->closeConnection($conn);
        return $result ? $result->fetch_assoc() : null;
    }

    public function insertarGenero($nombre) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "INSERT INTO generos (nombre) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    public function actualizarGenero($id, $nombre) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "UPDATE generos SET nombre=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nombre, $id);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    public function eliminarGenero($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "DELETE FROM generos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }
}
?>
