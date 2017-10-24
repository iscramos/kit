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
	$ideal = new Mpideales();
	$ideal->id = $id;
	$ideal->delete();	
}

// Redirect to site root
redirect_to('indexMpIdeal.php');
?>