<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 5)
{
	if(isset($_GET["clave"]) )
	{	
		$clave = $_GET["clave"];
		$q = "SELECT herramientas_movimientos.*, zancos_acciones.accion, zancos_problemas.descripcion AS problema_descripcion
			FROM  herramientas_movimientos
			
			INNER JOIN zancos_acciones ON herramientas_movimientos.tipo_movimiento = zancos_acciones.id
			LEFT JOIN zancos_problemas ON herramientas_movimientos.descripcion_problema = zancos_problemas.id
			WHERE herramientas_movimientos.clave = '$clave'
			ORDER BY herramientas_movimientos.id_registro DESC";
			
		$herramientas_movimientos = Herramientas_movimientos::getAllByQuery($q);
	}
	else
	{
		$q = "SELECT herramientas_movimientos.*, zancos_acciones.accion, zancos_problemas.descripcion AS problema_descripcion
			FROM  herramientas_movimientos
			
			INNER JOIN zancos_acciones ON herramientas_movimientos.tipo_movimiento = zancos_acciones.id
			LEFT JOIN zancos_problemas ON herramientas_movimientos.descripcion_problema = zancos_problemas.id
			ORDER BY herramientas_movimientos.id_registro DESC";
			
		$herramientas_movimientos = Herramientas_movimientos::getAllByQuery($q);
	}
	// Include page view
	require_once(VIEW_PATH.'indexHerramientas_movimientos.view.php');
	
	
}
else
{
	// Include page view
	redirect_to('index.php');
}