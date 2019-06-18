<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 9)
{
	$q = "SELECT zancos_movimientos.*, zancos_tamanos.tamano AS descripcion_tamano, zancos_tamanos.limite_semana, zancos_acciones.accion, zancos_problemas.descripcion AS problema_descripcion
			FROM  zancos_movimientos
			INNER JOIN zancos_tamanos ON zancos_movimientos.tamano = zancos_tamanos.id
			INNER JOIN zancos_acciones ON zancos_movimientos.tipo_movimiento = zancos_acciones.id
			LEFT JOIN zancos_problemas ON zancos_movimientos.descripcion_problema = zancos_problemas.id
			ORDER BY zancos_movimientos.id_registro DESC";
			
	$zancos_movimientos = Zancos_movimientos::getAllByQuery($q);
	
	// Include page view
	require_once(VIEW_PATH.'indexZancos_movimientos.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}