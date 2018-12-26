<?php

class Recursos_bonos_apoyos {
	
	public $id;
	public $codigo_supervisor;
	public $nombre_supervisor;
	public $codigo;
	public $nombre;
	public $semana;
	public $id_actividad;
	public $nombre_actividad;
	public $pago_por;
	public $pago_especial;
	public $fecha;
	public $surcos_cajas;
	public $tiempo;
	public $hora_inicio;
	public $hora_fin;
	public $gh;
	public $zona;
	public $surcos_reales;
	public $surcos_hora;
	public $eficiencia;
	public $precio_actividad;
	public $subpago;
	public $lider;
	public $tiempo_muerto;
	public $observacion;
	
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
		$sql = 'select * from recursos_bonos_apoyos';
		
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
		$sql = "SELECT * FROM recursos_bonos_apoyos ORDER BY $columna $orden";
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
		$sql = "select * from recursos_bonos_apoyos where id = ?";
		
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
			$statement->bind_result($id, $codigo_supervisor, $nombre_supervisor, $codigo, $nombre, $semana, $id_actividad, $nombre_actividad, $pago_por, $pago_especial, $fecha, $surcos_cajas, $tiempo, $hora_inicio, $hora_fin, $gh, $zona, $surcos_reales, $surcos_hora, $objetivo_hora, $eficiencia, $precio_actividad, $subpago, $lider, $tiempo_muerto, $observacion);
			
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
		$object->codigo_supervisor = $codigo_supervisor;
		$object->nombre_supervisor = $nombre_supervisor;
		$object->codigo = $codigo;
		$object->nombre = $nombre;
		$object->semana = $semana;
		$object->id_actividad = $id_actividad;
		$object->nombre_actividad = $nombre_actividad;
		$object->pago_por = $pago_por;
		$object->pago_especial = $pago_especial;
		$object->fecha = $fecha;
		$object->surcos_cajas = $surcos_cajas;
		$object->tiempo = $tiempo;
		$object->hora_inicio = $hora_inicio;
		$object->hora_fin = $hora_fin;
		$object->gh = $gh;
		$object->zona = $zona;
		$object->surcos_reales = $surcos_reales;
		$object->surcos_hora = $surcos_hora;
		$object->objetivo_hora = $objetivo_hora;
		$object->eficiencia = $eficiencia;
		$object->precio_actividad = $precio_actividad;
		$object->subpago = $subpago;
		$object->lider = $lider;
		$object->tiempo_muerto = $tiempo_muerto;
		$object->observacion = $observacion;
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
		$sql = "insert into recursos_bonos_apoyos (codigo_supervisor, nombre_supervisor, codigo, nombre, semana, id_actividad, nombre_actividad, pago_por, pago_especial, fecha, surcos_cajas, tiempo, hora_inicio, hora_fin, gh, zona, surcos_reales, surcos_hora, objetivo_hora, eficiencia, precio_actividad, subpago, lider, tiempo_muerto, observacion) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('isisiissssssssssssssssiss', $this->codigo_supervisor, $this->nombre_supervisor, $this->codigo, $this->nombre, $this->semana, $this->id_actividad, $this->nombre_actividad, $this->pago_por, $this->pago_especial, $this->fecha, $this->surcos_cajas, $this->tiempo, $this->hora_inicio, $this->hora_fin, $this->gh, $this->zona, $this->surcos_reales, $this->surcos_hora, $this->objetivo_hora, $this->eficiencia, $this->precio_actividad, $this->subpago, $this->lider, $this->tiempo_muerto, $this->observacion);
			
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
		$sql = "update recursos_bonos_apoyos set pago_especial = ?, surcos_cajas = ?, tiempo = ?, hora_inicio = ?, hora_fin = ?, gh = ?, surcos_reales = ?, surcos_hora = ?, eficiencia = ?, subpago = ?, tiempo_muerto = ?, observacion = ? where id = ?";
				
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('ssssssssssssi',  $this->pago_especial, $this->surcos_cajas, $this->tiempo, $this->hora_inicio, $this->hora_fin, $this->gh, $this->surcos_reales, $this->surcos_hora, $this->eficiencia, $this->subpago, $this->tiempo_muerto, $this->observacion, $this->id);
			
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
		$sql = "delete from recursos_bonos_apoyos where id = ?";
		
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