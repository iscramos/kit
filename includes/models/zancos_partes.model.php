<?php

class Zancos_partes {
	
	public $id;
	public $parte;
	public $descripcion;
	public $img;

	
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
		$sql = 'select * from zancos_partes ORDER BY id_registro desc';
		
		// Return objects
		return self::getBySql($sql);
	}


	public static function getAllByQuery($consulta) 
	{

		// Build database query

		$sql = $consulta;
		return self::getBySql($sql);
	}

	public static function getAllByOrden($campo, $orden) {

		// Build database query
		$sql = "SELECT * FROM zancos_partes ORDER BY $campo $orden";
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllInner() 
	{

		// Build database query
		$sql = "SELECT zancos_partes.*, zancos_tamanos.tamano as tamano_descripcion, zancos_tamanos.limite_semana as limite_semana 
				FROM zancos_partes
				INNER JOIN zancos_tamanos ON zancos_partes.tamano = zancos_tamanos.id";
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	
	

	public static function getAllMax() {

		// Build database query
		$sql = 'select MAX(id) as id from usuarios';
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllLastInsert() {

		// Build database query
		$sql = "SELECT MAX(id_registro) AS ultimo FROM zancos_partes";
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllInformeValidador($informe) 
	{

		// Build database query
		$sql = "SELECT usuarios . * , usuario_cat_informe . * 
				FROM usuarios
				INNER JOIN usuario_cat_informe ON usuarios.id = usuario_cat_informe.ID_usuario
				WHERE usuario_cat_informe.id_cat_informe =$informe";
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllUsuarioCatInfo($idU) {

		// Build database query
		$sql = 'SELECT usuarios.*, usuario_cat_informe.id as iduc, usuario_cat_informe.id_cat_informe as idci, usuario_cat_informe.ID_usuario, cat_informes.id as idi, cat_informes.nombreCorto
				FROM usuarios
				INNER JOIN usuario_cat_informe on usuarios.id = usuario_cat_informe.ID_usuario
				LEFT JOIN cat_informes on usuario_cat_informe.id_cat_informe = cat_informes.id
				where usuarios.id=$idU';
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getById($id) {
	
		// Initialize result array
		$result = array();
		
		// Build database query
		$sql = "select * from zancos_partes where id = ?";
		
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
			$statement->bind_result($id, $parte, $descripcion_problema);
			
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
		$object->no_zanco = $no_zanco;
		$object->tamano = $tamano;
		return $object;
	}
	



		
	public function insert() {
		
		// Initialize affected rows
		$affected_rows = FALSE;
	
		// Build database query
		$sql = "insert into zancos_partes (no_zanco, tamano, tiempo_limite, tipo_movimiento, gh, zona, fecha_activacion_o_baja, ns_salida_lider, nombre_lider_salida, fecha_salida, wk_salida,
	fecha_entrega, wk_entrega, fecha_servicio, descripcion_problema) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('iiiisssissisiss', $this->no_zanco, $this->tamano, $this->tiempo_limite, $this->tipo_movimiento, $this->gh, $this->zona, $this->fecha_activacion_o_baja, $this->ns_salida_lider, $this->nombre_lider_salida, $this->fecha_salida, $this->wk_salida,
	$this->fecha_entrega, $this->wk_entrega, $this->fecha_servicio, $this->descripcion_problema);
			
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
		$sql = "update zancos_partes set no_zanco = ?, tamano = ?, tiempo_limite = ?, tipo_movimiento = ?, gh = ?, zona = ?, fecha_activacion_o_baja = ?, ns_salida_lider = ?, nombre_lider_salida = ?, fecha_salida = ?, wk_salida = ?, fecha_entrega = ?, wk_entrega = ?, fecha_servicio = ?, descripcion_problema = ? where id_registro = ?";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('iiiisssissisissi', $this->no_zanco, $this->tamano, $this->tiempo_limite, $this->tipo_movimiento, $this->gh, $this->zona, $this->fecha_activacion_o_baja, $this->ns_salida_lider, $this->nombre_lider_salida, $this->fecha_salida, $this->wk_salida,
	$this->fecha_entrega, $this->wk_entrega, $this->fecha_servicio, $this->descripcion_problema, $this->id_registro);
			
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
		$sql = "delete from zancos_partes where id = ?";
		
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
		if (isset($this->id_registro)) {	
		
			// Return update when id exists
			return $this->update();
			
		} else {
		
			// Return insert when id does not exists
			return $this->insert();
		}
	}	
}