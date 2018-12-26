<?php

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

// Check the querystring for a numeric id
if (isset($_REQUEST['id']) && intval($_REQUEST['id']) > 0) 
{
	
	// Get id from querystring
	$id = $_GET['id'];
	
	// Execute database query
	$asociado = new Recursos_asociados();
	$asociado->id = $id;
	$asociado->delete();	
}

// Redirect to site root
redirect_to('indexRecursosAsociados.php');
?>