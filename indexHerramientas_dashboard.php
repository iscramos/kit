<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 5)
{
	$fecha_hoy = date("Y-m-d");
	$calendarios = Disponibilidad_calendarios::getByDia($fecha_hoy);
	$semana_actual = $calendarios[0]->semana;

	$consulta = "SELECT * FROM zancos_ghs
					GROUP BY zona ORDER BY zona ASC";
	$zancos_zonas = Zancos_ghs::getAllByQuery($consulta);
	
	$consulta = "SELECT  id_categoria 
					FROM herramientas_herramientas
						WHERE retirado = 1
							AND activaStock = 0
							 ORDER BY id_categoria ASC";

				//echo $consulta;

	$herramientas_retirados = Herramientas_herramientas::getAllByQuery($consulta);

	//print_r($herramientas_retirados);

	$consulta = "SELECT  id_categoria 
					FROM herramientas_herramientas
						WHERE retirado <> 1
							AND activaStock = 0
							AND (DATEDIFF('$fecha_hoy', fecha_entrada) ) > (547.88)
							 ORDER BY id_categoria ASC";

				//echo $consulta;

	$herramientas_mayores = Herramientas_herramientas::getAllByQuery($consulta);

	
	$consulta = "SELECT h.*,
					   m.id_registro,
				       m.tipo_movimiento,
				       m.fecha_entrega,
				       m.descripcion_problema,
				       m.zona
				  FROM herramientas_herramientas h
				  INNER JOIN herramientas_movimientos m
				    ON m.clave = h.clave
				   	AND m.id_registro = (SELECT max(m2.id_registro)
				                               FROM herramientas_movimientos m2
				                              WHERE m2.clave = m.clave)
				    WHERE m.fecha_entrega <> 0 
				    	AND m.fecha_servicio = 0";
	//echo $consulta;
	$herramientas_servicio = Herramientas_movimientos::getAllByQuery($consulta);

	
	$consulta = "SELECT h.*,
					   m.id_registro,
				       m.tipo_movimiento,
				       m.fecha_entrega,
				       m.descripcion_problema,
				       m.zona
				  FROM herramientas_herramientas h
				  INNER JOIN herramientas_movimientos m
				    ON m.clave = h.clave
				   	AND m.id_registro = (SELECT max(m2.id_registro)
				                               FROM herramientas_movimientos m2
				                              WHERE m2.clave = m.clave)
				    WHERE m.fecha_entrega = '' ";
	//echo $consulta;
	$herramientas_prestadas = Herramientas_movimientos::getAllByQuery($consulta);
	//print_r($herramientas_prestadas);

	$consulta = "SELECT h.*,
					   m.id_registro,
				       m.tipo_movimiento,
				       m.fecha_entrega,
				       m.descripcion_problema
				  FROM herramientas_herramientas h
				  INNER JOIN herramientas_movimientos m
				    ON m.clave = h.clave
				   	AND m.id_registro = (SELECT max(m2.id_registro)
				                               FROM herramientas_movimientos m2
				                              WHERE m2.clave = m.clave)
				    WHERE m.fecha_servicio <> 0
				    		AND m.descripcion_problema <> 0";
				    

	//echo $consulta;
	$herramientas_disponibles = Herramientas_movimientos::getAllByQuery($consulta);
	//print_r($herramientas_prestadas);



	$consulta = "SELECT * FROM herramientas_herramientas
					WHERE clave NOT IN 
						(SELECT clave
                       		FROM herramientas_movimientos
                       	)
                    AND activaStock = 0
                    AND fecha_retirado = 0";
	$herramientas_stock = Herramientas_herramientas::getAllByQuery($consulta);
	//echo "<pre>"; print_r($herramientas_stock); echo "</pre>";


	$categorias = Herramientas_categorias::getAll();
	//echo $q;
	//print_r($zancos_stock);
	// Include page view
	require_once(VIEW_PATH.'indexHerramientas_dashboard.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}