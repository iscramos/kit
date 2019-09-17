<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_REQUEST['consulta']) && ($_SESSION["type"]==1 || $_SESSION["type"]==6 || $_SESSION["type"]==7 || $_SESSION["type"] == 10)) // para el admimistrador
{
	$consulta = $_GET['consulta'];

	if($consulta == "CONSULTA_MEDICION")
	{
		$equipo = $_GET['equipo'];
		$ano = $_GET['ano'];
		$mes = $_GET['mes'];
		$tipoMedicion_rebombeo = $_GET['tipo']; // 

		$min_calendario = Disponibilidad_calendarios::getMinDiaByAnoMes($mes, $ano); 
	    
	    $inicio = ($min_calendario[0]->dia);
	   	$mes_dia_anterior = strtotime( '-1 day' , strtotime($inicio )); 
	   	$mes_dia_anterior = date("Y-m-d", $mes_dia_anterior);

	   	$q =  "SELECT * FROM bd_rebombeo where DATE_FORMAT(fechaLectura, '%Y-%m-%d') = '$mes_dia_anterior'
	   			AND tipo = $tipoMedicion_rebombeo
	   			AND equipo = '$equipo' ";

	   	//echo $q;
	   	$datos = Bd_rebombeo::getAllByQuery($q);
	   	//print_r($datos);
		if(count($datos) > 0)
		{
			if($datos[0]->equipo == "CO-BMU-009")
			{
				$str = $datos[0]->m_consumidos;
			}
			else
			{
				$str = ($datos[0]->m_consumidos) * 10;
			}
			
		}else
		{
			$str = 0;
		}
		
	}
	
}
else
{
	$str.="NO DATA";
}


echo $str;


?>
