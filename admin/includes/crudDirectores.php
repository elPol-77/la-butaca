<?php
require_once("database.php");
class Directores
{
    public function getAll()
    {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT id, nombre, fecha_nacimiento, biografia, imagen FROM directores ORDER BY nombre ASC";
        $result = $conn->query($sql);
        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getDirectorById($id)
    {
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

    public function insertarDirector($nombre, $fecha_nacimiento, $biografia, $imagen)
    {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "INSERT INTO directores (nombre, fecha_nacimiento, biografia, imagen) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $fecha_nacimiento, $biografia, $imagen);
        $exito = $stmt->execute();
        $nuevoId = $exito ? $conn->insert_id : false;
        $db->closeConnection($conn);
        return $nuevoId;
    }

    public function actualizarDirector($id, $nombre, $fecha_nacimiento, $biografia, $imagen)
    {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "UPDATE directores SET nombre=?, fecha_nacimiento=?, biografia=?, imagen=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $fecha_nacimiento, $biografia, $imagen, $id);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    public function eliminarDirector($id)
    {
        $db = new Connection();
        $conn = $db->getConnection();

        // Verificar si el director tiene películas asociadas
        $sqlCheck = "SELECT COUNT(*) as total FROM peliculas WHERE director_id = ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("i", $id);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        $row = $resultCheck->fetch_assoc();

        if ($row['total'] > 0) {
            $db->closeConnection($conn);
            return false;
        }

        $sql = "DELETE FROM directores WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    public function showDirectores()
    {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT id, nombre FROM directores ORDER BY nombre ASC";
        $result = $conn->query($sql);
        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getDirectorByNombre($nombre)
    {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM directores WHERE nombre = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        $director = $result->fetch_assoc();
        $db->closeConnection($conn);
        return $director;
    }
    public function getPeliculasDirector($director_id)
    {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT id, titulo, imagen, anio, duracion 
            FROM peliculas 
            WHERE director_id = ? 
            ORDER BY anio DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $director_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $peliculas = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $db->closeConnection($conn);
        return $peliculas;
    }

}
?>