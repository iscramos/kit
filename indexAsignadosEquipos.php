<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

if($_SESSION["type"] == 1 || $_SESSION["type"] == 4 || $_SESSION["type"] == 6 || $_SESSION["type"] == 7 || $_SESSION["type"] == 8) // for admin, taller mecanico, taller hidroelectrico
{
	
	$actualizado = "";
	if(isset($_REQUEST["actualizado"]))
	{	
		$actualizado = $_REQUEST["actualizado"];
	}

	// Include page view
	require_once(VIEW_PATH.'indexAsignadosEquipos.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}