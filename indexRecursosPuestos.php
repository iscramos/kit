<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 1)
{
	$recursos_puestos = Recursos_puestos::getAllByOrden("id", "asc");
	// Include page view
	require_once(VIEW_PATH.'indexRecursosPuestos.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}