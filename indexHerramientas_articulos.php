<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 5)
{
	
	//print_r($herramientas_herramientas);

	$herramientas_categorias = Herramientas_categorias::getAllByOrden("categoria", "ASC");
	$herramientas_proveedores = Herramientas_proveedores::getAllByOrden("descripcion", "ASC");
	//print_r($herramientas_categorias);
	// Include page view
	require_once(VIEW_PATH.'indexHerramientas_articulos.view.php');
	
	
}
else
{
	// Include page view
	redirect_to('index.php');
}