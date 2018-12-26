<?php

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

// Check the querystring for a numeric id
if (isset($_REQUEST['id']) && intval($_REQUEST['id']) > 0) 
{
	
	// Get id from querystring
	$id = $_GET['id'];
	$id_herramienta = $_GET['id_herramienta'];
	
	// Execute database query
	$prestamo = new Herramientas_prestamos();
	$prestamo->id = $id;
	$prestamo->delete();	
}

// Redirect to site root
redirect_to('indexHerramientas_prestamos.php?id_herramienta='.$id_herramienta);
?>