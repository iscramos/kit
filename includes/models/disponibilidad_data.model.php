<?php

class Disponibilidad_data {
	
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
		$sql = 'select * from disponibilidad_data';
		
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
		$sql = "SELECT * FROM disponibilidad_data ORDER BY $columna $orden";
		//echo $sql;
		// Return objects
		return self::getBySql($sql);
	}


	public static function getAllProgramadosMP($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT count(ot) AS nProgramadosMP, id 
				FROM disponibilidad_data 
				WHERE ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion') 
				AND tipo='Mant. preventivo'
				AND (estado = 'Cierre Lider Mtto'
					 	OR estado = 'Ejecutado'
					 	OR estado = 'Espera de equipo'
					 	OR estado = 'Espera de refacciones'
					 	OR estado = 'Abierta'
					 	OR estado = 'Falta de mano de obra'
					 	OR estado = 'Condiciones ambientales'
					 	OR estado = 'Programada' 
					 	OR estado = 'Terminado' )";
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllProgramadosMPcriticos($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT count(disponibilidad_data.ot) AS nProgramadosMP, disponibilidad_data.id 
				FROM disponibilidad_data 
				INNER JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo 
				WHERE ( disponibilidad_data.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion') 
				AND disponibilidad_activos.criticidad = 'Alta'
				AND disponibilidad_data.tipo='Mant. preventivo'
				AND (disponibilidad_data.estado = 'Cierre Lider Mtto'
					 	OR disponibilidad_data.estado = 'Ejecutado'
					 	OR disponibilidad_data.estado = 'Espera de equipo'
					 	OR disponibilidad_data.estado = 'Espera de refacciones'
					 	OR disponibilidad_data.estado = 'Abierta'
					 	OR disponibilidad_data.estado = 'Falta de mano de obra'
					 	OR disponibilidad_data.estado = 'Condiciones ambientales'
					 	OR disponibilidad_data.estado = 'Programada' 
					 	OR disponibilidad_data.estado = 'Terminado' )";
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllTerminadosMP($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT count(ot) AS nTerminadosMP, id 
		FROM disponibilidad_data WHERE
		 ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND tipo='Mant. preventivo'
		 AND (estado='Terminado') ";
		
		
		// Return objects 
		return self::getBySql($sql);
	}

	public static function getAllTerminadosMPcriticos($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT count(disponibilidad_data.ot) AS nTerminadosMP, disponibilidad_data.id 
		FROM disponibilidad_data 
		INNER JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo 
		WHERE
		 ( disponibilidad_data.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND disponibilidad_activos.criticidad = 'Alta'
		 AND disponibilidad_data.tipo='Mant. preventivo'
		 AND (disponibilidad_data.estado='Terminado') ";
		
		//echo $sql;
		// Return objects 
		return self::getBySql($sql);
	}

	public static function getAllPendientesMP($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT count(ot) AS nPendientesMP, id FROM disponibilidad_data WHERE
		 ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND tipo='Mant. preventivo'
		 AND (estado = 'Programada' 
		 		OR estado = 'Cierre Lider Mtto' 
		 		OR estado = 'Ejecutado'
		 		OR estado = 'Espera de equipo'
		 		OR estado = 'Espera de refacciones'
		 		OR estado = 'Falta de mano de obra'
		 		OR estado = 'Condiciones ambientales'
		 		OR estado = 'Abierta')";

		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllPendientesMPcriticos($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT count(disponibilidad_data.ot) AS nPendientesMP, disponibilidad_data.id 
		FROM disponibilidad_data
		INNER JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo 
		WHERE
		 ( disponibilidad_data.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND disponibilidad_activos.criticidad = 'Alta'
		 AND disponibilidad_data.tipo='Mant. preventivo'
		 AND (disponibilidad_data.estado = 'Programada' 
		 		OR disponibilidad_data.estado = 'Cierre Lider Mtto' 
		 		OR disponibilidad_data.estado = 'Ejecutado'
		 		OR disponibilidad_data.estado = 'Espera de equipo'
		 		OR disponibilidad_data.estado = 'Espera de refacciones'
		 		OR disponibilidad_data.estado = 'Falta de mano de obra'
		 		OR disponibilidad_data.estado = 'Condiciones ambientales'
		 		OR disponibilidad_data.estado = 'Abierta')";

		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllOtrosMP($fechaInicio, $fechaFinalizacion) {

		// Build database query
		$sql = "SELECT count(ot) AS nOtrosMP FROM disponibilidad_data WHERE
		 ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (tipo='Mant. preventivo')
		 AND (estado = 'Cancelado'
		 		OR estado = 'Rechazado'
		 		OR estado = 'Cerrado sin ejecutar') ";
		 //echo $sql;
			//die($sql);
		
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllOtrosMPcriticos($fechaInicio, $fechaFinalizacion) {

		// Build database query
		$sql = "SELECT count(disponibilidad_data.ot) AS nOtrosMP 
		FROM disponibilidad_data 
		INNER JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo 
		WHERE
		 ( disponibilidad_data.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND disponibilidad_activos.criticidad = 'Alta'
		 AND (disponibilidad_data.tipo='Mant. preventivo')
		 AND (disponibilidad_data.estado = 'Cancelado'
		 		OR disponibilidad_data.estado = 'Rechazado'
		 		OR disponibilidad_data.estado = 'Cerrado sin ejecutar') ";
		 //echo $sql;
			//die($sql);
		
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllProgramadosMC($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT count(ot) AS nProgramadosMC FROM disponibilidad_data WHERE
		 ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (tipo <> 'Mant. preventivo')
		 AND (estado = 'Cierre Lider Mtto'
		 	OR estado = 'Ejecutado'
		 	OR estado = 'Espera de equipo'
		 	OR estado = 'Espera de refacciones'
		 	OR estado = 'Falta de mano de obra'
		 	OR estado = 'Condiciones ambientales'
		 	OR estado = 'Programada' 
		 	OR estado = 'Terminado'
		 	OR estado = 'Solic. de trabajo'
		 	OR estado = 'Abierta' )";

		//echo ($sql);
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllProgramadosMCcriticos($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT count(disponibilidad_data.ot) AS nProgramadosMC 
		FROM disponibilidad_data 
		INNER JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo 
		WHERE
		 ( disponibilidad_data.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND disponibilidad_activos.criticidad = 'Alta'
		 AND (disponibilidad_data.tipo <> 'Mant. preventivo')
		 AND (disponibilidad_data.estado = 'Cierre Lider Mtto'
		 	OR disponibilidad_data.estado = 'Ejecutado'
		 	OR disponibilidad_data.estado = 'Espera de equipo'
		 	OR disponibilidad_data.estado = 'Espera de refacciones'
		 	OR disponibilidad_data.estado = 'Falta de mano de obra'
		 	OR disponibilidad_data.estado = 'Condiciones ambientales'
		 	OR disponibilidad_data.estado = 'Programada' 
		 	OR disponibilidad_data.estado = 'Terminado'
		 	OR disponibilidad_data.estado = 'Solic. de trabajo'
		 	OR disponibilidad_data.estado = 'Abierta' )";

		//echo ($sql);
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllTerminadosMC($fechaInicio, $fechaFinalizacion) {

		// Build database query

		 $sql = "SELECT count(ot) AS nTerminadosMC FROM disponibilidad_data WHERE
		 ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (tipo <> 'Mant. preventivo')
		 AND (estado = 'Terminado')";

		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllTerminadosMCcriticos($fechaInicio, $fechaFinalizacion) {

		// Build database query

		 $sql = "SELECT count(disponibilidad_data.ot) AS nTerminadosMC 
		 FROM disponibilidad_data 
		 INNER JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo 
		 WHERE
		 ( disponibilidad_data.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND disponibilidad_activos.criticidad = 'Alta'
		 AND (disponibilidad_data.tipo <> 'Mant. preventivo')
		 AND (disponibilidad_data.estado = 'Terminado')";

		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllPendientesMC($fechaInicio, $fechaFinalizacion) {

		// Build database query
		$sql = "SELECT count(ot) AS nPendientesMC FROM disponibilidad_data WHERE
		 ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (tipo <> 'Mant. preventivo')
		 AND (estado = 'Programada' 
		 		OR estado = 'Cierre Lider Mtto'
		 		OR estado = 'Ejecutado'
		 		OR estado = 'Espera de equipo'
		 		OR estado = 'Espera de refacciones'
		 		OR estado = 'Falta de mano de obra'
		 		OR estado = 'Condiciones ambientales'
		 		OR estado = 'Solic. de trabajo'
		 		OR estado = 'Abierta')";

		//echo $sql;

		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllPendientesMCcriticos($fechaInicio, $fechaFinalizacion) {

		// Build database query
		$sql = "SELECT count(disponibilidad_data.ot) AS nPendientesMC 
		FROM disponibilidad_data 
		INNER JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo 
		WHERE
		 ( disponibilidad_data.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND disponibilidad_activos.criticidad = 'Alta'
		 AND (disponibilidad_data.tipo <> 'Mant. preventivo')
		 AND (disponibilidad_data.estado = 'Programada' 
		 		OR disponibilidad_data.estado = 'Cierre Lider Mtto'
		 		OR disponibilidad_data.estado = 'Ejecutado'
		 		OR disponibilidad_data.estado = 'Espera de equipo'
		 		OR disponibilidad_data.estado = 'Espera de refacciones'
		 		OR disponibilidad_data.estado = 'Falta de mano de obra'
		 		OR disponibilidad_data.estado = 'Condiciones ambientales'
		 		OR disponibilidad_data.estado = 'Solic. de trabajo'
		 		OR disponibilidad_data.estado = 'Abierta')";

		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllOtrosMC($fechaInicio, $fechaFinalizacion) {

		// Build database query
		$sql = "SELECT count(ot) AS nOtrosMC FROM disponibilidad_data WHERE
		 ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (tipo <> 'Mant. preventivo')
		 AND (estado = 'Cancelado'
		 		OR estado = 'Rechazado'
		 		OR estado = 'Cerrado sin ejecutar') ";
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllOtrosMCcriticos($fechaInicio, $fechaFinalizacion) {

		// Build database query
		$sql = "SELECT count(disponibilidad_data.ot) AS nOtrosMC 
		FROM disponibilidad_data 
		INNER JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo 
		WHERE
		 ( disponibilidad_data.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND disponibilidad_activos.criticidad = 'Alta'
		 AND (disponibilidad_data.tipo <> 'Mant. preventivo')
		 AND (disponibilidad_data.estado = 'Cancelado'
		 		OR disponibilidad_data.estado = 'Rechazado'
		 		OR disponibilidad_data.estado = 'Cerrado sin ejecutar') ";
		
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
		$sql = "select ot, descripcion from disponibilidad_data where ot = ?";
		
		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('i', $ot);
			
			// Execute statement
			$statement->execute();
			
			// Bind variable to prepared statement
			$statement->bind_result($ot, $descripcion);
			
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
		$object->descripcion = $descripcion;
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

	public function inserta_dura() 
	{

		// Initialize affected rows
		$affected_rows = FALSE;
	
		// Build database query
		$sql = "INSERT INTO disponibilidad_data values $this->q";

		/*(organizacion, ot, codigo, descripcion, equipo, tipo, estado, clase, departamento, fecha_inicio_programada, fecha_finalizacion_programada, responsable, tecnico, fecha_informe, fecha_inicio, fecha_finalizacion, motivo, coste_tiempo_parada, costos_estimados_mobra, costos_estimados_material, costos_estimados_totales, costos_estimados_varios, latitud, longitud, horas_estimadas) */

		//echo $sql;
		
		// Open database connection
		$database = new Database();
		
		mysqli_query($database, $sql) or die(mysqli_error($database));


		// Return affected rows
		return $affected_rows;			
	
	}

	public function truncate() 
	{

		// Initialize affected rows
		$affected_rows = FALSE;
	
		// Build database query
		$sql = "truncate table disponibilidad_data";
		
		// Open database connection
		$database = new Database();
		
		mysqli_query($database, $sql) or die(mysqli_error());

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