<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if(($_SESSION["type"]==1 || $_SESSION["type"]==6 || $_SESSION["type"]==7) && (isset($_GET['ano']) ) && isset($_GET['responsable']))
{
	$ano = $_GET['ano'];
	$responsable = $_GET['responsable']; 
	$nombreResponsable = "";

	if($responsable == 239)
	{
		$nombreResponsable = "ING. Humberto";
	}
	elseif ($responsable == 41185) 
	{
		$nombreResponsable = "ING. Orfanel";
	}
	// Include page view
	require_once(VIEW_PATH.'indexMp_mc_lider.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
} 