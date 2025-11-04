<?php
require_once("database.php");
class Generos
{
    public function getAll()
    {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM generos ORDER BY nombre ASC";
        $result = $conn->query($sql);
        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getGeneroById($id)
    {
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

    public function insertarGenero($nombre)
    {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "INSERT INTO generos (nombre) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $exito = $stmt->execute();
        $nuevoId = $exito ? $conn->insert_id : false;
        $db->closeConnection($conn);
        return $nuevoId;
    }


    public function actualizarGenero($id, $nombre)
    {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "UPDATE generos SET nombre=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nombre, $id);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    public function eliminarGenero($id)
    {
        $db = new Connection();
        $conn = $db->getConnection();

        // Verificar si el género tiene películas asociadas
        $sqlCheck = "SELECT COUNT(*) as total FROM pelicula_genero WHERE genero_id = ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("i", $id);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        $row = $resultCheck->fetch_assoc();

        if ($row['total'] > 0) {
            $db->closeConnection($conn);
            return false;
        }

        $sql = "DELETE FROM generos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    public function getGeneroByNombre($nombre)
    {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM generos WHERE nombre = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        $genero = $result->fetch_assoc();
        $db->closeConnection($conn);
        return $genero;
    }

}

?>