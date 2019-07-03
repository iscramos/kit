<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 5)
{
	$action = "";
	$reg = "";
	$mov = 0;
	$registro_autoincrementa = 1;

	if(isset($_GET['action']) && isset($_GET["reg"]) && isset($_GET["mov"]) && isset($_GET["clave"]))
	{
		$action = $_GET['action'];
		$reg = $_GET['reg'];
		$mov = $_GET['mov'];
		$clave = $_GET['clave'];
	}
	else
	{
		redirect_to('indexZancos_movimientos.php');
	}

	
	$movimiento_max = Herramientas_movimientos::getAllLastInsert();
	
	
	$q = "";

	if($mov == 0)
	{
		if(count($movimiento_max) > 0)
		{
			$registro_autoincrementa = $movimiento_max[0]->ultimo + 1;
		}

		$articulo = Herramientas_herramientas::getByClave($clave);

	}
	elseif($mov == 3) // disposicion
	{
		$q = "SELECT herramientas_movimientos.*, zancos_acciones.accion, herramientas_herramientas.archivo AS archivo
			FROM  herramientas_movimientos
			INNER JOIN herramientas_herramientas ON herramientas_movimientos.clave = herramientas_herramientas.clave
			INNER JOIN zancos_acciones ON herramientas_movimientos.tipo_movimiento = zancos_acciones.id
				WHERE herramientas_movimientos.id_registro = $reg
			ORDER BY herramientas_movimientos.id_registro DESC";

		$herramientas_movimientos = Herramientas_movimientos::getAllByQuery($q);
		
	}
	


	

	$herramientas_acciones = Zancos_acciones::getAllByOrden("accion", "ASC");
	$herramientas_ghs = Zancos_ghs::getAllByOrden("gh", "ASC");
	
	$herramientas_problemas = Zancos_problemas::getAllByOrden("descripcion", "ASC");
	// Include page view
	require_once(VIEW_PATH.'indexHerramientas_movimientos_actualizar.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}