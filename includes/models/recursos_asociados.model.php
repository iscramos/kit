<?php

class Recursos_asociados {

	public $id;
	public $tipo;
	public $rango;
	public $codigo;
	public $nombre;
	public $sexo;
	public $departamento;
	public $puesto;
	public $f_nacimiento;
	public $f_ingreso;
	public $activo;
	public $lider;
	public $zona;
	public $gh;
	
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
		$sql = 'select * from recursos_asociados';
		
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
		$sql = "SELECT * FROM recursos_asociados ORDER BY $columna $orden";
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
		$sql = "select * from recursos_asociados where id = ?";
		
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
			$statement->bind_result($id, $tipo, $rango, $codigo, $nombre, $sexo, $departamento, $puesto, $f_nacimiento, $f_ingreso, $activo, $lider, $zona, $gh);
			
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
		$object->tipo = $tipo;
		$object->rango = $rango;
		$object->codigo = $codigo;
		$object->nombre = $nombre;
		$object->sexo = $sexo;
		$object->departamento = $departamento;
		$object->puesto = $puesto;
		$object->f_nacimiento = $f_nacimiento;
		$object->f_ingreso = $f_ingreso;
		$object->activo = $activo;
		$object->lider = $lider;
		$object->zona = $zona;
		$object->gh = $gh;

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
		$sql = "insert into recursos_asociados (tipo, rango, codigo, nombre, sexo, departamento, puesto, f_nacimiento, f_ingreso, activo, lider, zona, gh) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('ssissiississs', $this->tipo, $this->rango, $this->codigo, $this->nombre, $this->sexo, $this->departamento, $this->puesto, $this->f_nacimiento, $this->f_ingreso, $this->activo, $this->lider, $this->zona, $this->gh);
			
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
		$sql = "update recursos_asociados set tipo = ?, rango = ?, codigo = ?, nombre = ?, sexo = ?, departamento = ?, puesto = ?, f_nacimiento = ?, f_ingreso = ?, activo = ?, lider = ?, zona = ?, gh = ? where id = ?";
				
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('ssissiississsi', $this->tipo, $this->rango, $this->codigo, $this->nombre, $this->sexo, $this->departamento, $this->puesto, $this->f_nacimiento, $this->f_ingreso, $this->activo, $this->lider, $this->zona, $this->gh, $this->id);
			
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
		$sql = "delete from recursos_asociados where id = ?";
		
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