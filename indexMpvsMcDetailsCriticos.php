<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if(($_SESSION["type"]==1 || $_SESSION["type"]==6 || $_SESSION["type"]==7 || $_SESSION["type"] == 4))
{
	//$disponibilidad = Ordenesos::getAllByMes();
	// Include page view
	$semana = $_GET["semana"];
	$fechaInicio = $_GET["fechaInicio"];
	$fechaFinalizacion = $_GET["fechaFinalizacion"];
	$ano = $_GET["ano"];

	$ordenes = Ordenesots::getAllInicioFinCriticos($fechaInicio, $fechaFinalizacion);
	//print_r($ordenes);
	require_once(VIEW_PATH.'indexMpvsMcDetailsCriticos.view.php');
}
else
{
	// Include page view
	redirect_to('index.php'); 
}