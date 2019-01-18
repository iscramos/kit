<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

if($_SESSION["type"] == 1)
{
	$query = "SELECT planner.*, disponibilidad_activos.descripcion as descripcion 
					FROM planner
					INNER JOIN disponibilidad_activos ON planner.equipo = disponibilidad_activos.activo
						ORDER BY planner.fecha_realizacion DESC"; 


	$planner = Planner::getAllByQuery($query);
	//print_r($activos_equipos);
	// Include page view
	require_once(VIEW_PATH.'indexPlanner.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}