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
	$calendarios = Disponibilidad_calendarios::getByDia($fecha_hoy);
	$semana_actual = $calendarios[0]->semana;

	$zancos_tamanos = Zancos_tamanos::getAllByOrden("id", "ASC");

	$consulta = "SELECT * FROM zancos_ghs 
					WHERE zona <> '*'
					GROUP BY zona ORDER BY zona ASC";
	$zancos_zonas = Zancos_ghs::getAllByQuery($consulta);
	
	$consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion

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
			  AND m.tipo_movimiento = 2";
	$zancos_retirados = Zancos_movimientos::getAllByQuery($consulta); 
	
	$consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion, zancos_tamanos.limite_semana, zancos_bd.id AS id, zancos_acciones.accion AS accion_descripcion, zancos_acciones.id AS id_accion, m2.fecha_activacion_o_baja as f_activacion

			FROM zancos_movimientos m
			INNER JOIN
			(
			    SELECT max(id_registro) reg, no_zanco, fecha_activacion_o_baja
			    FROM zancos_movimientos
                
			    GROUP BY no_zanco
			) m2
			  ON m.no_zanco = m2.no_zanco
			  INNER JOIN zancos_acciones ON m.tipo_movimiento = zancos_acciones.id
			  INNER JOIN zancos_tamanos ON m.tamano = zancos_tamanos.id
			  INNER JOIN zancos_bd ON m.no_zanco = zancos_bd.no_zanco
			  AND m.id_registro = m2.reg
              AND m.tipo_movimiento <> 2
			  AND (DATEDIFF('$fecha_hoy', m2.fecha_activacion_o_baja) ) > (547.88)
			  order by m.id_registro desc";
		//echo $consulta;		
	$zancos_mayores = Zancos_movimientos::getAllByQuery($consulta);
	//print_r($zancos_mayores);

	$consulta = "SELECT * FROM zancos_bd
					WHERE no_zanco NOT IN 
						(SELECT no_zanco
                       		FROM zancos_movimientos
                       	)
                    AND no_zanco = 0";
	$zancos_stock = Zancos_bd::getAllByQuery($consulta);

	//echo "<pre>"; print_r($zancos_stock); echo "</pre>";

	$consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion

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
			  AND m.tipo_movimiento = 3
			  AND m.fecha_entrega <> 0
              AND m.fecha_servicio = 0";
	$zancos_servicio = Zancos_bd::getAllByQuery($consulta);


	$consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion

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
			  AND m.tipo_movimiento = 3
			  AND m.fecha_entrega = 0
			  AND (DATEDIFF('$fecha_hoy', m.fecha_salida) ) > (m.tiempo_limite * 7)";

	$zancos_desfase = Zancos_bd::getAllByQuery($consulta);

	$consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion

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
			  AND m.tipo_movimiento = 3
			  AND m.fecha_entrega = 0";
	$zancos_campo = Zancos_bd::getAllByQuery($consulta);

	$consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion

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
			  AND (m.tipo_movimiento = 1
			  		OR (m.tipo_movimiento = 3
			  			AND m.fecha_servicio <> 0) )";
	$zancos_activo = Zancos_bd::getAllByQuery($consulta);

	$consulta = "SELECT * FROM zancos_bd
					WHERE no_zanco NOT IN 
						(SELECT no_zanco
                       		FROM zancos_movimientos
                       	)
                    AND no_zanco > 0";
	$zancos_solo_activados = Zancos_bd::getAllByQuery($consulta);
	//print_r($zancos_solo_activados)

	$consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion

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
			  AND (m.tipo_movimiento = 1																/*disponible*/
			  		OR (m.tipo_movimiento = 3 AND m.fecha_servicio <> 0)    							/*disponible*/
			  		OR (m.tipo_movimiento = 3 AND m.fecha_entrega = 0)									/*campo*/
			  		OR (m.tipo_movimiento = 3 AND m.fecha_entrega <> 0 AND m.fecha_servicio = 0)        /*servicio*/
			  		)";
	$zancos_total = Zancos_bd::getAllByQuery($consulta);
	//echo $q;
	//print_r($zancos_stock);
	// Include page view
	require_once(VIEW_PATH.'indexZancos_dashboard.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}