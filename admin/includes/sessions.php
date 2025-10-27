<?php
require_once("database.php");

class Sessions {
    public function comprobarCredenciales($username, $password) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT id, username, password FROM usuarios WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $usuario = $result->fetch_assoc();
        $db->closeConnection($conn);
        
        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }

        return null;
    }
    
    public function crearSesion($usuario) {
        $this->startSession();
        $_SESSION['usuario'] = $usuario['username']; 
        $_SESSION['id'] = $usuario['id'];           
    }
    
    public function comprobarSesion() {
        $this->startSession();
        return isset($_SESSION['usuario']) && isset($_SESSION['id']);
    }
    
    public function cerrarSesion() {
        $this->startSession();
        session_unset();
        session_destroy();
    }
        private function startSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function getUserId() {
        $this->startSession();
        return $_SESSION['id'] ?? null; 
    }


}

