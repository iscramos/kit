<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 1 || $_SESSION["type"] == 8)
{
	$recursos_bonos_semanal = Recursos_bonos_semanal::getAllByOrden("id", "desc");
	// Include page view
	require_once(VIEW_PATH.'indexRecursosBonosSemanales.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}