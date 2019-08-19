<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 5)
{
	// Include page view
	$direccion0 = "http://192.168.167.231/proapp/ws/";
    $json_asociado = file_get_contents($direccion0);
    $asociadoData = json_decode($json_asociado, true);
    

	require_once(VIEW_PATH.'indexHerramientas_salidas.view.php');	
}
else
{
	// Include page view
	redirect_to('index.php');
}