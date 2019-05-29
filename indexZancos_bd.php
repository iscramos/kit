<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 9)
{
	$consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion, zancos_tamanos.limite_semana, zancos_bd.id AS id, zancos_acciones.accion AS accion_descripcion, zancos_acciones.id AS id_accion,
				(SELECT zancos_movimientos.fecha_activacion_o_baja 
				 		FROM zancos_movimientos
				 		WHERE zancos_movimientos.tipo_movimiento = 1
				 		AND zancos_movimientos.no_zanco = m.no_zanco
				 ) AS f_activacion,
				 (SELECT zancos_movimientos.id_registro
				 		FROM zancos_movimientos
				 		WHERE zancos_movimientos.tipo_movimiento = 1
				 		AND zancos_movimientos.no_zanco = m.no_zanco

			  
				 ) AS id_reg_activacion

			FROM zancos_movimientos m
			INNER JOIN
			(
			    SELECT max(id_registro) reg, no_zanco
			    FROM zancos_movimientos
			    GROUP BY no_zanco
			) m2
			  ON m.no_zanco = m2.no_zanco
			  INNER JOIN zancos_acciones ON m.tipo_movimiento = zancos_acciones.id
			  INNER JOIN zancos_tamanos ON m.tamano = zancos_tamanos.id
			  INNER JOIN zancos_bd ON m.no_zanco = zancos_bd.no_zanco
			  AND m.id_registro = m2.reg
			  AND m.no_zanco > 0
			  ORDER BY m.no_zanco DESC";
				
	$zancos_bd = Zancos_bd::getAllByQuery($consulta);
	
	$consulta = "SELECT zancos_bd.*, zancos_tamanos.limite_semana, zancos_tamanos.tamano AS tamano_descripcion FROM zancos_bd
					INNER JOIN zancos_tamanos ON zancos_bd.tamano = zancos_tamanos.id
					WHERE no_zanco NOT IN 
						(SELECT no_zanco
                       		FROM zancos_movimientos
                       	)";
	$zancos_stock = Zancos_bd::getAllByQuery($consulta);
	// Include page view
	require_once(VIEW_PATH.'indexZancos_bd.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}