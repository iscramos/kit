<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 1 || $_SESSION["type"] == 4 || $_SESSION["type"] == 6 || $_SESSION["type"] == 7 || $_SESSION["type"] == 8) // for admin, taller mecanico, taller hidroelectrico
{	
	$consulta = "SELECT * FROM disponibilidad_activos WHERE activo LIKE 'CO-BMU%'
											OR activo LIKE 'CO-COM%'
											OR activo LIKE 'CO-POZ%'
											AND organizacion = 'COL' ORDER BY activo ASC";

	$equipos = Disponibilidad_activos::getAllByQuery($consulta);
	$tipos = tipoMedicion_rebombeo::getAllByOrden("descripcion", "ASC");

	//print_r($equipos);

	require_once(VIEW_PATH.'indexGraficaRebombeo.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}