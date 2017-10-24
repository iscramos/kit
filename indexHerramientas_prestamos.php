<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 1)
{
	if(isset($_GET["id_herramienta"]) && intval($_GET["id_herramienta"]) > 0 )
	{
		$id_herramienta = $_GET['id_herramienta'];
		//echo $id_herramienta;

		$herramientas = Herramientas_herramientas::getByIdInner($id_herramienta);
		
		$herramientas_prestamos = Herramientas_prestamos::getAllByIdHerramienta($id_herramienta);
		//print_r($herramientas_prestamos);
	}
	else
	{
		$herramientas_prestamos = Herramientas_prestamos::getAll();
	}

	// Include page view
	require_once(VIEW_PATH.'indexHerramientas_prestamos.view.php');
	
	
}
else
{
	// Include page view
	redirect_to('index.php');
}