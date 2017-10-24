<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 1 || $_SESSION["type"] == 6 || $_SESSION["type"] == 7) // for admin, taller mecanico, taller hidroelectrico
{
	//$disponibilidad = Ordenesos::getAllByMes();
	// Include page view
	$actualizado = "";
	
	if(isset($_REQUEST["actualizado"]))
	{	
		$actualizado = $_REQUEST["actualizado"];
	}
	require_once(VIEW_PATH.'indexDisponibilidad.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}