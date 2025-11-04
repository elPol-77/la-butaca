<?php
require_once("database.php");
class Peliculas {
    public function getPopulares($limite = 4) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM peliculas ORDER BY anio DESC LIMIT ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $limite);
        $stmt->execute();
        $result = $stmt->get_result();
        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Obtener las películas más recientes (por fecha de estreno)
    public function getRecientes($limite = 4) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM peliculas ORDER BY fecha_estreno DESC LIMIT ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $limite);
        $stmt->execute();
        $result = $stmt->get_result();
        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Por director
    public function getByDirector($director_id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM peliculas WHERE director_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $director_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Obtener película por ID
    public function getPeliculaById($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT peliculas.*, directores.nombre as director
                FROM peliculas
                LEFT JOIN directores ON peliculas.director_id = directores.id
                WHERE peliculas.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $db->closeConnection($conn);
        return $result ? $result->fetch_assoc() : null;
    }

    // Obtener todas las películas
    public function getAll() {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT peliculas.*, directores.nombre as director, plataformas.nombre as plataforma
                FROM peliculas
                LEFT JOIN directores ON peliculas.director_id = directores.id
                LEFT JOIN plataformas ON peliculas.plataforma_id = plataformas.id
                ORDER BY peliculas.titulo ASC";
        $result = $conn->query($sql);
        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Insertar nueva película (SIN created_at)
    public function insertarPelicula($titulo, $descripcion, $anio, $duracion, $director_id, $plataforma_id, $imagen, $fecha_estreno) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "INSERT INTO peliculas (titulo, descripcion, anio, duracion, director_id, plataforma_id, imagen, fecha_estreno)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiiisss", $titulo, $descripcion, $anio, $duracion, $director_id, $plataforma_id, $imagen, $fecha_estreno);
        $exito = $stmt->execute();
        $nuevoId = $conn->insert_id;
        $db->closeConnection($conn);
        return $exito ? $nuevoId : false;
    }

    // Actualizar película
    public function actualizarPelicula($id, $titulo, $descripcion, $anio, $duracion, $director_id, $plataforma_id, $imagen, $fecha_estreno) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "UPDATE peliculas
                SET titulo=?, descripcion=?, anio=?, duracion=?, director_id=?, plataforma_id=?, imagen=?, fecha_estreno=?
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiiisssi", $titulo, $descripcion, $anio, $duracion, $director_id, $plataforma_id, $imagen, $fecha_estreno, $id);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    // Eliminar película
    public function eliminarPelicula($id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "DELETE FROM peliculas WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $exito = $stmt->execute();
        $db->closeConnection($conn);
        return $exito;
    }

    // ========================================
    // MÉTODOS PARA GÉNEROS
    // ========================================
    
    public function getGenerosByPelicula($pelicula_id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT genero_id FROM pelicula_genero WHERE pelicula_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $pelicula_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $generos = [];
        while ($row = $result->fetch_assoc()) {
            $generos[] = $row['genero_id'];
        }
        $db->closeConnection($conn);
        return $generos;
    }

    public function asociarGeneros($pelicula_id, $generos) {
        $db = new Connection();
        $conn = $db->getConnection();
        $stmt_del = $conn->prepare("DELETE FROM pelicula_genero WHERE pelicula_id = ?");
        $stmt_del->bind_param("i", $pelicula_id);
        $stmt_del->execute();
        $stmt_del->close();

        if (!empty($generos)) {
            $sql = "INSERT INTO pelicula_genero (pelicula_id, genero_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            foreach ($generos as $genero_id) {
                $stmt->bind_param("ii", $pelicula_id, $genero_id);
                $stmt->execute();
            }
            $stmt->close();
        }
        $db->closeConnection($conn);
    }

    public function getNombresGenerosByPelicula($pelicula_id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT generos.nombre FROM generos
                INNER JOIN pelicula_genero ON generos.id = pelicula_genero.genero_id
                WHERE pelicula_genero.pelicula_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $pelicula_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $nombres = [];
        while ($row = $result->fetch_assoc()) {
            $nombres[] = $row['nombre'];
        }
        $db->closeConnection($conn);
        return $nombres;
    }

    public function getPeliculasPorGenero($nombreGenero) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT DISTINCT p.* 
                FROM peliculas p
                INNER JOIN pelicula_genero pg ON p.id = pg.pelicula_id
                INNER JOIN generos g ON pg.genero_id = g.id
                WHERE g.nombre = ?
                ORDER BY p.titulo ASC";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombreGenero);
        $stmt->execute();
        $result = $stmt->get_result();
        $db->closeConnection($conn);
        
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /**
     * Obtener películas del mismo género (excluyendo la película actual)
     */
    public function getPeliculasMismoGenero($pelicula_id, $limite = 3) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        $sql = "SELECT DISTINCT p.* 
                FROM peliculas p
                INNER JOIN pelicula_genero pg ON p.id = pg.pelicula_id
                WHERE pg.genero_id IN (
                    SELECT genero_id 
                    FROM pelicula_genero 
                    WHERE pelicula_id = ?
                )
                AND p.id != ?
                ORDER BY RAND()
                LIMIT ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $pelicula_id, $pelicula_id, $limite);
        $stmt->execute();
        $result = $stmt->get_result();
        $peliculas = [];
        while ($row = $result->fetch_assoc()) {
            $peliculas[] = $row;
        }
        $stmt->close();
        $db->closeConnection($conn);
        
        return $peliculas;
    }

    // ========================================
    // MÉTODOS PARA ACTORES (NUEVOS)
    // ========================================
    
    /**
     * Obtener IDs de actores de una película
     * @param int $pelicula_id
     * @return array Array de actor_id
     */
    public function getActoresByPelicula($pelicula_id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT actor_id FROM pelicula_actor WHERE pelicula_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $pelicula_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $actores = [];
        while ($row = $result->fetch_assoc()) {
            $actores[] = $row['actor_id'];
        }
        $db->closeConnection($conn);
        return $actores;
    }

    /**
     * Asociar actores a una película (elimina los anteriores e inserta los nuevos)
     * @param int $pelicula_id
     * @param array $actores Array de actor_id
     * @return bool
     */
    public function asociarActores($pelicula_id, $actores) {
        $db = new Connection();
        $conn = $db->getConnection();
        
        // Eliminar actores anteriores
        $stmt_del = $conn->prepare("DELETE FROM pelicula_actor WHERE pelicula_id = ?");
        $stmt_del->bind_param("i", $pelicula_id);
        $stmt_del->execute();
        $stmt_del->close();

        // Insertar nuevos actores
        if (!empty($actores)) {
            $sql = "INSERT INTO pelicula_actor (pelicula_id, actor_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            foreach ($actores as $actor_id) {
                $stmt->bind_param("ii", $pelicula_id, $actor_id);
                $stmt->execute();
            }
            $stmt->close();
        }
        
        $db->closeConnection($conn);
        return true;
    }

    /**
     * Obtener nombres de actores de una película
     * @param int $pelicula_id
     * @return array Array de nombres de actores
     */
    public function getNombresActoresByPelicula($pelicula_id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT actores.nombre FROM actores
                INNER JOIN pelicula_actor ON actores.id = pelicula_actor.actor_id
                WHERE pelicula_actor.pelicula_id = ?
                ORDER BY actores.nombre ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $pelicula_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $nombres = [];
        while ($row = $result->fetch_assoc()) {
            $nombres[] = $row['nombre'];
        }
        $db->closeConnection($conn);
        return $nombres;
    }

    /**
     * Obtener películas por director (usando director_id)
     * @param int $director_id
     * @return array
     */
    public function getPeliculasPorDirector($director_id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM peliculas WHERE director_id = ? ORDER BY anio DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $director_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $peliculas = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $db->closeConnection($conn);
        return $peliculas;
    }

    /**
     * Obtener películas por actor (usando pelicula_actor)
     * @param int $actor_id
     * @return array
     */
    public function getPeliculasPorActor($actor_id) {
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT p.* FROM peliculas p
                INNER JOIN pelicula_actor pa ON p.id = pa.pelicula_id
                WHERE pa.actor_id = ?
                ORDER BY p.anio DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $actor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $peliculas = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $db->closeConnection($conn);
        return $peliculas;
    }
}
?>
