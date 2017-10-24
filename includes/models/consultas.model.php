<?php

class Consultas {
	
	public $id;
	public $id_cat_informe;
	public $id_cat_rubro;
	public $id_cat_agrupado;
	public $ID_usuario;
	public $etiquetaArchivo;
	public $url;
	public $estatus;
	public $archivo;
	public $nomArchivo;
	public $fecha;
	
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
		$sql = 'select * from informe_archivo order by id';
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllInner() {

		// Build database query
		$sql = 'SELECT informe_archivo.*, 
				cat_informes.nombre, cat_informes.id_cat_tipos, 
				cat_tipos.etiqueta, 
				cat_rubro.rubro,
				usuarios.nombre as nombre_usuario,
				cat_agrupado.nombre_del_grupo
				from informe_archivo 
				inner join cat_informes on informe_archivo.id_cat_informe = cat_informes.id
				inner join cat_tipos on cat_informes.id_cat_tipos = cat_tipos.id
				inner join usuarios on informe_archivo.ID_usuario = usuarios.id
				inner join cat_rubro on informe_archivo.id_cat_rubro = cat_rubro.id
				inner join cat_agrupado on informe_archivo.id_cat_agrupado = cat_agrupado.id
				order by informe_archivo.fecha desc';
				
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllArchivo() {

		// Build database query
		$sql = "SELECT informe_archivo.*, cat_rubro.id as idr, cat_rubro.rubro  
		FROM informe_archivo
		inner join cat_rubro on informe_archivo.id_cat_rubro = cat_rubro.id 
		where informe_archivo.archivo <> '' and informe_archivo.estatus='True'";
				
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getByConsultaModulo($idConsulta) {

		// Build database query
		$sql = "SELECT * FROM informe_archivo
				WHERE id=$idConsulta";
				
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllArchivoID($idInforme, $idRubro) {

		// Build database query
		$sql = "SELECT informe_archivo. * , cat_rubro.id AS idr, cat_rubro.rubro, cat_informes.id AS IDI, cat_informes.nombreCorto
FROM informe_archivo
INNER JOIN cat_rubro ON informe_archivo.id_cat_rubro = cat_rubro.id
INNER JOIN cat_informes ON informe_archivo.id_cat_informe = cat_informes.id

WHERE informe_archivo.estatus =  'True'
AND informe_archivo.id_cat_informe =$idInforme
AND informe_archivo.id_cat_rubro =$idRubro
ORDER BY informe_archivo.id_cat_agrupado";
				
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllArchivoIDMod($idInforme) {

		// Build database query
		$sql = "SELECT informe_archivo. *, cat_informes.id AS IDI, cat_informes.nombreCorto
FROM informe_archivo

INNER JOIN cat_informes ON informe_archivo.id_cat_informe = cat_informes.id

WHERE informe_archivo.estatus =  'True'
AND informe_archivo.id_cat_informe =$idInforme

ORDER BY informe_archivo.id_cat_agrupado";
				
		
		// Return objects
		return self::getBySql($sql);
	}

	
	public static function getById($id) {
	
		// Initialize result array
		$result = array();
		
		// Build database query
		$sql = "select * from cat_tipos where id = ?";
		
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
			$statement->bind_result($id, $etiqueta);
			
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
		$object->etiqueta = $etiqueta;
		return $object;
	}

	public static function porConsulta($idConsulta) {

		// Open database connection
		$database = new Database();

		// Build database query  --left join comentarios co on li.id=co.idLinea
		$sql = "SELECT informe_archivo.*, 
				cat_informes.nombre, cat_informes.id_cat_tipos, 
				cat_tipos.etiqueta, 
				cat_rubro.rubro,
				usuarios.nombre as nombre_usuario,
				cat_agrupado.nombre_del_grupo
				from informe_archivo 
				inner join cat_informes on informe_archivo.id_cat_informe = cat_informes.id
				inner join cat_tipos on cat_informes.id_cat_tipos = cat_tipos.id
				inner join usuarios on informe_archivo.ID_usuario = usuarios.id
				inner join cat_rubro on informe_archivo.id_cat_rubro = cat_rubro.id
				inner join cat_agrupado on informe_archivo.id_cat_agrupado = cat_agrupado.id
				where informe_archivo.id = $idConsulta";
		
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

public static function porConsultaModulo($idConsulta) {

		// Open database connection
		$database = new Database();

		// Build database query  --left join comentarios co on li.id=co.idLinea
		$sql = "SELECT informe_archivo.*, 
				cat_informes.nombre, cat_informes.id_cat_tipos, 
				cat_tipos.etiqueta, 
				
				usuarios.nombre as nombre_usuario,
				cat_agrupado.nombre_del_grupo
				from informe_archivo 
				inner join cat_informes on informe_archivo.id_cat_informe = cat_informes.id
				inner join cat_tipos on cat_informes.id_cat_tipos = cat_tipos.id
				inner join usuarios on informe_archivo.ID_usuario = usuarios.id
				
				inner join cat_agrupado on informe_archivo.id_cat_agrupado = cat_agrupado.id
				where informe_archivo.id = $idConsulta";
		
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

public static function porInforme($idInf) {

		// Open database connection
		$database = new Database();

		// Build database query  --left join comentarios co on li.id=co.idLinea
		$sql = "SELECT informe_archivo.*, 
				cat_informes.nombre, cat_informes.id_cat_tipos, 
				cat_tipos.etiqueta, 
				cat_rubro.rubro,
				usuarios.nombre as nombre_usuario,
				cat_agrupado.nombre_del_grupo
				from informe_archivo 
				inner join cat_informes on informe_archivo.id_cat_informe = cat_informes.id
				inner join cat_tipos on cat_informes.id_cat_tipos = cat_tipos.id
				inner join usuarios on informe_archivo.ID_usuario = usuarios.id
				inner join cat_rubro on informe_archivo.id_cat_rubro = cat_rubro.id
				inner join cat_agrupado on informe_archivo.id_cat_agrupado = cat_agrupado.id
				where informe_archivo.id_cat_informe=$idInf
				order by informe_archivo.fecha desc";
		
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

public static function porInformeModulos($idInf) {

		// Open database connection
		$database = new Database();

		// Build database query  --left join comentarios co on li.id=co.idLinea
		$sql = "SELECT informe_archivo.*, 
				cat_informes.nombre, cat_informes.id_cat_tipos, 
				cat_tipos.etiqueta, 
				
				usuarios.nombre as nombre_usuario,
				cat_agrupado.nombre_del_grupo
				from informe_archivo 
				inner join cat_informes on informe_archivo.id_cat_informe = cat_informes.id
				inner join cat_tipos on cat_informes.id_cat_tipos = cat_tipos.id
				inner join usuarios on informe_archivo.ID_usuario = usuarios.id
				
				inner join cat_agrupado on informe_archivo.id_cat_agrupado = cat_agrupado.id
				where informe_archivo.id_cat_informe=$idInf
				order by informe_archivo.fecha desc";
		
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
		$sql = "insert into informe_archivo (id_cat_informe, id_cat_rubro, id_cat_agrupado, ID_usuario, etiquetaArchivo, url, estatus, archivo, nomArchivo,fecha) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			//die($this->id_cat_informe." ". $this->id_cat_rubro." ". $this->id_cat_agrupado." ".$this->ID_usuario." ".$this->etiquetaArchivo." ".$this->archivo." ".$this->fecha);
			// Bind parameters
			$statement->bind_param('iiiissssss', $this->id_cat_informe, $this->id_cat_rubro, $this->id_cat_agrupado, $this->ID_usuario, $this->etiquetaArchivo, $this->url, $this->estatus, $this->archivo, $this->nomArchivo, $this->fecha); //to check errors;
			
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
		$sql = "update informe_archivo set id_cat_informe = ?, id_cat_rubro = ?, id_cat_agrupado = ?, ID_usuario = ?, etiquetaArchivo = ?, url = ?, estatus = ?, archivo = ?, nomArchivo = ?, fecha = ? where id = ?";
				
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			//die($this->id_cat_informe." ". $this->id_cat_rubro." ". $this->id_cat_agrupado." ".$this->ID_usuario." ".$this->etiquetaArchivo." ".$this->archivo." ".$this->fecha);
			$statement->bind_param('iiiissssssi', $this->id_cat_informe, $this->id_cat_rubro, $this->id_cat_agrupado, $this->ID_usuario, $this->etiquetaArchivo, $this->url, $this->estatus, $this->archivo, $this->nomArchivo, $this->fecha, $this->id);
			
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
		$sql = "delete from informe_archivo where id = ?";
		
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