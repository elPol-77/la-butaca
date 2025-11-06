<?php
require_once("database.php");

class Usuarios {

    public function showUsuarios() {
        try {
            $db = new Connection();
            $conn = $db->getConnection();
            $sql = "SELECT id, username, email, rol, fecha_registro FROM usuarios";
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
        $sql = "SELECT id, username, email, rol, fecha_registro FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $db->closeConnection($conn);
        return $result->fetch_assoc();
    }

public function insertarUsuario($username, $email, $passwd, $rol) {
    $db = new Connection();
    $conn = $db->getConnection();
    $hashed_password = password_hash($passwd, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (username, email, password, rol, fecha_registro) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $rol);
    try {
        $stmt->execute();
    } catch (mysqli_sql_exception $e) {
        $db->closeConnection($conn);

        throw $e;
    }
    $db->closeConnection($conn);
}

    public function actualizarUsuario($id, $username, $email, $rol) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "UPDATE usuarios SET username = ?, email = ?, rol = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $email, $rol, $id);
        $stmt->execute();
        $db->closeConnection($conn);
    }

    public function actualizarPassword($id, $passwd) {
        $db = new Connection();
        $conn = $db->getConnection();
        $hashed_password = password_hash($passwd, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $id);
        $stmt->execute();
        $db->closeConnection($conn);
    }

    public function verificarPassword($id, $password) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT password FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        $db->closeConnection($conn);
        
        if ($usuario && password_verify($password, $usuario['password'])) {
            return true;
        }
        return false;
    }

    public function eliminarUsuario($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $db->closeConnection($conn);
    }
}
?>
