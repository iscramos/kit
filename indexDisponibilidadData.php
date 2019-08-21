<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 1)
{
	$q = "SELECT * FROM disponibilidad_data ORDER BY ot ASC LIMIT 100";
	//$disponibilidad_data = Disponibilidad_data::getAllByOrden("ot", "asc");
	$disponibilidad_data = Disponibilidad_data::getAllByQuery($q);
	// Include page view
	require_once(VIEW_PATH.'indexDisponibilidadData.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}