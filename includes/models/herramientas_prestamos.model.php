<?php

class Herramientas_prestamos {
	
	public $id;
	public $id_herramienta;
	public $id_almacen;
	public $id_categoria;
	public $fecha_prestamo;
	public $fecha_regreso;
	public $estatus;
	public $noAsociado;
	public $nombre;
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
		$sql = 'select * from herramientas_prestamos';
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllByIdHerramienta($id_herramienta) 
	{

		// Build database query
		$sql = "SELECT herramientas_prestamos.*, herramientas_herramientas.descripcion as descripcion
				FROM herramientas_prestamos
				INNER JOIN herramientas_herramientas ON herramientas_prestamos.id_herramienta = herramientas_herramientas.id
				WHERE herramientas_prestamos.id_herramienta = $id_herramienta ORDER BY herramientas_prestamos.id DESC";
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllInnerHerramientas() 
	{

		// Build database query
		$sql = "SELECT herramientas_prestamos.*, herramientas_herramientas.descripcion as descripcion
				FROM herramientas_prestamos
				INNER JOIN herramientas_herramientas ON herramientas_prestamos.id_herramienta = herramientas_herramientas.id
				ORDER BY herramientas_prestamos.id DESC";
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllByCategoriaCount($id_categoria) 
	{

		// Build database query
		$sql = "SELECT count(*) AS nStock FROM herramientas_herramientas WHERE id_categoria=$id_categoria";
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}


	public static function getAllMaxHerramienta($id_herramienta) {

		// Build database query
		$sql = "SELECT id, estatus FROM herramientas_prestamos WHERE id_herramienta = $id_herramienta ORDER BY id DESC LIMIT 1";
		//echo $sql;
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
		$sql = "select * from herramientas_prestamos where id = ?";
		
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
			$statement->bind_result($id, $id_herramienta, $id_almacen, $id_categoria, $fecha_prestamo, $fecha_regreso, $estatus, $noAsociado, $nombre, $observacion);
			
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
		$object->id_herramienta = $id_herramienta;
		$object->id_almacen = $id_almacen;
		$object->id_categoria = $id_categoria;
		$object->fecha_prestamo = $fecha_prestamo;
		$object->fecha_regreso = $fecha_regreso;
		$object->estatus = $estatus;
		$object->noAsociado = $noAsociado;
		$object->nombre = $nombre;
		$object->observacion = $observacion;

		return $object;
	}
	
	/*public static function usuariosPorLinea($idLinea) {

		// Open database connection
		$database = new Database();

		// Build database query  --left join comentarios co on li.id=co.idLinea
		$sql = "select us.id as id, email, us.nombre as nombre, ul.id as idU from usuarioslinea ul inner join usuarios us on ul.idUsuario=us.id left join lineas li on ul.idLinea=li.id  where ul.idLinea=$idLinea";
		
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
	}*/
	
	public static function buscaUsuarioByEmail($correo){
		// Open database connection
		$database = new Database();

		//checar si existe el usuario en la base
		$sql = "SELECT id, name, email, type FROM users WHERE email='".$correo."'";

		// Execute database query
		$result = $database->query($sql);

		//$result = $this->sql->query($sql);
		if ($result->num_rows > 0){
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
		else 
			return 0;
	}

	public static function buscaUsuarioByEmailPassword($email, $password){
		// Open database connection
		$database = new Database();

		//checar si existe el usuario en la base
		$sql = "SELECT id, name, email, type FROM users WHERE email='$email' AND password='$password'";

		// Execute database query
		$result = $database->query($sql);

		//$result = $this->sql->query($sql);
		if ($result->num_rows > 0){
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
		else 
			return 0;
	}
	
	
	public static function buscarUsuario($correo){

			// Open database connection
			$database = new Database();

			//checar si existe el usuario en la base
			$sql = "SELECT id FROM usuarios WHERE email='".$correo."'";

			// Execute database query
			$result = $database->query($sql);

			//$result = $this->sql->query($sql);
			if ($result->num_rows > 0){
				return 1;
			}
			else 
				return 0;
	}
		
	public function insert() {
		
		// Initialize affected rows
		$affected_rows = FALSE;
	
		// Build database query
		$sql = "insert into herramientas_prestamos (id_herramienta, id_almacen, id_categoria, fecha_prestamo, estatus, noAsociado, nombre) values (?, ?, ?, ?, ?, ?, ?)";
		//die("lleog");
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('iiisiis', $this->id_herramienta, $this->id_almacen, $this->id_categoria, $this->fecha_prestamo, $this->estatus, $this->noAsociado, $this->nombre);
			
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
		$sql = "update herramientas_prestamos set fecha_regreso = ?, estatus = ?, observacion = ? where id = ?";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('sisi', $this->fecha_regreso, $this->estatus, $this->observacion, $this->id);
			
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
		$sql = "delete from herramientas_prestamos where id = ?";
		
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