<?php

class Mp_mc_historicos{
	
	public $id;
	public $ano;
	public $mes;
	public $semana;
	public $totalmp;
	public $otrosmp;
	public $terminadosmp;
	public $pendientesmp;
	public $cumplimientomp;

	public $totalmc;
	public $otrosmc;
	public $terminadosmc;
	public $pendientesmc;
	public $acumuladosmc;
	public $cumplimientomc;



	
	
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
		$sql = 'SELECT * FROM mp_mc_historicos ORDER BY id DESC';
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllAno($ano) 
	{

		// Build database query
		$sql = "SELECT * FROM mp_mc_historicos
				WHERE ano=$ano
				ORDER BY semana ASC";
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllFamilia() {

		// Build database query
		$sql = 'SELECT * FROM activos_equipos GROUP BY familia';
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllOrderAsc() 
	{

		// Build database query
		$sql = 'SELECT * FROM activos_equipos ORDER BY familia ASC, nombre_equipo ASC';
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllInnerRole() {

		// Build database query
		$sql = "SELECT users.*, description_roles.description
				FROM users
				INNER JOIN description_roles ON users.type = description_roles.id";
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function verifica($ano, $mes, $semana){

			// Open database connection
			$database = new Database();

			//checar si existe el usuario en la base
			$sql = "SELECT id FROM mp_mc_historicos 
					WHERE ano=$ano
					AND mes='$mes'
					AND semana=$semana";

			// Execute database query
			$result = $database->query($sql);

			//$result = $this->sql->query($sql);
			if ($result->num_rows > 0){
				return 1;
			}
			else 
				return 0;
	}

	public static function getById($id) {
	
		// Initialize result array
		$result = array();
		
		// Build database query
		$sql = "select * from activos_equipos where id = ?";
		
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
			$statement->bind_result($id, $nombre, $familia, $tiempoBaseOperacion);
			
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
		$object->nombre = $nombre;
		$object->familia = $familia;
		$object->tiempoBaseOperacion = $tiempoBaseOperacion;
		$object->type = $type;
		return $object;
	}
		
	public function insert() {
		
		// Initialize affected rows
		$affected_rows = FALSE;
	
		// Build database query
		$sql = "insert into mp_mc_historicos (ano, mes, semana, totalmp, otrosmp, terminadosmp, pendientesmp, cumplimientomp, totalmc, otrosmc, terminadosmc, pendientesmc, acumuladosmc, cumplimientomc) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('isiiiiisiiiiis', 
				$this->ano, 
				$this->mes, 
				$this->semana, 
				$this->totalmp, 
				$this->otrosmp, 
				$this->terminadosmp, 
				$this->pendientesmp, 
				$this->cumplimientomp,
				$this->totalmc, 
				$this->otrosmc, 
				$this->terminadosmc, 
				$this->pendientesmc,
				$this->acumuladosmc, 
				$this->cumplimientomc);
			
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
		$sql = "update users set name = ?, updated = ?, email = ?, password = ?, type = ? where id = ?";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('ssssii', $this->name, $this->updated, $this->email, $this->password, $this->type, $this->id);
			
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
		$sql = "delete from activos_equipos where id = ?";
		
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