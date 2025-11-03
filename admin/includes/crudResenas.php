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
     * Obtener una reseña específica de un usuario para una película
     */
    public function getResenaUsuarioPelicula($usuario_id, $pelicula_id)
    {
        $stmt = $this->connection->prepare("
            SELECT * FROM resenas 
            WHERE usuario_id = ? AND pelicula_id = ?
        ");
        $stmt->bind_param("ii", $usuario_id, $pelicula_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $resena = $result->fetch_assoc();
        $stmt->close();
        return $resena;
    }

    /**
     * Insertar una nueva reseña
     */
    public function insertResena($usuario_id, $pelicula_id, $puntuacion_estrellas, $puntuacion_imdb, $comentario)
    {
        $stmt = $this->connection->prepare("
            INSERT INTO resenas (usuario_id, pelicula_id, puntuacion_estrellas, puntuacion_imdb, comentario) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("iiiis", $usuario_id, $pelicula_id, $puntuacion_estrellas, $puntuacion_imdb, $comentario);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    /**
     * Actualizar una reseña existente
     */
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

    /**
     * Eliminar una reseña
     */
    public function deleteResena($usuario_id, $pelicula_id)
    {
        $stmt = $this->connection->prepare("
            DELETE FROM resenas 
            WHERE usuario_id = ? AND pelicula_id = ?
        ");
        $stmt->bind_param("ii", $usuario_id, $pelicula_id);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    /**
     * Obtener todas las reseñas de una película
     */
    public function getResenasPorPelicula($pelicula_id)
    {
        $stmt = $this->connection->prepare("
        SELECT r.*, u.username as usuario_nombre
        FROM resenas r
        INNER JOIN usuarios u ON r.usuario_id = u.id
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

    /**
     * Obtener estadísticas de reseñas de una película
     */
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

    /**
     * Obtener todas las reseñas de un usuario
     */
    public function getResenasPorUsuario($usuario_id)
    {
        $stmt = $this->connection->prepare("
            SELECT r.*, p.titulo, p.imagen, p.anio
            FROM resenas r
            INNER JOIN pelicula p ON r.pelicula_id = p.id
            WHERE r.usuario_id = ?
            ORDER BY r.fecha_creacion DESC
        ");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $resenas = [];
        while ($row = $result->fetch_assoc()) {
            $resenas[] = $row;
        }
        $stmt->close();
        return $resenas;
    }

    /**
     * Contar cuántas reseñas ha escrito un usuario
     */
    public function contarResenasPorUsuario($usuario_id)
    {
        $stmt = $this->connection->prepare("
            SELECT COUNT(*) as total 
            FROM resenas 
            WHERE usuario_id = ?
        ");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data['total'] ?? 0;
    }

    /**
     * Verificar si un usuario ya ha reseñado una película
     */
    public function usuarioYaReseño($usuario_id, $pelicula_id)
    {
        $resena = $this->getResenaUsuarioPelicula($usuario_id, $pelicula_id);
        return $resena !== null;
    }

    /**
     * Obtener las últimas N reseñas del sitio
     */
    public function getUltimasResenas($limite = 10)
    {
        $stmt = $this->connection->prepare("
            SELECT r.*, u.nombre as usuario_nombre, u.username, p.titulo, p.imagen
            FROM resenas r
            INNER JOIN usuario u ON r.usuario_id = u.id
            INNER JOIN pelicula p ON r.pelicula_id = p.id
            ORDER BY r.fecha_creacion DESC
            LIMIT ?
        ");
        $stmt->bind_param("i", $limite);
        $stmt->execute();
        $result = $stmt->get_result();
        $resenas = [];
        while ($row = $result->fetch_assoc()) {
            $resenas[] = $row;
        }
        $stmt->close();
        return $resenas;
    }

    /**
     * Obtener películas mejor valoradas según reseñas de usuarios
     */
    public function getPeliculasMejorValoradas($limite = 10)
    {
        $stmt = $this->connection->prepare("
            SELECT p.*, 
                   AVG(r.puntuacion_imdb) as promedio_imdb,
                   COUNT(r.id) as total_resenas
            FROM pelicula p
            INNER JOIN resenas r ON p.id = r.pelicula_id
            GROUP BY p.id
            HAVING COUNT(r.id) >= 3
            ORDER BY promedio_imdb DESC
            LIMIT ?
        ");
        $stmt->bind_param("i", $limite);
        $stmt->execute();
        $result = $stmt->get_result();
        $peliculas = [];
        while ($row = $result->fetch_assoc()) {
            $peliculas[] = $row;
        }
        $stmt->close();
        return $peliculas;
    }

    /**
     * Cerrar la conexión
     */
    public function __destruct()
    {
        if ($this->connection) {
            $this->db->closeConnection($this->connection);
        }
    }
}
?>