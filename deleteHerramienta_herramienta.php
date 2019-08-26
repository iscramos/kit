<?php

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

// Check the querystring
if (isset($_REQUEST['accion'])) 
{
	$accion = $_REQUEST['accion'];

	if($accion = "RETIRAR")
	{
		// Get id from querystring
		$clave = $_GET['clave'];
		$retirado = 1;
		$fecha_retirado = date("Y-m-d");
		
		// Execute database query
		$herramienta = new Herramientas_herramientas();
		$herramienta->clave = $clave;
		$herramienta->retirado = $retirado;
		$herramienta->fecha_retirado = $fecha_retirado;
		$herramienta->retirar();
	}
		
}

// Redirect to site root
redirect_to('indexHerramientas_herramientas.php');
?>