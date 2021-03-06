<?php

class almacen_inventario {
	
	public $id;
	public $codigo;
	public $descripcion;
	public $clase;
	public $cantidad_minima;
	public $cantidad_maxima;
	public $stock;
	public $unidad;
	public $precio_unitario;
	public $estatus;

	
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
		$sql = 'select * from almacen_inventario';
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllInnerAlmacenAndCategoria($id_almacen, $id_categoria) {

		// Build database query
		$sql = "SELECT herramientas_herramientas.*, herramientas_categorias.categoria as categoria, herramientas_almacenes.descripcion as descripcion_almacen
				FROM herramientas_herramientas
				INNER JOIN herramientas_categorias ON herramientas_herramientas.id_categoria = herramientas_categorias.id
				INNER JOIN herramientas_almacenes ON herramientas_categorias.id_almacen = herramientas_almacenes.id
				WHERE herramientas_herramientas.id_categoria = $id_categoria AND herramientas_almacenes.id = $id_almacen ORDER BY herramientas_herramientas.id DESC";
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


	public static function getAllMax() {

		// Build database query
		$sql = 'select MAX(id) as id from usuarios';
		
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
		$sql = "select * from almacen_inventario where id = ?";
		
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
			$statement->bind_result($id, $codigo, $descripcion, $clase,  $cantidad_maxima, $cantidad_minima, $stock, $unidad, $precio_unitario, $estatus);
			
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
		$object->codigo = $codigo;
		$object->descripcion = $descripcion;
		$object->clase = $clase;
		$object->cantidad_minima = $cantidad_minima;
		$object->cantidad_maxima = $cantidad_maxima;
		$object->stock = $stock;
		$object->unidad = $unidad;
		$object->precio_unitario = $precio_unitario;
		$object->estatus = $estatus;
		return $object;
	}

	public static function getByIdInner($id) {
	
		// Initialize result array
		$result = array();
		
		// Build database query
		$sql = "SELECT herramientas_herramientas.*, herramientas_categorias.categoria as categoria, herramientas_almacenes.descripcion as descripcion_almacen, herramientas_almacenes.id as id_almacen
				FROM herramientas_herramientas
				INNER JOIN herramientas_categorias ON herramientas_herramientas.id_categoria = herramientas_categorias.id
				INNER JOIN herramientas_almacenes ON herramientas_categorias.id_almacen = herramientas_almacenes.id
				WHERE herramientas_herramientas.id = ?";
				//die($sql);
		
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
			$statement->bind_result($id, $clave, $id_categoria, $descripcion, $precio_unitario, $fecha_entrada, $categoria, $descripcion_almacen, $id_almacen);
			
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
		$object->clave = $clave;
		$object->id_categoria = $id_categoria;
		$object->descripcion = $descripcion;
		$object->precio_unitario = $precio_unitario;
		$object->fecha_entrada = $fecha_entrada;
		$object->categoria = $categoria;
		$object->descripcion_almacen = $descripcion_almacen;
		$object->id_almacen = $id_almacen;
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
		$sql = "insert into herramientas_herramientas (clave, id_categoria, descripcion, precio_unitario, fecha_entrada) values (?, ?, ?, ?, ?)";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('sisss', $this->clave, $this->id_categoria, $this->descripcion, $this->precio_unitario, $this->fecha_entrada);
			
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
		$sql = "update almacen_inventario set descripcion = ?, cantidad_maxima = ?, cantidad_minima = ?,  stock = ?, unidad = ?, precio_unitario = ?, estatus = ? where id = ?";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('sssssssi', $this->descripcion,  $this->cantidad_maxima, $this->cantidad_minima,  $this->stock,  $this->unidad, $this->precio_unitario, $this->estatus, $this->id);
			
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
		$sql = "delete from users where id = ?";
		
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