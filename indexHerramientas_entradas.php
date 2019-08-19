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
	$q = "SELECT herramientas_entradas.*, herramientas_herramientas.descripcion 
			FROM herramientas_entradas
				INNER JOIN herramientas_herramientas ON herramientas_entradas.clave = herramientas_herramientas.clave
					ORDER BY herramientas_entradas.id DESC";
	$herramientas_entradas = Herramientas_entradas::getAllByQuery($q);
	//print_r($herramientas_categorias);
	// Include page view
	require_once(VIEW_PATH.'indexHerramientas_entradas.view.php');
	
	
}
else
{
	// Include page view
	redirect_to('index.php');
}