<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_REQUEST['equipo']) && ($_SESSION["type"]==1 || $_SESSION["type"]==6 || $_SESSION["type"]==7)) // para el admimistrador
{	
	//$mes = $_GET['mes'];
	$equipo = $_REQUEST['equipo'];

	$respuesta = Equipos_rebombeo::getByEquipo($equipo);
	
	

    	
	$str.=$respuesta->hp."&".$respuesta->voltaje_minimo."&".$respuesta->voltaje_maximo."&".$respuesta->amperaje_minimo."&".$respuesta->amperaje_maximo;

	
}
else
{
	echo "NO REQUEST";
}


echo $str;


?>
