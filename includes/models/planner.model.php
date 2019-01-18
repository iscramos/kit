<?php

class Planner {
	
	public $id;
	public $equipo;
	public $fecha_realizacion;
	public $hora_inicio;
	public $hora_fin;
	public $frecuencia;
	
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
		$sql = 'select * from planner';
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllByQuery($consulta) 
	{

		// Build database query

		$sql = $consulta;
		return self::getBySql($sql);
	}

	public static function getAllByEquipo($equipo) 
	{

		// Build database query

		$sql = "SELECT * FROM planner WHERE activo = '$equipo' ";
		return self::getBySql($sql);
	}

	public static function getAllByOrden($columna, $orden) {

		// Build database query
		$sql = "SELECT * FROM planner ORDER BY $columna $orden";
		//echo $sql;
		// Return objects
		return self::getBySql($sql);
	}

	public static function getMaxSemana() 
	{

		// Build database query
		$sql = "SELECT * FROM calendario_nature 
				WHERE semana = (SELECT MAX(semana) FROM calendario_nature)";
		
		// Return objects
		return self::getBySql($sql);
	}


	public static function getAllMesCount($mes) 
	{

		// Build database query
		$sql = "SELECT COUNT(semana) as weeks FROM calendario_nature WHERE mes=$mes GROUP BY mes";
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllSemanasByMes($mes) 
	{

		// Build database query
		$sql = "SELECT * FROM calendario_nature WHERE mes=$mes";
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllInner() {

		// Build database query
		$sql = 'select cat_informes. * , cat_tipos.etiqueta from cat_informes INNER JOIN cat_tipos ON(cat_informes.id_cat_tipos=cat_tipos.id) order by cat_informes.nombre';
		
		
		// Return objects
		return self::getBySql($sql);
	}


	
	public static function getById($id) {
	
		// Initialize result array
		$result = array();
		
		// Build database query
		$sql = "select * from planner where id = ?";
		
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
			$statement->bind_result($id, $equipo, $fecha_realizacion, $hora_inicio, $hora_fin, $frecuencia);
			
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
		$object->equipo = $equipo;
		$object->fecha_realizacion = $fecha_realizacion;
		$object->hora_inicio = $hora_inicio;
		$object->hora_fin = $hora_fin;
		$object->frecuencia = $frecuencia;

		return $object;
	}



	public static function porGrupo($idGrupo) {

		// Open database connection
		$database = new Database();

		// Build database query  --left join comentarios co on li.id=co.idLinea
		$sql = "select * from cat_agrupado where id=$idGrupo";
		
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
		$sql = "insert into planner (equipo, fecha_realizacion, hora_inicio, hora_fin, frecuencia) values (?, ?, ?, ?, ?)";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('sssss', $this->equipo, $this->fecha_realizacion, $this->hora_inicio, $this->hora_fin, $this->frecuencia);
			
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
		$sql = "update planner set  fecha_realizacion = ?, hora_inicio = ?, hora_fin = ?, frecuencia = ? where id = ?";
				
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('ssssi',  $this->fecha_realizacion, $this->hora_inicio, $this->hora_fin, $this->frecuencia, $this->id);
			
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
		$sql = "delete from planner where id = ?";
		
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