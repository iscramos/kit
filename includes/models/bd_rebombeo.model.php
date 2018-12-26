<?php

class Bd_rebombeo {
	
	public $id;
	public $equipo;
	public $tipo;
	public $fechaLectura;
	public $voltaje_l1_l2;
	public $voltaje_l2_l3;
	public $voltaje_l1_l3;
	public $amperaje_l1;
	public $amperaje_l2;
	public $amperaje_l3;
	public $caudal;
	public $nivel_estatico;
	public $nivel_dinamico;
	public $hp;
	public $volt_nomi_bajo;
	public $volt_nomi_alto;
	public $amp_max;
	public $amp_min;
	public $m_consumidos;


	
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
		$sql = "SELECT * from bd_rebombeo ORDER BY fechaLectura DESC";
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllByQuery($consulta) 
	{

		// Build database query

		$sql = $consulta;
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
		$sql = "select * from bd_rebombeo where id = ?";
		
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
			$statement->bind_result($id, $tipo, $equipo, $fechaLectura, $voltaje_l1_l2, $voltaje_l2_l3, $voltaje_l1_l3, $amperaje_l1, $amperaje_l2, $amperaje_l3, $caudal, $nivel_estatico, $nivel_dinamico, $hp, $volt_nomi_bajo, $volt_nomi_alto, $amp_max, $amp_min, $m_consumidos);
			
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
		$object->tipo = $tipo;
		$object->fechaLectura = $fechaLectura;
		$object->voltaje_l1_l2 = $voltaje_l1_l2;
		$object->voltaje_l2_l3 = $voltaje_l2_l3;
		$object->voltaje_l1_l3 = $voltaje_l1_l3;
		$object->amperaje_l1 = $amperaje_l1;
		$object->amperaje_l2 = $amperaje_l2;
		$object->amperaje_l3 = $amperaje_l3;
		$object->caudal = $caudal;
		$object->nivel_estatico = $nivel_estatico;
		$object->nivel_dinamico = $nivel_dinamico;
		$object->hp = $hp;
		$object->volt_nomi_bajo = $volt_nomi_bajo;
		$object->volt_nomi_alto = $volt_nomi_alto;
		$object->amp_max = $amp_max;
		$object->amp_min = $amp_min;
		$object->m_consumidos = $m_consumidos;
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
		$sql = "insert into bd_rebombeo (equipo, tipo, fechaLectura, voltaje_l1_l2, voltaje_l2_l3, voltaje_l1_l3, amperaje_l1, amperaje_l2, amperaje_l3, caudal, nivel_estatico, nivel_dinamico, hp, volt_nomi_bajo, volt_nomi_alto, amp_max, amp_min, m_consumidos) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('sissssssssssssssss', $this->equipo, $this->tipo, $this->fechaLectura, $this->voltaje_l1_l2, $this->voltaje_l2_l3, $this->voltaje_l1_l3, $this->amperaje_l1, $this->amperaje_l2, $this->amperaje_l3, $this->caudal, $this->nivel_estatico, $this->nivel_dinamico, $this->hp, $this->volt_nomi_bajo, $this->volt_nomi_alto, $this->amp_max, $this->amp_min, $this->m_consumidos);
			
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
		$sql = "update bd_rebombeo set voltaje_l1_l2 = ?, voltaje_l2_l3 = ?, voltaje_l1_l3 = ?, amperaje_l1 = ?, amperaje_l2 = ?, amperaje_l3 = ?, caudal = ?, nivel_estatico = ?, nivel_dinamico = ?, hp = ?, volt_nomi_bajo = ?, volt_nomi_alto = ?, amp_max = ?, amp_min = ?, m_consumidos = ? where id = ?";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			//die("entro");
			// Bind parameters
			$statement->bind_param('sssssssssssssssi', $this->voltaje_l1_l2, $this->voltaje_l2_l3, $this->voltaje_l1_l3, $this->amperaje_l1, $this->amperaje_l2, $this->amperaje_l3, $this->caudal, $this->nivel_estatico, $this->nivel_dinamico, $this->hp, $this->volt_nomi_bajo, $this->volt_nomi_alto, $this->amp_max, $this->amp_min, $this->m_consumidos, $this->id);
			
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
		$sql = "delete from bd_rebombeo where id = ?";
		
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