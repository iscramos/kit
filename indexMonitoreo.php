<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 1 || $_SESSION["type"] == 4 || $_SESSION["type"] == 6 || $_SESSION["type"] == 7 || $_SESSION["type"] == 8) // for admin, taller mecanico, taller hidroelectrico
{	
	$actualizado = "";
	$lider = 0;
	/*if(isset($_REQUEST["actualizado"]))
	{	
		$actualizado = $_REQUEST["actualizado"];
	}*/

	if(isset($_REQUEST["lider"]))
	{
		$lider = $_REQUEST["lider"];
	}
	//echo $lider;
	
	//$groups = Luxes_group::getAll();
	// Include page view
	require_once(VIEW_PATH.'indexMonitoreo.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}