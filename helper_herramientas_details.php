<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_REQUEST['consulta']) && ($_SESSION["type"] == 5 || $_SESSION["type"] == 10 ) ) // para herramientas
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
		$categoria = $_REQUEST['categoria'];

		$consulta = "SELECT id_categoria, clave, descripcion 
					FROM herramientas_herramientas
						WHERE retirado = 1
							AND activaStock = 0
							AND id_categoria = $categoria";
		
		$herramientas_retirados = Herramientas_herramientas::getAllByQuery($consulta);

		

		$str.="<table class='table header-fixed jambo_table dataTables_wrapper'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<td style='width: 10%'>#</td>";
						$str.="<td style='width: 20%'>CLAVE</td>";
						$str.="<td style='width: 70%'>DESCRIPCION</td>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$i = 1;
					foreach ($herramientas_retirados as $retirados) 
					{
						$str.="<tr>";
							$str.="<td style='width: 10%'>".$i."</td>";
							$str.="<td style='width: 20%'>".$retirados->clave."</td>";
							$str.="<td style='width: 70%'>".$retirados->descripcion."</td>";
						$str.="</tr>";
						$i++;
					}
				$str.="</tbody>";
		$str.="</table>";
	}
	else if($consulta == "MAYOR A 1.5 AÑOS")
	{
		$categoria = $_REQUEST['categoria'];

		$consulta = "SELECT id_categoria, clave, descripcion 
					FROM herramientas_herramientas
						WHERE retirado <> 1
							AND activaStock = 0
							AND (DATEDIFF('$fecha_hoy', fecha_entrada) ) > (547.88)
							AND id_categoria = $categoria";
		//echo $consulta;		
		$herramientas_mayores = Herramientas_herramientas::getAllByQuery($consulta);

		

		$str.="<table class='table header-fixed jambo_table dataTables_wrapper'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<td style='width: 10%'>#</td>";
						$str.="<td style='width: 20%'>CLAVE</td>";
						$str.="<td style='width: 70%'>DESCRIPCION</td>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$i = 1;
					foreach ($herramientas_mayores as $mayores) 
					{
						$str.="<tr>";
							$str.="<td style='width: 10%'>".$i."</td>";
							$str.="<td style='width: 20%'>".$mayores->clave."</td>";
							$str.="<td style='width: 70%'>".$mayores->descripcion."</td>";
						$str.="</tr>";
						$i++;
					}
				$str.="</tbody>";
		$str.="</table>";
	}
	else if($consulta == "SERVICIO")
	{
		$categoria = $_REQUEST['categoria'];

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
				    	AND m.fecha_servicio = 0
				    	AND h.id_categoria = $categoria";
	//echo $consulta;
	$herramientas_servicio = Herramientas_movimientos::getAllByQuery($consulta);

		$str.="<table class='table header-fixed jambo_table dataTables_wrapper'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<td style='width: 10%'>#</td>";
						$str.="<td style='width: 20%'>CLAVE</td>";
						$str.="<td style='width: 70%'>DESCRIPCION</td>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$i = 1;
					foreach ($herramientas_servicio as $servicio) 
					{
						$str.="<tr>";
							$str.="<td style='width: 10%'>".$i."</td>";
							$str.="<td style='width: 20%'>".$servicio->clave."</td>";
							$str.="<td style='width: 70%'>".$servicio->descripcion."</td>";
						$str.="</tr>";
						$i++;
					}
				$str.="</tbody>";
		$str.="</table>";
	}
	else if($consulta == "CAMPO")
	{
		$categoria = $_REQUEST['categoria'];

		$consulta = "SELECT h.*,
					   m.id_registro,
				       m.tipo_movimiento,
				       m.fecha_entrega,
				       m.descripcion_problema,
				       m.zona,
				       m.gh
				  FROM herramientas_herramientas h
				  INNER JOIN herramientas_movimientos m
				    ON m.clave = h.clave
				   	AND m.id_registro = (SELECT max(m2.id_registro)
				                               FROM herramientas_movimientos m2
				                              WHERE m2.clave = m.clave)
				    WHERE m.fecha_entrega = '' 
				    	AND h.id_categoria = $categoria";
	//echo $consulta;
	$herramientas_prestadas = Herramientas_movimientos::getAllByQuery($consulta);
	//print_r($herramientas_prestadas);


		$str.="<table class='table header-fixed jambo_table dataTables_wrapper'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<td style='width: 10%'>#</td>";
						$str.="<td style='width: 20%'>CLAVE</td>";
						$str.="<td style='width: 50%'>DESCRIPCION</td>";
						$str.="<td style='width: 10%'>ZONA</td>";
						$str.="<td style='width: 10%'>GH</td>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$i = 1;
					foreach ($herramientas_prestadas as $campo) 
					{
						$str.="<tr>";
							$str.="<td style='width: 10%'>".$i."</td>";
							$str.="<td style='width: 20%'>".$campo->clave."</td>";
							$str.="<td style='width: 50%'>".$campo->descripcion."</td>";
							$str.="<td style='width: 10%'>".$campo->zona."</td>";
							$str.="<td style='width: 10%'>".$campo->gh."</td>";
						$str.="</tr>";
						$i++;
					}
				$str.="</tbody>";
		$str.="</table>";
	}
	else if($consulta == "DISPONIBLES")
	{
		$categoria = $_REQUEST['categoria'];

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
				    		AND m.descripcion_problema <> 0
				    		AND h.id_categoria = $categoria";
				    

		//echo $consulta;
		$herramientas_disponibles = Herramientas_movimientos::getAllByQuery($consulta);
		//print_r($herramientas_prestadas);



		$consulta = "SELECT * FROM herramientas_herramientas
						WHERE clave NOT IN 
							(SELECT clave
	                       		FROM herramientas_movimientos
	                       	)
	                    AND activaStock = 0
	                    AND id_categoria = $categoria
	                    AND fecha_retirado = 0";
		$herramientas_stock = Herramientas_herramientas::getAllByQuery($consulta);


		$str.="<table class='table header-fixed jambo_table dataTables_wrapper'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<td style='width: 10%'>#</td>";
						$str.="<td style='width: 20%'>CLAVE</td>";
						$str.="<td style='width: 70%'>DESCRIPCION</td>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$i = 1;
					foreach ($herramientas_disponibles as $disponible) 
					{
						$str.="<tr>";
							$str.="<td style='width: 10%'>".$i."</td>";
							$str.="<td style='width: 20%'>".$disponible->clave."</td>";
							$str.="<td style='width: 70%'>".$disponible->descripcion."</td>";
						$str.="</tr>";
						$i++;
					}

					foreach ($herramientas_stock as $solo) 
					{
						$str.="<tr>";
							$str.="<td style='width: 10%'>".$i."</td>";
							$str.="<td style='width: 20%'>".$solo->clave."</td>";
							$str.="<td style='width: 70%'>".$solo->descripcion."</td>";
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