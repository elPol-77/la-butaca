<?php
require_once("database.php");
class Valoraciones {
    public function getAll() {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * 
                FROM resenas";
        $result = $conn->query($sql);
        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
?>