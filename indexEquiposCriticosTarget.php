<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

if($_SESSION["type"] == 1)
{
	$query = "SELECT * FROM disponibilidad_activos
				WHERE criticidad = 'Alta'
				AND familia <> 'INVERNADEROS'
				ORDER BY activo ASC"; 

	$activos_equipos = Disponibilidad_activos::getAllByQuery($query);
	//print_r($activos_equipos);
	// Include page view
	require_once(VIEW_PATH.'indexEquiposCriticosTarget.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}