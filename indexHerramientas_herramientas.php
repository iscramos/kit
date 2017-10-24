<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 1)
{
	if(isset($_GET["id_categoria"]) && intval($_GET["id_categoria"]) > 0 && isset($_GET["id_almacen"]) && intval($_GET["id_almacen"]) > 0 )
	{
		$id_categoria = $_GET['id_categoria'];
		$id_almacen = $_GET['id_almacen']; 

		$categorias = Herramientas_categorias::getById($id_categoria);
		$almacenes = Herramientas_almacenes::getById($id_almacen);
		$herramientas_herramientas = Herramientas_herramientas::getAllInnerAlmacenAndCategoria($id_almacen, $id_categoria);
		//print_r($herramientas_heramientas);
		// Include page view
		
	}
	else
	{
		$herramientas_herramientas = Herramientas_herramientas::getAll();
	}
	require_once(VIEW_PATH.'indexHerramientas_herramientas.view.php');
	
	
}
else
{
	// Include page view
	redirect_to('index.php');
}