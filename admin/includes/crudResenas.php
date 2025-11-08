<?php
require_once 'database.php';

class Resenas
{
    private $db;
    private $connection;

    public function __construct()
    {
        $this->db = new Connection();
        $this->connection = $this->db->getConnection();
    }

    /**
     * Mostrar todas las reseñas con nombre de película y usuario
     */
    public function showResenas()
    {
        $sql = "SELECT r.*, p.titulo AS titulo_pelicula, u.username
                FROM resenas r
                JOIN peliculas p ON r.pelicula_id = p.id
                JOIN usuarios u ON r.usuario_id = u.id
                ORDER BY r.fecha_creacion DESC";
        $result = $this->connection->query($sql);
        $resenas = [];
        while ($row = $result->fetch_assoc()) {
            $resenas[] = $row;
        }
        return $resenas;
    }

    /**
     * Eliminar una reseña (por ID)
     */
    public function deleteResena($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM resenas WHERE id = ?");
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    public function __destruct()
    {
        if ($this->connection) {
            $this->db->closeConnection($this->connection);
        }
    }
    public function getEstadisticasPelicula($pelicula_id)
{
    $stmt = $this->connection->prepare("
        SELECT 
            AVG(puntuacion_imdb) as promedio_imdb,
            AVG(puntuacion_estrellas) as promedio_estrellas,
            COUNT(*) as total_resenas,
            MAX(puntuacion_imdb) as max_puntuacion,
            MIN(puntuacion_imdb) as min_puntuacion
        FROM resenas
        WHERE pelicula_id = ?
    ");
    $stmt->bind_param("i", $pelicula_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $estadisticas = $result->fetch_assoc();
    $stmt->close();
    return $estadisticas;
}
// Comprobar si un usuario ya reseñó esa película
public function usuarioYaReseño($usuario_id, $pelicula_id)
{
    $stmt = $this->connection->prepare("SELECT id FROM resenas WHERE usuario_id = ? AND pelicula_id = ?");
    $stmt->bind_param("ii", $usuario_id, $pelicula_id);
    $stmt->execute();
    $stmt->store_result();
    $existe = $stmt->num_rows > 0;
    $stmt->close();
    return $existe;
}

// Actualizar reseña existente
public function updateResena($usuario_id, $pelicula_id, $puntuacion_estrellas, $puntuacion_imdb, $comentario)
{
    $stmt = $this->connection->prepare("
        UPDATE resenas 
        SET puntuacion_estrellas = ?, puntuacion_imdb = ?, comentario = ?, fecha_actualizacion = NOW()
        WHERE usuario_id = ? AND pelicula_id = ?
    ");
    $stmt->bind_param("iisii", $puntuacion_estrellas, $puntuacion_imdb, $comentario, $usuario_id, $pelicula_id);
    $resultado = $stmt->execute();
    $stmt->close();
    return $resultado;
}

// Insertar nueva reseña
public function insertResena($usuario_id, $pelicula_id, $puntuacion_estrellas, $puntuacion_imdb, $comentario)
{
    $stmt = $this->connection->prepare("
        INSERT INTO resenas (usuario_id, pelicula_id, puntuacion_estrellas, puntuacion_imdb, comentario, fecha_creacion) 
        VALUES (?, ?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param("iiiis", $usuario_id, $pelicula_id, $puntuacion_estrellas, $puntuacion_imdb, $comentario);
    $resultado = $stmt->execute();
    $stmt->close();
    return $resultado;
}

// Obtener la reseña de un usuario para una película concreta
public function getResenaUsuarioPelicula($usuario_id, $pelicula_id)
{
    $stmt = $this->connection->prepare("
        SELECT * FROM resenas WHERE usuario_id = ? AND pelicula_id = ?
    ");
    $stmt->bind_param("ii", $usuario_id, $pelicula_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $resena = $result->fetch_assoc();
    $stmt->close();
    return $resena;
}

// Obtener todas las reseñas de una película
public function getResenasPorPelicula($pelicula_id)
{
    $stmt = $this->connection->prepare("
        SELECT r.*, u.username AS usuario_nombre
        FROM resenas r
        JOIN usuarios u ON r.usuario_id = u.id
        WHERE r.pelicula_id = ?
        ORDER BY r.fecha_creacion DESC
    ");
    $stmt->bind_param("i", $pelicula_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $resenas = [];
    while ($row = $result->fetch_assoc()) {
        $resenas[] = $row;
    }
    $stmt->close();
    return $resenas;
}
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

