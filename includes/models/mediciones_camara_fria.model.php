<?php

class Mediciones_camara_fria {
	
	public $id;
	public $temp_con_tomate;
	public $hr_vacia;
	public $hr_con_tomate;
	public $temp_tomate_entrada;
	public $temp_tomate_salida;
	public $temp_externa;
	public $puerta_cerrada;
	public $lona_bien_ubicada;
	public $e_75_encendido;
	public $fecha_medicion;
	public $hora;
	public $num_tarimas;
	public $temp_vacia;


	
	public static function getBySql($sql) {
		
		// Open database connection
		$database = new Database();
		
		// Execute database query
		$result = $database->query($sql);
		
		// Initialize object array
		$objects = array();
		
		// Fetch objects from database cursor
		while ($object = $result->fetch_object()) {
			$objects[] = $object;
		}
		
		// Close database connection
		$database->close();

		// Return objects
		return $objects;	
	}
	
	
	public static function getAll() {

		// Build database query
		$sql = "SELECT * from mediciones_camara_fria ORDER BY fecha_medicion DESC";
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllInnerActivoEquipo() {

		// Build database query
		$sql = "SELECT mpideales.*, activos_equipos.id as activo, activos_equipos.nombre_equipo, activos_equipos.familia
				FROM mpideales
				INNER JOIN activos_equipos ON mpideales.id_activo_equipo = activos_equipos.id
				ORDER BY mpideales.id DESC";
		
		// Return objects
		return self::getBySql($sql);
	}

	/*public static function getAllInnerActivos($equipo, $mes, $ano) {

		// Build database query
		$sql = "SELECT mpideales.*, activos_equipos.nombre_equipo as nombre_equipo,  ordenesots.fecha_informe FROM mpideales 
				INNER JOIN activos_equipos ON mpideales.id_activo_equipo = activos_equipos.id 
				INNER JOIN ordenesots ON activos_equipos.nombre_equipo = ordenesots.equipo
				WHERE ordenesots.equipo = '$equipo' AND date_format(ordenesots.fecha_informe, '%Y-%m') = '$ano-$mes' AND ordenesots.tipo='Mant. preventivo'";
		die($sql);
		// Return objects
		return self::getBySql($sql);
	}*/

	public static function getAllInnerActivos($equipo, $mes, $ano) {

		// Build database query
		$sql = "SELECT mpideales.*, activos_equipos.nombre_equipo as nombre_equipo, activos_equipos.familia as familia, ordenesots.fecha_informe FROM mpideales 
				INNER JOIN activos_equipos ON mpideales.id_activo_equipo = activos_equipos.id 
				INNER JOIN ordenesots ON activos_equipos.nombre_equipo = ordenesots.equipo
				WHERE ordenesots.equipo = '$equipo' AND date_format(ordenesots.fecha_informe, '%Y-%m') = '$ano-$mes' AND ordenesots.tipo='Mant. preventivo' GROUP BY ordenesots.equipo";
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}
	
	
	public static function getById($id) {
	
		// Initialize result array
		$result = array();
		
		// Build database query
		$sql = "select * from mpideales where id = ?";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('i', $id);
			
			// Execute statement
			$statement->execute();
			
			// Bind variable to prepared statement
			$statement->bind_result($id, $id_activo_equipo, $A, $B, $C, $D, $E, $F);
			
			// Populate bind variables
			$statement->fetch();
		
			// Close statement
			$statement->close();
		}
		
		// Close database connection
		$database->close();
		
		// Build new object
		$object = new self;
		$object->id = $id;
		$object->id_activo_equipo = $id_activo_equipo;
		$object->A = $A;
		$object->B = $B;
		$object->C = $C;
		$object->D = $D;
		$object->E = $E;
		$object->F = $F;
		return $object;
	}

	public static function porTipo($idTipo) {

		// Open database connection
		$database = new Database();

		// Build database query  --left join comentarios co on li.id=co.idLinea
		$sql = "select * from cat_tipos where id=$idTipo";
		
		// Execute database query		
		$result = $database->query($sql);
		
		// Initialize object array
		$objects = array();
		
		// Fetch objects from database cursor
		while ($object = $result->fetch_object()) {
			$objects[] = $object;
		}
		
		// Close database connection
		$database->close();

		// Return objects
		return $objects;
	}

	public function insert() {
		
		// Initialize affected rows
		$affected_rows = FALSE;
	
	
		// Build database query
		$sql = "insert into mediciones_camara_fria (temp_con_tomate, hr_vacia, hr_con_tomate, temp_tomate_entrada, temp_tomate_salida, temp_externa, puerta_cerrada, lona_bien_ubicada, e_75_encendido, fecha_medicion, num_tarimas, temp_vacia) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('ssssssiiisis', $this->temp_con_tomate, $this->hr_vacia, $this->hr_con_tomate, $this->temp_tomate_entrada, $this->temp_tomate_salida, $this->temp_externa, $this->puerta_cerrada, $this->lona_bien_ubicada, $this->e_75_encendido, $this->fecha_medicion, $this->num_tarimas, $this->temp_vacia);
			
			// Execute statement
			$statement->execute();
			
			// Get affected rows
			$affected_rows = $database->affected_rows;
				
			// Close statement
			$statement->close();
		}
		
		// Close database connection
		$database->close();

		// Return affected rows
		return $affected_rows;			
	}

	public function update() {
	
		// Initialize affected rows
		$affected_rows = FALSE;
	
		// Build database query
		$sql = "update mpideales set id_activo_equipo = ?, A = ?, B = ?, C = ?, D = ?, E = ?, F = ? where id = ?";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('issssssi', $this->id_activo_equipo, $this->A, $this->B, $this->C, $this->D, $this->E, $this->F, $this->id);
			
			// Execute statement
			$statement->execute();
			
			// Get affected rows
			$affected_rows = $database->affected_rows;
				
			// Close statement
			$statement->close();
		}
		
		// Close database connection
		$database->close();

		// Return affected rows
		return $affected_rows;			

	}

	public function delete() {

		// Initialize affected rows
		$affected_rows = FALSE;
	
		// Build database query
		$sql = "delete from mpideales where id = ?";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('i', $this->id);
			
			// Execute statement
			$statement->execute();
			
			// Get affected rows
			$affected_rows = $database->affected_rows;
				
			// Close statement
			$statement->close();
		}
		
		// Close database connection
		$database->close();

		// Return affected rows
		return $affected_rows;			
	
	}

	public function save() {
	
		// Check object for id
		if (isset($this->id)) {	
		
			// Return update when id exists
			return $this->update();
			
		} else {
		
			// Return insert when id does not exists
			return $this->insert();
		}
	}	

}