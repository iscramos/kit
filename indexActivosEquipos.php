<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

if($_SESSION["type"] == 1)
{
	$activos_equipos = Activos_equipos::getAll();
	// Include page view
	require_once(VIEW_PATH.'indexActivosEquipos.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}