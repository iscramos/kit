<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_GET['equipo']) && ($_SESSION["type"]==1 || $_SESSION["type"]==6 || $_SESSION["type"]==7)) // para el admimistrador
{	
	//$mes = $_GET['mes'];
	$equipo = $_GET['equipo'];
	$ano = $_GET['ano'];
	$mes = $_GET['mes'];
	$semanaActual = "0";
	$inicio = "";
	$fin = "";
	$tipoMedicion_rebombeo = $_GET['tipo']; // Para voltajes y corrientes
	

	$min_calendario = Disponibilidad_calendarios::getMinDiaByAnoMes($mes, $ano);    
    $max_calendario = Disponibilidad_calendarios::getMaxDiaByAnoMes($mes, $ano);
    $inicio = $min_calendario[0]->dia;
   	$fin = $max_calendario[0]->dia; 
	
	
   	$consulta = "SELECT bd_rebombeo.*, disponibilidad_activos.descripcion
					FROM bd_rebombeo
					INNER JOIN disponibilidad_activos ON bd_rebombeo.equipo = disponibilidad_activos.activo
					INNER JOIN tipoMedicion_rebombeo ON bd_rebombeo.tipo = tipoMedicion_rebombeo.id
						WHERE bd_rebombeo.fechaLectura 
							BETWEEN '$inicio' 
								AND '$fin'
							AND bd_rebombeo.equipo = '$equipo'
							AND tipoMedicion_rebombeo.id = $tipoMedicion_rebombeo
					ORDER BY bd_rebombeo.fechaLectura ASC";

	//echo $consulta;
	/*$consulta = "SELECT bd_rebombeo.*, disponibilidad_activos.descripcion, tipoMedicion_rebombeo.descripcion as tipoM
					FROM bd_rebombeo
					INNER JOIN disponibilidad_activos ON bd_rebombeo.equipo = disponibilidad_activos.activo
					INNER JOIN tipoMedicion_rebombeo ON bd_rebombeo.tipo = tipoMedicion_rebombeo.id
					WHERE disponibilidad_activos.organizacion = 'COL'
					ORDER BY bd_rebombeo.fechaLectura DESC";*/


	$mediciones = Bd_rebombeo::getAllByQuery($consulta);

	header('Content-type: application/json; charset=utf-8');
    echo json_encode($mediciones, JSON_FORCE_OBJECT);

		/* TERMINA TABLA DE ANALISIS GENERAL*/
	
}
else
{
	$str.="NO DATA";
}


echo $str;


?>
