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
	
	$consulta = "SELECT count(clave) AS retirados, id_categoria 
					FROM herramientas_herramientas
						WHERE retirado = 1
							AND activaStock = 0
							GROUP BY id_categoria ORDER BY id_categoria ASC";

				//echo $consulta;

	$herramientas_retirados = Herramientas_herramientas::getAllByQuery($consulta);

	//print_r($herramientas_herramientas);

	$consulta = "SELECT count(herramientas_herramientas.clave) AS prestados, herramientas_herramientas.id_categoria 
					FROM herramientas_movimientos
						INNER JOIN herramientas_herramientas ON herramientas_movimientos.clave = herramientas_herramientas.clave
						WHERE herramientas_movimientos.tipo_movimiento = 3
							AND herramientas_movimientos.fecha_entrega = ''
							GROUP BY herramientas_herramientas.id_categoria ORDER BY herramientas_herramientas.id_categoria ASC";
	//echo $consulta;
	$herramientas_prestadas = Herramientas_movimientos::getAllByQuery($consulta);
	//print_r($herramientas_prestadas);

	$consulta = "SELECT count(herramientas_herramientas.clave) AS disponibles, herramientas_herramientas.id_categoria 
					FROM herramientas_movimientos
						INNER JOIN herramientas_herramientas ON herramientas_movimientos.clave = herramientas_herramientas.clave
						WHERE herramientas_movimientos.tipo_movimiento = 3
							AND herramientas_movimientos.fecha_entrega <> ''
							AND herramientas_movimientos.fecha_servicio <> ''
							AND herramientas_movimientos.descripcion_problema > 0
							GROUP BY herramientas_herramientas.id_categoria ORDER BY herramientas_herramientas.id_categoria ASC";
	//echo $consulta;
	$herramientas_disponibles = Herramientas_movimientos::getAllByQuery($consulta);
	//print_r($herramientas_prestadas);



	$consulta = "SELECT count(clave) AS stock, id_categoria FROM herramientas_herramientas
					WHERE clave NOT IN 
						(SELECT clave
                       		FROM herramientas_movimientos
                       	)
                    AND activaStock = 0
                    GROUP BY id_categoria ORDER BY id_categoria ASC";
	$herramientas_stock = Herramientas_herramientas::getAllByQuery($consulta);
	//echo "<pre>"; print_r($zancos_stock); echo "</pre>";


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