<?php

class Ordenesots {
	
	public $id;
	public $fecha_original_vencimiento_mp;
	public $orden_trabajo;
	public $descripcion;
	public $equipo;
	public $tipo;
	public $estado;
	public $clase;
	public $departamento;
	public $fecha_inicio_programada;
	public $fecha_finalizacion_programada;
	public $solicitado;
	public $responsable;
	public $tecnico;
	public $fecha_informe;
	public $fecha_inicio;
	public $fecha_finalizacion;
	public $semana;
	public $motivo;
	

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
		$sql = 'SELECT * FROM ordenesots'; 
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function truncate2() {

		// Build database query
		$sql = 'truncate table ordenesots';
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllMpByMesAnoCuentaPreventivoGeneral($ano) 
	{

		// Build database query
		$sql = "SELECT count(ordenesots.orden_trabajo) AS nPreventivos 
				FROM ordenesots 
				INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
				WHERE date_format(fecha_inicio_programada, '%Y') = '$ano'
				AND tipo='Mant. preventivo' ";
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllMpByMesAnoCuentaCorrectivoGeneral($ano) 
	{

		// Build database query
		$sql = "SELECT count(ordenesots.orden_trabajo) AS nCorrectivos 
				FROM ordenesots 
				INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
				WHERE date_format(fecha_inicio_programada, '%Y') = '$ano'
				AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') ";


		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllMpGeneral($ano) {

		// Build database query
		$sql = "SELECT ordenesots.*, activos_equipos.familia FROM ordenesots
				LEFT JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
				WHERE date_format(ordenesots.fecha_inicio_programada, '%Y') = '$ano' 
				AND ordenesots.tipo='Mant. preventivo' 
				GROUP BY ordenesots.equipo";
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllMpByAnoEquipoGeneral($ano, $equipo) {

		// Build database query

		$sql = "SELECT fecha_informe, fecha_inicio, fecha_finalizacion, descripcion FROM ordenesots WHERE date_format(fecha_inicio_programada, '%Y-%m') = '$ano' AND tipo='Mant. preventivo' AND equipo='$equipo'";
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllMpByMesAnoCuentaPreventivo($mes, $ano) 
	{

		// Build database query
		/*$sql = "SELECT count(*) AS nPreventivos FROM ordenesots WHERE date_format(fecha_informe, '%Y-%m') = '".$ano."-".$mes."' AND tipo='Mant. preventivo' ";*/
		$sql = "SELECT count(ordenesots.orden_trabajo) AS nPreventivos 
				FROM ordenesots 
				INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
				WHERE date_format(fecha_inicio_programada, '%Y-%m') = '".$ano."-".$mes."'
				AND (activos_equipos.familia = 'ELECTRICA' 
					OR activos_equipos.familia = 'EMBARQUE' 
					OR activos_equipos.familia = 'FUMIGACION' 
					OR activos_equipos.familia = 'REMOLQUES' 
					OR activos_equipos.familia = 'RIEGO' 
					OR activos_equipos.familia = 'TRACTOR')
				AND tipo='Mant. preventivo' ";
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllMpByMesAnoCuentaCorrectivo($mes, $ano) 
	{

		// Build database query
		/*$sql = "SELECT count(*) AS nCorrectivos FROM ordenesots WHERE date_format(fecha_informe, '%Y-%m') = '".$ano."-".$mes."' AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') ";*/

		$sql = "SELECT count(ordenesots.orden_trabajo) AS nCorrectivos 
				FROM ordenesots 
				INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
				WHERE date_format(fecha_inicio_programada, '%Y-%m') = '".$ano."-".$mes."'
				AND (activos_equipos.familia = 'ELECTRICA' 
					OR activos_equipos.familia = 'EMBARQUE' 
					OR activos_equipos.familia = 'FUMIGACION' 
					OR activos_equipos.familia = 'REMOLQUES' 
					OR activos_equipos.familia = 'RIEGO' 
					OR activos_equipos.familia = 'TRACTOR')
				AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') ";
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllMpByMesAnoTodosCuentaMP($mes, $ano) // para la gráfica de Mc Vs MP
	{

		// Build database query
		$sql = "SELECT COUNT(*) as numeroMantenimientos FROM ordenesots WHERE date_format(fecha_inicio_programada, '%Y-%m') = '".$ano."-".$mes."' AND tipo='Mant. preventivo'";
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllMpByMesAnoTodosCuentaMC($mes, $ano) // para la gráfica de Mc Vs MP
	{

		// Build database query
		$sql = "SELECT COUNT(*) as numeroMantenimientos FROM ordenesots WHERE date_format(fecha_inicio_programada, '%Y-%m') = '".$ano."-".$mes."' AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado')";
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllMpByMesAnoTodosCuentaFamilia($mes, $ano) // para la gráfica de Mc Vs MP
	{

		// Build database query
		$sql = "SELECT * FROM ordenesots WHERE date_format(fecha_inicio_programada, '%Y-%m') = '".$ano."-".$mes."' AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado' OR tipo='Mant. preventivo')";
		die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllByMp($tipo) {

		// Build database query
		$sql = "SELECT * FROM ordenesots WHERE tipo='$tipo'";
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllMpByMesAno($mes, $ano) { 

		// Build database query
		$sql = "SELECT ordenesots.id, ordenesots.orden_trabajo,  activos_equipos.familia FROM ordenesots
				LEFT JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
				WHERE date_format(ordenesots.fecha_finalizacion_programada, '%Y-%m') = '".$ano."-".$mes."' AND ordenesots.tipo='Mant. preventivo' 
				AND (activos_equipos.familia = 'ELECTRICA' 
					OR activos_equipos.familia = 'EMBARQUE' 
					OR activos_equipos.familia = 'FUMIGACION' 
					OR activos_equipos.familia = 'REMOLQUES' 
					OR activos_equipos.familia = 'RIEGO' 
					OR activos_equipos.familia = 'TRACTOR')
				GROUP BY ordenesots.equipo";

		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllMpByMesAnoFamilia($mes, $ano, $familia) {

		// Build database query
		$sql = "SELECT ordenesots.*, activos_equipos.familia FROM ordenesots
				LEFT JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
				WHERE date_format(ordenesots.fecha_inicio_programada, '%Y-%m') = '".$ano."-".$mes."' AND ordenesots.tipo='Mant. preventivo' 
				AND (activos_equipos.familia = '".$familia."')
				GROUP BY ordenesots.equipo";
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllByMesAnoFamiliaSinGroup($mes, $ano, $familia) {

		// Build database query
		$sql = "SELECT ordenesots.*, activos_equipos.familia FROM ordenesots
				LEFT JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
				WHERE date_format(ordenesots.fecha_informe, '%Y-%m') = '".$ano."-".$mes."' AND (ordenesots.tipo='Correctivo de emergencia' OR ordenesots.tipo='Correctivo planeado' OR ordenesots.tipo='Mant. preventivo')
				AND (activos_equipos.familia = '".$familia."')";
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllMpByMesAnoTodos($mes, $ano) {

		// Build database query
		$sql = "SELECT * FROM ordenesots WHERE date_format(fecha_inicio_programada, '%Y-%m') = '".$ano."-".$mes."' AND tipo='Mant. preventivo' ORDER BY equipo";
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllMpByMesAnoTodosCuenta($mes, $ano) {

		// Build database query
		$sql = "SELECT COUNT(*) as numeroMantenimientos FROM ordenesots WHERE date_format(fecha_inicio_programada, '%Y-%m') = '".$ano."-".$mes."' ";
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllMpByMesAnoEquipo($mes, $ano, $equipo) {

		// Build database query
		/*$sql = "SELECT TIMESTAMPDIFF(MINUTE, fecha_informe, fecha_finalizacion) AS tiempoReal, fecha_informe, fecha_finalizacion, descripcion FROM ordenesots WHERE date_format(fecha_informe, '%Y-%m') = '".$ano."-".$mes."' AND tipo='Mant. preventivo' AND equipo='$equipo'";*/

		/*$sql = "SELECT equipo, fecha_informe, fecha_inicio, fecha_finalizacion, descripcion FROM ordenesots WHERE date_format(fecha_informe, '%Y-%m') = '".$ano."-".$mes."' AND tipo='Mant. preventivo' AND equipo='$equipo'";*/

		/*$sql = "SELECT equipo, fecha_informe, fecha_inicio, fecha_finalizacion, fecha_inicio_programada, descripcion FROM ordenesots WHERE date_format(fecha_inicio_programada, '%Y-%m') = '".$ano."-".$mes."' AND tipo='Mant. preventivo' AND equipo='$equipo'";*/

		$sql = "SELECT equipo, fecha_informe, fecha_inicio, fecha_finalizacion, fecha_inicio_programada, fecha_finalizacion_programada, descripcion FROM ordenesots WHERE date_format(fecha_finalizacion_programada, '%Y-%m') = '".$ano."-".$mes."' AND tipo='Mant. preventivo' AND equipo='$equipo'
			AND (estado = 'Cierre Lider Mtto'
			 	OR estado = 'Ejecutado'
			 	OR estado = 'Espera de equipo'
			 	OR estado = 'Espera de refacciones'
			 	OR estado = 'Falta de mano de obra'
			 	OR estado = 'Programada' 
			 	OR estado = 'Terminado' )";
		/*if($equipo == "CO-TRC-002")
		{
			die($sql);
		}*/
		//echo $sql;
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllByMesAnoEquipo($mes, $ano, $equipo) {

		// Build database query
		/*$sql = "SELECT TIMESTAMPDIFF(MINUTE, fecha_informe, fecha_finalizacion) AS tiempoReal, fecha_informe, fecha_finalizacion, descripcion FROM ordenesots WHERE date_format(fecha_informe, '%Y-%m') = '".$ano."-".$mes."' AND tipo='Mant. preventivo' AND equipo='$equipo'";*/

		/*$sql = "SELECT * FROM ordenesots WHERE date_format(fecha_inicio_programada, '%Y-%m') = '".$ano."-".$mes."'  AND equipo='$equipo'";*/

		$sql = "SELECT * FROM ordenesots WHERE date_format(fecha_finalizacion_programada, '%Y-%m') = '".$ano."-".$mes."'  AND equipo='$equipo'
			AND (/*estado = 'Cerrado sin ejecutar'
				 	OR */estado = 'Cierre Lider Mtto'
				 	OR estado = 'Ejecutado'
				 	OR estado = 'Espera de equipo'
				 	OR estado = 'Espera de refacciones'
				 	OR estado = 'Programada' 
				 	OR estado = 'Terminado' )";

		/*if($equipo == "CO-TRC-002")
		{
			die($sql);
		}*/
		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllMpByMesAnoEquipoCorrectivo($mes, $ano, $equipo) {

		// Build database query
		/*$sql = "SELECT TIMESTAMPDIFF(MINUTE, fecha_informe, fecha_finalizacion) AS tiempoCorrectivo, equipo, fecha_Informe, fecha_finalizacion, descripcion, equipo FROM ordenesots WHERE date_format(fecha_informe, '%Y-%m') = '".$ano."-".$mes."' AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') AND equipo='$equipo'";*/

		/*$sql = "SELECT equipo, fecha_informe, fecha_inicio, fecha_finalizacion, fecha_inicio_programada, descripcion, equipo FROM ordenesots WHERE date_format(fecha_informe, '%Y-%m') = '".$ano."-".$mes."' AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') AND equipo='$equipo'";*/
		$sql = "SELECT equipo, fecha_informe, fecha_inicio, fecha_finalizacion, fecha_inicio_programada, fecha_finalizacion_programada, descripcion, equipo FROM ordenesots WHERE date_format(fecha_finalizacion_programada, '%Y-%m') = '$ano-$mes' AND (tipo='Correctivo de emergencia' OR tipo='Correctivo planeado') AND equipo='$equipo'
			AND (estado = 'Cierre Lider Mtto'
		 	OR estado = 'Ejecutado'
		 	OR estado = 'Espera de equipo'
		 	OR estado = 'Espera de refacciones'
		 	OR estado = 'Falta de mano de obra'
		 	OR estado = 'Programada' 
		 	OR estado = 'Terminado' )";

		//die($sql);
		// Return objects
		return self::getBySql($sql);
	}


	public static function getAllByMc($tipo1, $tipo2) {

		// Build database query
		$sql = "SELECT * FROM ordenesots WHERE tipo='$tipo1' OR tipo='$tipo2' ";
		
		// Return objects
		return self::getBySql($sql);
	}

	

	public static function getAllMax() {

		// Build database query
		$sql = 'select MAX(id) as id from usuarios';
		
		// Return objects
		return self::getBySql($sql);
	}

	// PARA MP VS MC
	public static function getAllProgramadosMP($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT count(orden_trabajo) AS nProgramadosMP, id 
				FROM ordenesots 
				WHERE ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion') 
				AND tipo='Mant. preventivo'
				AND (estado = 'Cierre Lider Mtto'
					 	OR estado = 'Ejecutado'
					 	OR estado = 'Espera de equipo'
					 	OR estado = 'Espera de refacciones'
					 	OR estado = 'Abierta'
					 	OR estado = 'Falta de mano de obra'
					 	OR estado = 'Programada' 
					 	OR estado = 'Terminado' )";
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllProgramadosMPcriticos($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT count(ordenesots.orden_trabajo) AS nProgramadosMP, activos_equipos.nombre_equipo
				FROM ordenesots 
				INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
				WHERE ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion') 
				AND ordenesots.tipo='Mant. preventivo'
				AND (ordenesots.estado = 'Cierre Lider Mtto'
		 	OR ordenesots.estado = 'Ejecutado'
		 	OR ordenesots.estado = 'Espera de equipo'
		 	OR ordenesots.estado = 'Espera de refacciones'
		 	OR ordenesots.estado = 'Abierta'
		 	OR ordenesots.estado = 'Falta de mano de obra'
		 	OR ordenesots.estado = 'Programada' 
		 	OR ordenesots.estado = 'Terminado' )";
		
		//echo $sql;
		// Return objects 
		return self::getBySql($sql);
	}

	public static function getAllTerminadosMP($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT count(orden_trabajo) AS nTerminadosMP, id 
		FROM ordenesots WHERE
		 ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND tipo='Mant. preventivo'
		 AND (estado='Terminado') ";
		
		
		// Return objects 
		return self::getBySql($sql);
	}

	public static function getAllTerminadosMPcriticos($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT count(ordenesots.orden_trabajo) AS nTerminadosMP, activos_equipos.nombre_equipo
		FROM ordenesots 
		INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo 
		WHERE
		 ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND ordenesots.tipo='Mant. preventivo'
		 AND (ordenesots.estado='Terminado') ";
		
		
		// Return objects 
		return self::getBySql($sql);
	}

	public static function getAllPendientesMP($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT count(orden_trabajo) AS nPendientesMP, id FROM ordenesots WHERE
		 ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND tipo='Mant. preventivo'
		 AND (estado = 'Programada' 
		 		OR estado = 'Cierre Lider Mtto' 
		 		OR estado = 'Ejecutado'
		 		OR estado = 'Espera de equipo'
		 		OR estado = 'Espera de refacciones'
		 		OR estado = 'Falta de mano de obra'
		 		OR estado = 'Abierta')";

		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllPendientesMPcriticos($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT count(ordenesots.orden_trabajo) AS nPendientesMP, activos_equipos.nombre_equipo
				FROM ordenesots
				INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
				WHERE ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND ordenesots.tipo='Mant. preventivo'
		 AND (ordenesots.estado = 'Programada' 
		 		OR ordenesots.estado = 'Cierre Lider Mtto'
		 		OR ordenesots.estado = 'Ejecutado'
		 		OR ordenesots.estado = 'Espera de equipo'
		 		OR ordenesots.estado = 'Espera de refacciones'
		 		OR ordenesots.estado = 'Falta de mano de obra'
		 		OR ordenesots.estado = 'Abierta')";

		// Return objects
		return self::getBySql($sql);
	}	

	public static function getAllOtrosMP($fechaInicio, $fechaFinalizacion) {

		// Build database query
		$sql = "SELECT count(orden_trabajo) AS nOtrosMP FROM ordenesots WHERE
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
		$sql = "SELECT count(ordenesots.orden_trabajo) AS nOtrosMP, activos_equipos.nombre_equipo 
				FROM ordenesots 
				INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
				WHERE
		 ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (ordenesots.tipo='Mant. preventivo')
		 AND (ordenesots.estado = 'Cancelado'
		 		OR ordenesots.estado = 'Rechazado'
		 		OR ordenesots.estado = 'Cerrado sin ejecutar') ";
		 //echo $sql;
			//die($sql);
		
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllProgramadosMC($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT count(orden_trabajo) AS nProgramadosMC FROM ordenesots WHERE
		 ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (tipo <> 'Mant. preventivo')
		 AND (estado = 'Cierre Lider Mtto'
		 	OR estado = 'Ejecutado'
		 	OR estado = 'Espera de equipo'
		 	OR estado = 'Espera de refacciones'
		 	OR estado = 'Falta de mano de obra'
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

		$sql = "SELECT count(ordenesots.orden_trabajo) AS nProgramadosMC, activos_equipos.nombre_equipo 
		FROM ordenesots 
		INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
		WHERE
		 ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (ordenesots.tipo <> 'Mant. preventivo')
		 AND (ordenesots.estado = 'Cierre Lider Mtto'
		 	OR ordenesots.estado = 'Ejecutado'
		 	OR ordenesots.estado = 'Espera de equipo'
		 	OR ordenesots.estado = 'Espera de refacciones'
		 	OR ordenesots.estado = 'Falta de mano de obra'
		 	OR ordenesots.estado = 'Programada' 
		 	OR ordenesots.estado = 'Terminado' 
		 	OR ordenesots.estado = 'Solic. de trabajo'
		 	OR ordenesots.estado = 'Abierta')";
		//echo ($sql);
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllTerminadosMC($fechaInicio, $fechaFinalizacion) {

		// Build database query

		/*$sql = "SELECT count(orden_trabajo) AS nTerminadosMC FROM ordenesots WHERE
		 ( fecha_inicio_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (tipo='Correctivo planeado' OR tipo='Correctivo de emergencia')
		 AND estado='Terminado'";*/

		 $sql = "SELECT count(orden_trabajo) AS nTerminadosMC FROM ordenesots WHERE
		 ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (tipo <> 'Mant. preventivo')
		 AND (estado = 'Terminado')";
		/*if($mes==04)
		{
			die($sql);
		}*/
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllTerminadosMCcriticos($fechaInicio, $fechaFinalizacion) {

		// Build database query

		/*$sql = "SELECT count(orden_trabajo) AS nTerminadosMC FROM ordenesots WHERE
		 ( fecha_inicio_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (tipo='Correctivo planeado' OR tipo='Correctivo de emergencia')
		 AND estado='Terminado'";*/

		 $sql = "SELECT count(ordenesots.orden_trabajo) AS nTerminadosMC, activos_equipos.nombre_equipo
		  FROM ordenesots 
		  INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
		  WHERE
		 ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (ordenesots.tipo <> 'Mant. preventivo')
		 AND (ordenesots.estado = 'Terminado')";
		/*if($mes==04)
		{
			die($sql);
		}*/
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllPendientesMC($fechaInicio, $fechaFinalizacion) {

		// Build database query

		/*$sql = "SELECT count(orden_trabajo) AS nPendientesMC FROM ordenesots WHERE
		 ( fecha_inicio_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (tipo='Correctivo planeado' OR tipo='Correctivo de emergencia')
		 AND estado != 'Terminado'";*/
		$sql = "SELECT count(orden_trabajo) AS nPendientesMC FROM ordenesots WHERE
		 ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (tipo <> 'Mant. preventivo')
		 AND (estado = 'Programada' 
		 		OR estado = 'Cierre Lider Mtto'
		 		OR estado = 'Ejecutado'
		 		OR estado = 'Espera de equipo'
		 		OR estado = 'Espera de refacciones'
		 		OR estado = 'Falta de mano de obra'
		 		OR estado = 'Solic. de trabajo'
		 		OR estado = 'Abierta')";

		 //echo $sql;
			//die($sql);
		
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllPendientesMCcriticos($fechaInicio, $fechaFinalizacion) {

		// Build database query

		/*$sql = "SELECT count(orden_trabajo) AS nPendientesMC FROM ordenesots WHERE
		 ( fecha_inicio_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (tipo='Correctivo planeado' OR tipo='Correctivo de emergencia')
		 AND estado != 'Terminado'";*/
		$sql = "SELECT count(ordenesots.orden_trabajo) AS nPendientesMC, activos_equipos.nombre_equipo FROM ordenesots 
			 INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
			WHERE
		 ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (ordenesots.tipo <> 'Mant. preventivo')
		 AND (ordenesots.estado = 'Programada' 
		 		OR ordenesots.estado = 'Cierre Lider Mtto'
		 		OR ordenesots.estado = 'Ejecutado'
		 		OR ordenesots.estado = 'Espera de equipo'
		 		OR ordenesots.estado = 'Espera de refacciones'
		 		OR ordenesots.estado = 'Falta de mano de obra'
		 		OR ordenesots.estado = 'Solic. de trabajo'
		 		OR ordenesots.estado = 'Abierta')";
		 //echo $sql;
			//die($sql);
		
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllOtrosMC($fechaInicio, $fechaFinalizacion) {

		// Build database query

		/*$sql = "SELECT count(orden_trabajo) AS nPendientesMC FROM ordenesots WHERE
		 ( fecha_inicio_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (tipo='Correctivo planeado' OR tipo='Correctivo de emergencia')
		 AND estado != 'Terminado'";*/
		$sql = "SELECT count(orden_trabajo) AS nOtrosMC FROM ordenesots WHERE
		 ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (tipo <> 'Mant. preventivo')
		 AND (estado = 'Cancelado'
		 		OR estado = 'Rechazado'
		 		OR estado = 'Cerrado sin ejecutar') ";
		 //echo $sql;
			//die($sql);
		
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllOtrosMCcriticos($fechaInicio, $fechaFinalizacion) {

		// Build database query

		/*$sql = "SELECT count(orden_trabajo) AS nPendientesMC FROM ordenesots WHERE
		 ( fecha_inicio_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (tipo='Correctivo planeado' OR tipo='Correctivo de emergencia')
		 AND estado != 'Terminado'";*/
		$sql = "SELECT count(ordenesots.orden_trabajo) AS nOtrosMC, activos_equipos.nombre_equipo
		 FROM ordenesots 
		 INNER JOIN activos_equipos ON ordenesots.equipo =  activos_equipos.nombre_equipo
		 WHERE
		 ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
		 AND (ordenesots.tipo <> 'Mant. preventivo')
		 AND (ordenesots.estado = 'Cancelado'
		 		OR ordenesots.estado = 'Rechazado'
		 		OR ordenesots.estado = 'Cerrado sin ejecutar') ";
		 //echo $sql;
			//die($sql);
		
		
		// Return objects
		return self::getBySql($sql);
	}


	public static function getAllInicioFin($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT * FROM ordenesots WHERE
		 ( fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')";
		/*if($mes==04)
		{
			die($sql);
		}*/
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllInicioFinCriticos($fechaInicio, $fechaFinalizacion) {

		// Build database query

		$sql = "SELECT ordenesots.*, activos_equipos.nombre_equipo FROM ordenesots
		INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
		WHERE
		 ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')";
		/*if($mes==04)
		{
			die($sql);
		}*/
		
		// Return objects
		return self::getBySql($sql);
	}

	public static function getAllConsulta($consulta) {

		// Build database query

		$sql = $consulta;
		return self::getBySql($sql);
	}
	

	
	

	public static function getById($id) {
	
		// Initialize result array
		$result = array();
		
		// Build database query
		$sql = "select * from users where id = ?";
		
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
			$statement->bind_result($id, $name, $updated, $created, $email, $password, $type);
			
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
		$object->name = $name;
		$object->created = $created;
		$object->updated = $updated;
		$object->email = $email;
		$object->password = $password;
		$object->type = $type;
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
		$sql = "INSERT INTO ordenesots (fecha_original_vencimiento_mp, orden_trabajo, descripcion, equipo, tipo, estado, clase,	departamento, fecha_inicio_programada, fecha_finalizacion_programada, solicitado, responsable, tecnico, fecha_informe, fecha_inicio, fecha_finalizacion, semana, motivo) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		// Open database connection
		$database = new Database();
		
		// Get instance of statement
		$statement = $database->stmt_init();
		
		// Prepare query
		if ($statement->prepare($sql)) {
			
			// Bind parameters
			$statement->bind_param('ssssssssssssssssss', $this->fecha_original_vencimiento_mp, $this->orden_trabajo, $this->descripcion, $this->equipo, $this->tipo, $this->estado, $this->clase,	$this->departamento, $this->fecha_inicio_programada, $this->fecha_finalizacion_programada, $this->solicitado, $this->responsable, $this->tecnico, $this->fecha_informe, $this->fecha_inicio, $this->fecha_finalizacion, $this->semana, $this->motivo);
			
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

	


	public function inserta_dura() 
	{

		// Initialize affected rows
		$affected_rows = FALSE;
	
		// Build database query
		$sql = "INSERT INTO ordenesots values $this->q";


		//echo $sql;
		//die();
		
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
		$sql = "truncate table ordenesots";
		
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