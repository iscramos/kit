<?php

class Herramientas_herramientas {
	
	public $id;
	public $clave;
	public $id_almacen;
	public $id_categoria;
	public $id_marca;
	public $descipcion;
	public $precio_unitario;
	//public $id_responsable;
	public $fecha_entrada;
	public $archivo;
	public $activaStock;
	public $id_udm;

	
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
		$sql = 'select * from herramientas_herramientas';
		
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
		$sql = "SELECT * FROM herramientas_herramientas ORDER BY $campo $orden";
		
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
		$sql = "select * from herramientas_herramientas where id = ?";
		
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
			$statement->bind_result($id, $clave, $id_almacen, $id_categoria, $id_marca, $descripcion, $precio_unitario, $fecha_entrada, $archivo, $activaStock, $id_udm);
			
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
		$object->id_almacen = $id_almacen;
		$object->id_categoria = $id_categoria;
		$object->id_marca = $id_marca;
		$object->descripcion = $descripcion;
		$object->precio_unitario = $precio_unitario;
		$object->fecha_entrada = $fecha_entrada;
		$object->archivo = $archivo;
		$object->activaStock = $activaStock;
		$object->id_udm = $id_udm;
		return $object;
	}

	public static function buscaClave($clave)
	{
		// Open database connection
		$database = new Database();

		//checar si existe el usuario en la base
		$sql = "SELECT clave, archivo FROM herramientas_herramientas WHERE clave = '$clave' ";
		
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
		{ 
			return 0;
		}
	}

	public static function getByClave($clave) {
	
		// Initialize result array
		$result = array();
		
		// Build database query
		$sql = "select * from herramientas_herramientas where clave = ?";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('s', $clave);
			
			// Execute statement
			$statement->execute();
			
			// Bind variable to prepared statement
			$statement->bind_result($id, $clave, $id_almacen, $id_categoria, $id_marca, $descripcion, $precio_unitario, $fecha_entrada, $archivo, $activaStock, $id_udm);
			
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
		$object->id_almacen = $id_almacen;
		$object->id_categoria = $id_categoria;
		$object->id_marca = $id_marca;
		$object->descripcion = $descripcion;
		$object->precio_unitario = $precio_unitario;
		$object->fecha_entrada = $fecha_entrada;
		$object->archivo = $archivo;
		$object->activaStock = $activaStock;
		$object->id_udm = $id_udm;
		return $object;
	}

	public static function getByIdInner($id) {
	
		// Initialize result array
		$result = array();
		
		// Build database query
		$sql = "SELECT herramientas_herramientas.*, herramientas_categorias.categoria as categoria, herramientas_almacenes.descripcion as descripcion_almacen, herramientas_proveedores.descripcion AS proveedor
				FROM herramientas_herramientas
				INNER JOIN herramientas_categorias ON herramientas_herramientas.id_categoria = herramientas_categorias.id
				INNER JOIN herramientas_almacenes ON herramientas_herramientas.id_almacen = herramientas_almacenes.id
				INNER JOIN herramientas_proveedores ON herramientas_herramientas.id_marca = herramientas_proveedores.id
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
			$statement->bind_result($id, $clave, $id_almacen, $id_categoria, $id_marca, $descripcion, $precio_unitario, $fecha_entrada, $archivo, $categoria, $descripcion_almacen, $proveedor);
			
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
		$object->id_almacen = $id_almacen;
		$object->id_categoria = $id_categoria;
		$object->id_categoria = $id_marca;
		$object->descripcion = $descripcion;
		$object->precio_unitario = $precio_unitario;
		$object->fecha_entrada = $fecha_entrada;
		$object->categoria = $categoria;
		$object->descripcion_almacen = $descripcion_almacen;
		$object->archivo = $archivo;
		$object->proveedor = $proveedor;
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
		$sql = "insert into herramientas_herramientas (clave, id_almacen, id_categoria, id_marca, descripcion, precio_unitario, fecha_entrada, archivo, activaStock, id_udm) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('siiissssii', $this->clave, $this->id_almacen, $this->id_categoria, $this->id_marca, $this->descripcion, $this->precio_unitario, $this->fecha_entrada, $this->archivo, $this->activaStock, $this->id_udm);
			
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
		$sql = "update herramientas_herramientas set id_marca = ?, descripcion = ?, precio_unitario = ?, activaStock = ?, id_udm = ? where id = ?";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('issiii', $this->id_marca, $this->descripcion, $this->precio_unitario, $this->activaStock, $this->id_udm, $this->id);
			
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