<?php

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

// Check the querystring for a numeric id
if (isset($_GET['id']) && intval($_GET['id']) > 0) 
{
	
	// Get id from querystring
	$id = $_GET['id'];
	
	// Execute database query
	$activo = new Activos_equipos();
	$activo->id = $id;
	$activo->delete();	
}

// Redirect to site root
redirect_to('indexActivosEquipos.php');
?>