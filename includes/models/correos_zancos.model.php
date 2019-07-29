<?php

class Correos_zancos {
	
	public $fecha_envio;

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
		$sql = 'select * from correos_zancos';
		
		// Return objects
		return self::getBySql($sql);
	}
	
	public static function getAllByQuery($consulta) 
	{

		// Build database query

		$sql = $consulta;
		
		
		return self::getBySql($sql);
	}

	public static function getAllByOrden($columna, $orden) {

		// Build database query
		$sql = "SELECT * FROM correos_zancos ORDER BY $columna $orden";
		//echo $sql;
		// Return objects
		return self::getBySql($sql);
	}


	
	public static function getByFechaEnvio($fecha_envio) {
	
		// Initialize result array
		$result = array();
		
		// Build database query
		$sql = "select fecha_envio from correos_zancos where fecha_envio = ?";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('s', $fecha_envio);
			
			// Execute statement
			$statement->execute();
			
			// Bind variable to prepared statement
			$statement->bind_result($fecha_envio);
			
			// Populate bind variables
			$statement->fetch();
		
			// Close statement
			$statement->close();
		}
		
		// Close database connection
		$database->close();
		
		// Build new object
		$object = new self;
		$object->fecha_envio = $fecha_envio;
		return $object;
	}




	public function insert() {
		
		// Initialize affected rows
		$affected_rows = FALSE;
	
	
		// Build database query
		$sql = "insert into correos_zancos (fecha_envio) values (?)";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('s', $this->fecha_envio);
			
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
		$sql = "update cat_agrupado set nombre_del_grupo = ? where id = ?";
				
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('si', $this->nombre_del_grupo, $this->id);
			
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
		$sql = "delete from cat_agrupado where id = ?";
		
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

	public function inserta_dura() 
	{

		// Initialize affected rows
		$affected_rows = FALSE;
	
		// Build database query
		$sql = "INSERT INTO correos_zancos values $this->q";

		//echo $sql;
		
		// Open database connection
		$database = new Database();
		
		mysqli_query($database, $sql) or die(mysqli_error($database));


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