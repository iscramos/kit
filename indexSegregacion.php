<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if( ($_SESSION["type"] == 6 || $_SESSION["type"] == 7)  && isset($_REQUEST['lider'])) // for admin, taller mecanico
{	
	$lider = $_REQUEST['lider'];
	//echo $lider;
	//$disponibilidad = Ordenesos::getAllByMes();
	// Include page view
	$anos = Disponibilidad_anos::getAllByOrden("ano", "DESC");
	require_once(VIEW_PATH.'indexSegregacion.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}