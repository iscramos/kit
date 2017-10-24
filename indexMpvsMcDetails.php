<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if(($_SESSION["type"]==1 || $_SESSION["type"]==6 || $_SESSION["type"]==7))
{
	//$disponibilidad = Ordenesos::getAllByMes();
	// Include page view
	$semana = $_GET["semana"];
	$fechaInicio = $_GET["fechaInicio"];
	$fechaFinalizacion = $_GET["fechaFinalizacion"];
	$ano = $_GET["ano"];

	// este pequeño codigo es para traernos el acumulado
	$nPendientesAnoAnteriorMPOrfanel = 0;
	$nPendientesAnoAnteriorMCOrfanel = 0;
	//$pendientesAnoAnteriorMP = 0;
	$pendientesOrfanelMP = 0;
	$pendientesOrfanelMC = 0;

	$nPendientesAnoAnteriorMPHumberto = 0;
	$nPendientesAnoAnteriorMCHumberto = 0;
	$pendientesHumbertoMP = 0;
	$pendientesHumbertoMC = 0;
	//$nPendientesAnoAnteriorMC = 0;
	//$pendientesAnoAnteriorMC = 0;


	$nuevaSemana = 0;
	if($semana == 1)
	{
		$traerSemana = Calendario_nature::getMaxSemana();
		$temporal_inicio = $traerSemana[0]->fecha_inicio;
		$temporal_fin = $traerSemana[0]->fecha_fin;

		$anoNuevo = $ano - 1;
		if($ano > 2016)
		{
			$fechaInicioAnoAnterior = $anoNuevo."-01-01";
			$fechaFinalizacionAnoAnterior = $anoNuevo."-".$temporal_fin;

			//echo $fechaInicioAnoAnterior."<br>".$fechaFinalizacionAnoAnterior;

			/*$pendientesAnoAnteriorMP = Ordenesots::getAllPendientesMP($fechaInicioAnoAnterior, $fechaFinalizacionAnoAnterior);
			$pendientesAnoAnteriorMC = Ordenesots::getAllPendientesMC($fechaInicioAnoAnterior, $fechaFinalizacionAnoAnterior);*/

			$consulta = "SELECT count(orden_trabajo) AS nPendientesMP 
						FROM ordenesots 
						WHERE ( fecha_inicio_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior')
		 				AND tipo='Mant. preventivo'
		 				AND (estado = 'Programada' 
		 					OR estado = 'Cierre Lider Mtto'
		 					OR estado = 'Ejecutado'
		 					OR estado = 'Espera de equipo'
		 					OR estado = 'Espera de refacciones')
		 				AND  estado <> 'Cancelado'
         				AND responsable = 41185";

			$pendientesOrfanelMP = Ordenesots::getAllConsulta($consulta);

			$consulta = "SELECT count(orden_trabajo) AS nPendientesMC 
						FROM ordenesots 
						WHERE ( fecha_inicio_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior') 
						AND (tipo='Correctivo planeado' 
							OR tipo='Correctivo de emergencia') 
						AND (estado = 'Programada' 
							OR estado = 'Cierre Lider Mtto' 
							OR estado = 'Ejecutado' 
							OR estado = 'Espera de equipo' 
							OR estado = 'Espera de refacciones') 
						AND estado <> 'Cancelado'
						AND responsable = 41185";

			$pendientesOrfanelMC = Ordenesots::getAllConsulta($consulta);
			// -----------------------------------------------------------------------
			$consulta = "SELECT count(orden_trabajo) AS nPendientesMP 
						FROM ordenesots 
						WHERE ( fecha_inicio_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior')
		 				AND tipo='Mant. preventivo'
		 				AND (estado = 'Programada' 
		 					OR estado = 'Cierre Lider Mtto'
		 					OR estado = 'Ejecutado'
		 					OR estado = 'Espera de equipo'
		 					OR estado = 'Espera de refacciones')
		 				AND  estado <> 'Cancelado'
         				AND responsable = 239";

			$pendientesHumbertoMP = Ordenesots::getAllConsulta($consulta);

			$consulta = "SELECT count(orden_trabajo) AS nPendientesMC 
						FROM ordenesots 
						WHERE ( fecha_inicio_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior') 
						AND (tipo='Correctivo planeado' 
							OR tipo='Correctivo de emergencia') 
						AND (estado = 'Programada' 
							OR estado = 'Cierre Lider Mtto' 
							OR estado = 'Ejecutado' 
							OR estado = 'Espera de equipo' 
							OR estado = 'Espera de refacciones') 
						AND estado <> 'Cancelado'
						AND responsable = 239";

			$pendientesHumbertoMC = Ordenesots::getAllConsulta($consulta);
			/*echo "<br>";
			print_r($pendientesOrfanelMP);
			print_r($pendientesOrfanelMC);
			echo "<br>";
			print_r($pendientesHumbertoMP);
			print_r($pendientesHumbertoMC);	*/


		}
		//print_r($pendientesAnoAnteriorMP);

		
	}
	elseif($semana > 1)
	{
		$semanaNueva = $semana - 1;
		$traerSemana = Calendario_nature::getAllSemana($semanaNueva);
		$temporal_inicio = $traerSemana[0]->fecha_inicio;
		$temporal_fin = $traerSemana[0]->fecha_fin;

		$anoNuevo = $ano - 1;
		if ($ano > 2016) 
		{
			$fechaInicioAnoAnterior = $anoNuevo."-01-01";
			$fechaFinalizacionAnoAnterior = $ano."-".$temporal_fin;

			$consulta = "SELECT count(orden_trabajo) AS nPendientesMP 
						FROM ordenesots 
						WHERE ( fecha_inicio_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior')
		 				AND tipo='Mant. preventivo'
		 				AND (estado = 'Programada' 
		 					OR estado = 'Cierre Lider Mtto'
		 					OR estado = 'Ejecutado'
		 					OR estado = 'Espera de equipo'
		 					OR estado = 'Espera de refacciones')
		 				AND  estado <> 'Cancelado'
         				AND responsable = 41185";

			$pendientesOrfanelMP = Ordenesots::getAllConsulta($consulta);

			$consulta = "SELECT count(orden_trabajo) AS nPendientesMC 
						FROM ordenesots 
						WHERE ( fecha_inicio_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior') 
						AND (tipo='Correctivo planeado' 
							OR tipo='Correctivo de emergencia') 
						AND (estado = 'Programada' 
							OR estado = 'Cierre Lider Mtto' 
							OR estado = 'Ejecutado' 
							OR estado = 'Espera de equipo' 
							OR estado = 'Espera de refacciones') 
						AND estado <> 'Cancelado'
						AND responsable = 41185";

			$pendientesOrfanelMC = Ordenesots::getAllConsulta($consulta);
			// -----------------------------------------------------------------------
			$consulta = "SELECT count(orden_trabajo) AS nPendientesMP 
						FROM ordenesots 
						WHERE ( fecha_inicio_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior')
		 				AND tipo='Mant. preventivo'
		 				AND (estado = 'Programada' 
		 					OR estado = 'Cierre Lider Mtto'
		 					OR estado = 'Ejecutado'
		 					OR estado = 'Espera de equipo'
		 					OR estado = 'Espera de refacciones')
		 				AND  estado <> 'Cancelado'
         				AND responsable = 239";

			$pendientesHumbertoMP = Ordenesots::getAllConsulta($consulta);

			$consulta = "SELECT count(orden_trabajo) AS nPendientesMC 
						FROM ordenesots 
						WHERE ( fecha_inicio_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior') 
						AND (tipo='Correctivo planeado' 
							OR tipo='Correctivo de emergencia') 
						AND (estado = 'Programada' 
							OR estado = 'Cierre Lider Mtto' 
							OR estado = 'Ejecutado' 
							OR estado = 'Espera de equipo' 
							OR estado = 'Espera de refacciones') 
						AND estado <> 'Cancelado'
						AND responsable = 239";

			$pendientesHumbertoMC = Ordenesots::getAllConsulta($consulta);
		}
		else
		{
			$fechaInicioAnoAnterior = $ano."-01-01";
			$fechaFinalizacionAnoAnterior = $ano."-".$temporal_fin;

			$consulta = "SELECT count(orden_trabajo) AS nPendientesMP 
						FROM ordenesots 
						WHERE ( fecha_inicio_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior')
		 				AND tipo='Mant. preventivo'
		 				AND (estado = 'Programada' 
		 					OR estado = 'Cierre Lider Mtto'
		 					OR estado = 'Ejecutado'
		 					OR estado = 'Espera de equipo'
		 					OR estado = 'Espera de refacciones')
		 				AND  estado <> 'Cancelado'
         				AND responsable = 41185";

			$pendientesOrfanelMP = Ordenesots::getAllConsulta($consulta);

			$consulta = "SELECT count(orden_trabajo) AS nPendientesMC 
						FROM ordenesots 
						WHERE ( fecha_inicio_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior') 
						AND (tipo='Correctivo planeado' 
							OR tipo='Correctivo de emergencia') 
						AND (estado = 'Programada' 
							OR estado = 'Cierre Lider Mtto' 
							OR estado = 'Ejecutado' 
							OR estado = 'Espera de equipo' 
							OR estado = 'Espera de refacciones') 
						AND estado <> 'Cancelado'
						AND responsable = 41185";

			$pendientesOrfanelMC = Ordenesots::getAllConsulta($consulta);
			// -----------------------------------------------------------------------
			$consulta = "SELECT count(orden_trabajo) AS nPendientesMP 
						FROM ordenesots 
						WHERE ( fecha_inicio_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior')
		 				AND tipo='Mant. preventivo'
		 				AND (estado = 'Programada' 
		 					OR estado = 'Cierre Lider Mtto'
		 					OR estado = 'Ejecutado'
		 					OR estado = 'Espera de equipo'
		 					OR estado = 'Espera de refacciones')
		 				AND  estado <> 'Cancelado'
         				AND responsable = 239";

			$pendientesHumbertoMP = Ordenesots::getAllConsulta($consulta);

			$consulta = "SELECT count(orden_trabajo) AS nPendientesMC 
						FROM ordenesots 
						WHERE ( fecha_inicio_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior') 
						AND (tipo='Correctivo planeado' 
							OR tipo='Correctivo de emergencia') 
						AND (estado = 'Programada' 
							OR estado = 'Cierre Lider Mtto' 
							OR estado = 'Ejecutado' 
							OR estado = 'Espera de equipo' 
							OR estado = 'Espera de refacciones') 
						AND estado <> 'Cancelado'
						AND responsable = 239";

			$pendientesHumbertoMC = Ordenesots::getAllConsulta($consulta);
		}
		

		
	}


	if($pendientesOrfanelMP != 0 )
	{
		//echo "entro";
		$nPendientesAnoAnteriorMPOrfanel = $pendientesOrfanelMP[0]->nPendientesMP;
	}
	if($pendientesOrfanelMC != 0 )
	{
		$nPendientesAnoAnteriorMCOrfanel = $pendientesOrfanelMC[0]->nPendientesMC;
	}

	if($pendientesHumbertoMP != 0 )
	{
		//echo "entro";
		$nPendientesAnoAnteriorMPHumberto = $pendientesHumbertoMP[0]->nPendientesMP;
	}
	if($pendientesHumbertoMC != 0 )
	{
		$nPendientesAnoAnteriorMCHumberto = $pendientesHumbertoMC[0]->nPendientesMC;
	}

	/*echo $nPendientesAnoAnteriorMPOrfanel."<br>";
	echo $nPendientesAnoAnteriorMCOrfanel."<br><br>";

	echo $nPendientesAnoAnteriorMPHumberto."<br>";
	echo $nPendientesAnoAnteriorMCHumberto."<br>";*/
			/*echo "<br>";
			print_r($pendientesOrfanelMP);
			print_r($pendientesOrfanelMC);
			echo "<br>";
			print_r($pendientesHumbertoMP);
			print_r($pendientesHumbertoMC);	*/
	
	// termina acumulado

	$ordenes = Ordenesots::getAllInicioFin($fechaInicio, $fechaFinalizacion);
	//print_r($ordenes);
	require_once(VIEW_PATH.'indexMpvsMcDetails.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}