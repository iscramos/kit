<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 1)
{
	$parametro1 = "Correctivo de emergencia";
	$parametro2 = "Correctivo planeado";
	$mps = Ordenesots::getAllbyMc($parametro1, $parametro2);
	// Include page view
	require_once(VIEW_PATH.'indexMcs.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}