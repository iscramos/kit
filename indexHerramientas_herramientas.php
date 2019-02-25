<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 5)
{
	
	$consulta = "SELECT herramientas_herramientas.*, 
					(SELECT herramientas_prestamos.estatus
						FROM herramientas_prestamos 
							WHERE id_herramienta = herramientas_herramientas.id 
								ORDER BY herramientas_herramientas.id 
									DESC LIMIT 1
					)  AS estatus
				FROM herramientas_herramientas";
	$herramientas_herramientas = Herramientas_herramientas::getAllByQuery($consulta);

	
	//$herramientas_herramientas = Herramientas_herramientas::getAllByOrden("descripcion", "ASC");
	
	require_once(VIEW_PATH.'indexHerramientas_herramientas.view.php');
	
	
}
else
{
	// Include page view
	redirect_to('index.php');
}