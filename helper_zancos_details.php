<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_REQUEST['consulta']) && ($_SESSION["type"] == 9 || $_SESSION["type"] == 10 ) ) // para zancos
{	
	//$mes = $_GET['mes'];
	$consulta = $_REQUEST['consulta'];
	
	$str.="<style type='text/css'> 
				
				table {
  					border-spacing: 0px;
  					border:none !important;
  				}
				.header-fixed{
				  display: block;
				  position: relative;
				  height: 400px;
				  overflow: auto;
				}

				.header-fixed thead,
				.header-fixed tbody{
				  display: block;
				}

				.header-fixed thead{
				  position: sticky;
				  top: 0;
				  right: 0;
				}

				.header-fixed tr{
				  display: flex;
				  align-items: center;
				}

				.header-fixed th,
				.header-fixed td{
				  
				  padding: 0.5em;
				}

				.header-fixed th{
				  text-align: left;
				}
				</style>";
	$fecha_hoy = date("Y-m-d");

	if($consulta == "RETIRADOS")
	{
		$tamano = $_REQUEST['tamano'];

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
			  AND m.tipo_movimiento = 2
			  AND m.tamano = $tamano
			  ORDER BY m.no_zanco";
		
		$zancos_retirados = Zancos_movimientos::getAllByQuery($consulta);

		

		$str.="<table class='table header-fixed jambo_table dataTables_wrapper'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<td style='width: 20%'>#</td>";
						$str.="<td style='width: 40%'>ZANCO</td>";
						$str.="<td style='width: 40%'>TAMAÑO</td>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$i = 1;
					foreach ($zancos_retirados as $retirados) 
					{
						$str.="<tr>";
							$str.="<td style='width: 20%'>".$i."</td>";
							$str.="<td style='width: 40%'>".$retirados->no_zanco."</td>";
							$str.="<td style='width: 40%'>".$retirados->tamano_descripcion."</td>";
						$str.="</tr>";
						$i++;
					}
				$str.="</tbody>";
		$str.="</table>";
	}
	else if($consulta == "MAYOR A 1.5 AÑOS")
	{
		$tamano = $_REQUEST['tamano'];

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
              AND m.tamano = $tamano
			  AND (DATEDIFF('$fecha_hoy', m2.fecha_activacion_o_baja) ) > (547.88)
			  order by m.no_zanco desc";
		//echo $consulta;		
		$zancos_mayores = Zancos_movimientos::getAllByQuery($consulta);

		

		$str.="<table class='table header-fixed jambo_table dataTables_wrapper'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<td style='width: 20%'>#</td>";
						$str.="<td style='width: 40%'>ZANCO</td>";
						$str.="<td style='width: 40%'>TAMAÑO</td>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$i = 1;
					foreach ($zancos_mayores as $mayores) 
					{
						$str.="<tr>";
							$str.="<td style='width: 20%'>".$i."</td>";
							$str.="<td style='width: 40%'>".$mayores->no_zanco."</td>";
							$str.="<td style='width: 40%'>".$mayores->tamano_descripcion."</td>";
						$str.="</tr>";
						$i++;
					}
				$str.="</tbody>";
		$str.="</table>";
	}
	else if($consulta == "STOCK")
	{
		$tamano = $_REQUEST['tamano'];

		$consulta = "SELECT zancos_bd.*, zancos_tamanos.tamano AS tamano_descripcion 
					FROM zancos_bd
						INNER JOIN zancos_tamanos ON zancos_bd.tamano = zancos_tamanos.id
					WHERE zancos_bd.no_zanco NOT IN 
						(SELECT no_zanco
                       		FROM zancos_movimientos
                       	)
                    AND zancos_bd.tamano = $tamano;
                    /*AND no_zanco > 0*/";
		$zancos_stock = Zancos_bd::getAllByQuery($consulta);

		$str.="<table class='table header-fixed jambo_table dataTables_wrapper'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<td style='width: 20%'>#</td>";
						$str.="<td style='width: 40%'>ZANCO</td>";
						$str.="<td style='width: 40%'>TAMAÑO</td>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$i = 1;
					foreach ($zancos_stock as $stock) 
					{
						$str.="<tr>";
							$str.="<td style='width: 20%'>".$i."</td>";
							$str.="<td style='width: 40%'>".$stock->no_zanco."</td>";
							$str.="<td style='width: 40%'>".$stock->tamano_descripcion."</td>";
						$str.="</tr>";
						$i++;
					}
				$str.="</tbody>";
		$str.="</table>";
	}
	else if($consulta == "SERVICIO")
	{
		$tamano = $_REQUEST['tamano'];

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
              AND m.fecha_servicio = 0
              AND m.tamano = $tamano
              ORDER BY m.no_zanco";

        $zancos_servicio = Zancos_bd::getAllByQuery($consulta);

		$str.="<table class='table header-fixed jambo_table dataTables_wrapper'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<td style='width: 20%'>#</td>";
						$str.="<td style='width: 40%'>ZANCO</td>";
						$str.="<td style='width: 40%'>TAMAÑO</td>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$i = 1;
					foreach ($zancos_servicio as $servicio) 
					{
						$str.="<tr>";
							$str.="<td style='width: 20%'>".$i."</td>";
							$str.="<td style='width: 40%'>".$servicio->no_zanco."</td>";
							$str.="<td style='width: 40%'>".$servicio->tamano_descripcion."</td>";
						$str.="</tr>";
						$i++;
					}
				$str.="</tbody>";
		$str.="</table>";
	}
	else if($consulta == "DESFASE")
	{
		$tamano = $_REQUEST['tamano'];

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
			  AND m.tamano = $tamano
			  AND (DATEDIFF('$fecha_hoy', m.fecha_salida) ) > (m.tiempo_limite * 7)
			  ORDER BY m.no_zanco";

	$zancos_desfase = Zancos_bd::getAllByQuery($consulta);

		$str.="<table class='table header-fixed jambo_table dataTables_wrapper'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<td style='width: 10%'>#</td>";
						$str.="<td style='width: 10%'>ZANCO</td>";
						$str.="<td style='width: 40%'>TAMAÑO</td>";
						$str.="<td style='width: 20%'>ZONA</td>";
						$str.="<td style='width: 20%'>GH</td>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$i = 1;
					foreach ($zancos_desfase as $desfase) 
					{
						$str.="<tr>";
							$str.="<td style='width: 10%'>".$i."</td>";
							$str.="<td style='width: 10%'>".$desfase->no_zanco."</td>";
							$str.="<td style='width: 40%'>".$desfase->tamano_descripcion."</td>";
							$str.="<td style='width: 20%'>".$desfase->zona."</td>";
							$str.="<td style='width: 20%'>".$desfase->gh."</td>";
						$str.="</tr>";
						$i++;
					}
				$str.="</tbody>";
		$str.="</table>";
	}
	else if($consulta == "CAMPO")
	{
		$tamano = $_REQUEST['tamano'];

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
			  AND m.tamano = $tamano
			  ORDER BY m.no_zanco";

		$zancos_campo = Zancos_bd::getAllByQuery($consulta);


		$str.="<table class='table header-fixed jambo_table dataTables_wrapper'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<td style='width: 10%'>#</td>";
						$str.="<td style='width: 10%'>ZANCO</td>";
						$str.="<td style='width: 40%'>TAMAÑO</td>";
						$str.="<td style='width: 20%'>ZONA</td>";
						$str.="<td style='width: 20%'>GH</td>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$i = 1;
					foreach ($zancos_campo as $campo) 
					{
						$str.="<tr>";
							$str.="<td style='width: 10%'>".$i."</td>";
							$str.="<td style='width: 10%'>".$campo->no_zanco."</td>";
							$str.="<td style='width: 40%'>".$campo->tamano_descripcion."</td>";
							$str.="<td style='width: 20%'>".$campo->zona."</td>";
							$str.="<td style='width: 20%'>".$campo->gh."</td>";
						$str.="</tr>";
						$i++;
					}
				$str.="</tbody>";
		$str.="</table>";
	}
	else if($consulta == "DISPONIBLES")
	{
		$tamano = $_REQUEST['tamano'];

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
			  AND m.tamano = $tamano
			  AND (m.tipo_movimiento = 1
			  		OR (m.tipo_movimiento = 3
			  			AND m.fecha_servicio <> 0) )
			  	ORDER BY m.tamano";
		
		$zancos_activo = Zancos_bd::getAllByQuery($consulta);


		$str.="<table class='table header-fixed jambo_table dataTables_wrapper'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<td style='width: 20%'>#</td>";
						$str.="<td style='width: 40%'>ZANCO</td>";
						$str.="<td style='width: 40%'>TAMAÑO</td>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$i = 1;
					foreach ($zancos_activo as $disponible) 
					{
						$str.="<tr>";
							$str.="<td style='width: 20%'>".$i."</td>";
							$str.="<td style='width: 40%'>".$disponible->no_zanco."</td>";
							$str.="<td style='width: 40%'>".$disponible->tamano_descripcion."</td>";
						$str.="</tr>";
						$i++;
					}
				$str.="</tbody>";
		$str.="</table>";
	}

	

	
}

else
{
	echo "NO REQUEST";
}


echo $str;


?>
<style type="text/css"></style>