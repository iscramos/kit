<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

if($_SESSION["type"] == 1 || $_SESSION["type"] == 6 || $_SESSION["type"] == 7) // for admin, taller mecanico, taller hidroelectrico
{
	$ordenesots = Ordenesots::getAll();
	// Include page view
	require_once(VIEW_PATH.'indexOrdenesOts.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}