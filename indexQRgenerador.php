<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

if($_SESSION["type"] == 1)
{
	require_once(VIEW_PATH.'indexQRgenerador.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}