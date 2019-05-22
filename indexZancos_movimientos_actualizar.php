<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 9)
{
	$action = "";
	$reg = "";
	$mov = 0;
	$registro_autoincrementa = 1;

	if(isset($_GET['action']) && isset($_GET["reg"]) && isset($_GET["mov"]) )
	{
		$action = $_GET['action'];
		$reg = $_GET['reg'];
		$mov = $_GET['mov'];
	}
	else
	{
		redirect_to('indexZancos_movimientos.php');
	}

	
	$movimiento_max = Zancos_movimientos::getAllLastInsert();
	
	
	$q = "";

	if($mov == 0)
	{
		if(count($movimiento_max) > 0)
		{
			$registro_autoincrementa = $movimiento_max[0]->ultimo + 1;
		}
	}
	elseif($mov == 1) // activacion
	{
		$q = "SELECT zancos_movimientos.*, zancos_tamanos.tamano AS descripcion_tamano, zancos_tamanos.limite_semana, zancos_acciones.accion
			FROM  zancos_movimientos
			INNER JOIN zancos_tamanos ON zancos_movimientos.tamano = zancos_tamanos.id
			INNER JOIN zancos_acciones ON zancos_movimientos.tipo_movimiento = zancos_acciones.id
				WHERE zancos_movimientos.id_registro = $reg
			ORDER BY zancos_movimientos.id_registro DESC";

		$zancos_movimientos = Zancos_movimientos::getAllByQuery($q);

	}
	elseif($mov == 2) // baja
	{
		$q = "SELECT zancos_movimientos.*, zancos_tamanos.tamano AS descripcion_tamano, zancos_tamanos.limite_semana, zancos_acciones.accion
			FROM  zancos_movimientos
			INNER JOIN zancos_tamanos ON zancos_movimientos.tamano = zancos_tamanos.id
			INNER JOIN zancos_acciones ON zancos_movimientos.tipo_movimiento = zancos_acciones.id
				WHERE zancos_movimientos.id_registro = $reg
			ORDER BY zancos_movimientos.id_registro DESC";

		$zancos_movimientos = Zancos_movimientos::getAllByQuery($q);
	}
	elseif($mov == 3) // activacion
	{
		$q = "SELECT zancos_movimientos.*, zancos_tamanos.tamano AS descripcion_tamano, zancos_tamanos.limite_semana, zancos_acciones.accion
			FROM  zancos_movimientos
			INNER JOIN zancos_tamanos ON zancos_movimientos.tamano = zancos_tamanos.id
			INNER JOIN zancos_acciones ON zancos_movimientos.tipo_movimiento = zancos_acciones.id
				WHERE zancos_movimientos.id_registro = $reg
			ORDER BY zancos_movimientos.id_registro DESC";

		$zancos_movimientos = Zancos_movimientos::getAllByQuery($q);

	}
	


	

	$zancos_acciones = Zancos_acciones::getAllByOrden("accion", "ASC");
	$zancos_ghs = Zancos_ghs::getAllByOrden("gh", "ASC");
	$zancos_lideres = Zancos_lideres::getAllByOrden("ns", "ASC");
	$zancos_problemas = Zancos_problemas::getAllByOrden("descripcion", "ASC");
	// Include page view
	require_once(VIEW_PATH.'indexZancos_movimientos_actualizar.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}