<?php

class Disponibilidad_calendarios {
	
	public $id;
	public $anos;
	
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
		$sql = 'select * from disponibilidad_calendarios';
		
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
		$sql = "SELECT * FROM disponibilidad_calendarios ORDER BY $columna $orden";
		//echo $sql;
		// Return objects
		return self::getBySql($sql);
	}

	public static function getByDia($dia) {

		// Build database query
		$sql = "SELECT disponibilidad_calendarios.*, disponibilidad_meses.mes_nombre
					FROM disponibilidad_calendarios
					INNER JOIN disponibilidad_meses on disponibilidad_calendarios.mes = disponibilidad_meses.mes
				WHERE disponibilidad_calendarios.dia = '$dia' ";
		//echo $sql;
		// Return objects
		return self::getBySql($sql);
	}


	public static function getDaysBySemanaAno($semana, $ano) {

		// Build database query
		$sql = "SELECT dia FROM disponibilidad_calendarios 
				WHERE ano = $ano 
					AND semana = $semana";
		//echo $sql;ECHO "<BR>";
		// Return objects
		return self::getBySql($sql);
	}

	public static function getMinDiaByAnoSemana($semana, $ano) {

		// Build database query
		$sql = "SELECT MIN(dia) as dia FROM disponibilidad_calendarios 
				WHERE ano = $ano 
					AND semana = $semana";
		//echo $sql;ECHO "<BR>";
		// Return objects
		return self::getBySql($sql);
	}

	public static function getMaxDiaByAnoSemana($semana, $ano) {

		// Build database query
		$sql = "SELECT MAX(dia) as dia FROM disponibilidad_calendarios 
				WHERE ano = $ano 
					AND semana = $semana";
		//echo $sql;
		// Return objects
		return self::getBySql($sql);
	}

	public static function getMinDiaByAnoMes($mes, $ano) {

		// Build database query
		$sql = "SELECT MIN(dia) as dia FROM disponibilidad_calendarios 
				WHERE ano = $ano 
					AND mes = $mes";
		//echo $sql;ECHO "<BR>";
		// Return objects
		return self::getBySql($sql);
	}

	public static function getMaxDiaByAnoMes($mes, $ano) {

		// Build database query
		$sql = "SELECT MAX(dia) as dia FROM disponibilidad_calendarios 
				WHERE ano = $ano 
					AND mes = $mes";
		//echo $sql;
		// Return objects
		return self::getBySql($sql);
	}

	public static function getMinDiaByAno($ano) {

		// Build database query
		$sql = "SELECT MIN(dia) as dia FROM disponibilidad_calendarios 
				WHERE ano = $ano";
		//echo $sql;
		// Return objects
		return self::getBySql($sql);
	}

	public static function getMaxDiaByAno($ano) {

		// Build database query
		$sql = "SELECT MAX(dia) as dia FROM disponibilidad_calendarios 
				WHERE ano = $ano";
		//echo $sql;
		// Return objects
		return self::getBySql($sql);
	}

	public static function getMinDia() {

		// Build database query
		$sql = "SELECT MIN(dia) as dia FROM disponibilidad_calendarios";
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

	public static function getAllSemanasByMesAno($mes, $ano) 
	{

		// Build database query
		$sql = "SELECT * FROM disponibilidad_calendarios 
					WHERE mes = $mes
						AND ano = $ano
					GROUP BY semana";
		//echo $sql;
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
		$sql = "insert into cat_agrupado (nombre_del_grupo) values (?)";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('s', $this->nombre_del_grupo);
			
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
		$sql = "update cat_agrupado set nombre_del_grupo = ? where id = ?";
				
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('si', $this->nombre_del_grupo, $this->id);
			
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
		$sql = "delete from cat_agrupado where id = ?";
		
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