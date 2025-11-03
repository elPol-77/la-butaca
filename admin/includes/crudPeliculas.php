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



	// Insertar nueva película
	public function insertarPelicula($titulo, $descripcion, $anio, $duracion, $director_id, $plataforma_id, $imagen, $fecha_estreno) {
		$db = new Connection();
		$conn = $db->getConnection();
		$sql = "INSERT INTO peliculas (titulo, descripcion, anio, duracion, director_id, plataforma_id, imagen, fecha_estreno, created_at)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
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



}
?>