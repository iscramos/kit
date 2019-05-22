<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 9)
{
	$fecha_hoy = date("Y-m-d");
	
	$q = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion, 
				
				 (SELECT zancos_movimientos.fecha_activacion_o_baja 
				 		FROM zancos_movimientos
				 		WHERE zancos_movimientos.tipo_movimiento = 1
				 		AND zancos_movimientos.no_zanco = m.no_zanco
				 ) AS f_activacion

			FROM zancos_movimientos m
			INNER JOIN
			(
			    SELECT max(id_registro) reg, no_zanco
			    FROM zancos_movimientos
			    GROUP BY no_zanco
			) m2
			  ON m.no_zanco = m2.no_zanco
			  INNER JOIN zancos_tamanos ON m.tamano = zancos_tamanos.id
			  AND m.id_registro = m2.reg
			  AND m.tipo_movimiento = 1
			order by m.id_registro desc";
				
	$zancos_movimientos = Zancos_movimientos::getAllByQuery($q);
	//echo $q;
	//print_r($zancos_movimientos);
	// Include page view
	require_once(VIEW_PATH.'indexZancos_reportes_mayor.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}