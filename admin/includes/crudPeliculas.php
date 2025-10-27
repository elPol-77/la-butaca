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
        $sql = "SELECT peliculas.*, directores.nombre as director
                FROM peliculas
                LEFT JOIN directores ON peliculas.director_id = directores.id
                ORDER BY titulo ASC";
        $result = $conn->query($sql);
        $db->closeConnection($conn);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }


	// Insertar nueva película
	public function insertarPelicula($titulo, $descripcion, $anio, $duracion, $director_id, $imagen_id, $fecha_estreno, $portada) {
		$db = new Connection();
		$conn = $db->getConnection();
		$sql = "INSERT INTO peliculas (titulo, descripcion, anio, duracion, director_id, imagen_id, fecha_estreno, portada)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ssiiisss", $titulo, $descripcion, $anio, $duracion, $director_id, $imagen_id, $fecha_estreno, $portada);
		$exito = $stmt->execute();
		$db->closeConnection($conn);
		return $exito;
	}

	// Actualizar película
	public function actualizarPelicula($id, $titulo, $descripcion, $anio, $duracion, $director_id, $imagen_id, $fecha_estreno, $portada) {
		$db = new Connection();
		$conn = $db->getConnection();
		$sql = "UPDATE peliculas
				SET titulo=?, descripcion=?, anio=?, duracion=?, director_id=?, imagen_id=?, fecha_estreno=?, portada=?
				WHERE id=?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ssiiisssi", $titulo, $descripcion, $anio, $duracion, $director_id, $imagen_id, $fecha_estreno, $portada, $id);
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
}
?>
