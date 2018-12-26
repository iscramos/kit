<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_GET['parametro']) && ($_SESSION["type"]==1 || $_SESSION["type"]==6 || $_SESSION["type"]==7)) // para el admimistrador
{	
	//$mes = $_GET['mes'];
	$ano = $_GET['ano'];
	$semana = $_GET['semana'];
	$semanaActual = "0";
	$inicio = "";
	$fin = "";
	

	$min_calendario = Disponibilidad_calendarios::getMinDiaByAnoSemana($semana, $ano);    
    $max_calendario = Disponibilidad_calendarios::getMaxDiaByAnoSemana($semana, $ano);
    $inicio = $min_calendario[0]->dia;
   	$fin = $max_calendario[0]->dia;
	

	function getMinutes($fecha1, $fecha2)
	{
	    $fecha1 = str_replace('/', '-', $fecha1);
	    $fecha2 = str_replace('/', '-', $fecha2);
	    $fecha1 = strtotime($fecha1);
	    $fecha2 = strtotime($fecha2);
	    return round( (($fecha2 - $fecha1) / 60) / 60, 1); //convirtiendo a horas
	} 

	
	

	$parametro = $_GET['parametro'];
 
	
	if($parametro == "ANALISIS")
	{
		$consulta = "SELECT count(*) AS fallas, disponibilidad_data.clase
					FROM disponibilidad_data
					WHERE fecha_finalizacion_programada 
						BETWEEN '$inicio' 
							AND '$fin'
						AND tipo != 'Mant. preventivo'
						GROUP BY clase 
						ORDER BY fallas DESC LIMIT 10";

						//echo $consulta."<br>";

		$topClases = Disponibilidad_data::getAllByQuery($consulta);

		//print_r($topClases);

		$str.="<div class='col-md-2 table-responsive'>";
			$str.="CLASES";
			$str.="<table class='table-condensed table-bordered table-striped table-hover dataTables-example dataTables_wrapper jambo_table bulk_action' style='font-size:11px;'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<th>#</th> <th>CLASE</th>  <th>FALLAS</th>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$x = 1;
					foreach ($topClases as $topC) 
					{

						$str.="<tr  >";
							$str.="<td>".$x."</td> <td>".$topC->clase."</td> <td style='text-align:right;'>".$topC->fallas."</td>";
						$str.="</tr>";

						$x++;
					}
				$str.="</tbody>";
			$str.="</table>";
		$str.="</div>";


		$consulta = "SELECT count(*) AS fallas, disponibilidad_data.equipo, disponibilidad_activos.descripcion as descripcion_equipo
					FROM disponibilidad_data
					LEFT JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo 
					WHERE disponibilidad_data.fecha_finalizacion_programada 
						BETWEEN '$inicio' 
							AND '$fin'
						AND disponibilidad_data.tipo != 'Mant. preventivo'
						GROUP BY disponibilidad_data.equipo 
						ORDER BY fallas DESC LIMIT 10";

						//echo $consulta."<br>";

		$topEquipos = Disponibilidad_data::getAllByQuery($consulta);

		$str.="<div class='col-md-5 table-responsive'>";
			$str.="TODOS LOS ACTIVOS";
			$str.="<table class='table-condensed table-bordered table-striped table-hover dataTables-example dataTables_wrapper jambo_table bulk_action' style='font-size:11px;'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<th>#</th> <th>EQUIPO</th> <th>DESCRIPCION</th> <th>FALLAS</th>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$y = 1;
					foreach ($topEquipos as $topE) 
					{

						$str.="<tr >";
							$str.="<td>".$y."</td> <td>".$topE->equipo."</td> <td>".$topE->descripcion_equipo."</td> <td style='text-align:right;'>".$topE->fallas."</td>";
						$str.="</tr>";

						$y++;
					}
				$str.="</tbody>";
			$str.="</table>";
		$str.="</div>";


		$consulta = "SELECT count(*) AS fallas, disponibilidad_data.equipo, disponibilidad_activos.descripcion as descripcion_equipo
					FROM disponibilidad_data
					LEFT JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo
					WHERE disponibilidad_data.fecha_finalizacion_programada 
						BETWEEN '$inicio' 
							AND '$fin'
						AND disponibilidad_data.tipo != 'Mant. preventivo'
						AND disponibilidad_activos.criticidad = 'Alta'
						GROUP BY disponibilidad_data.equipo 
						ORDER BY fallas DESC LIMIT 10";

						//echo $consulta."<br>";

		$topEquiposCriticos = Disponibilidad_data::getAllByQuery($consulta);

		$str.="<div class='col-md-5 table-responsive'>";
			$str.="ACTIVOS CRITICOS";
			$str.="<table class='table-condensed table-bordered table-striped table-hover dataTables-example dataTables_wrapper jambo_table bulk_action' style='font-size:11px;'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<th>#</th> <th>EQUIPO</th> <th>DESCRIPCION</th> <th>FALLAS</th>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$z = 1;
					foreach ($topEquiposCriticos as $topCriticos) 
					{
						$str.="<tr >";
							$str.="<td>".$z."</td> <td>".$topCriticos->equipo."</td> <td>".$topCriticos->descripcion_equipo."</td> <td style='text-align:right;'>".$topCriticos->fallas."</td>";
						$str.="</tr>";

						$z++;
					}
				$str.="</tbody>";
			$str.="</table>";
		$str.="</div>";

		$consulta = "SELECT SUM(unix_timestamp(disponibilidad_data.fecha_finalizacion) - unix_timestamp(disponibilidad_data.fecha_inicio)) AS horas, disponibilidad_data.equipo, disponibilidad_activos.descripcion as descripcion_equipo
					FROM disponibilidad_data
					LEFT JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo
					WHERE disponibilidad_data.fecha_finalizacion_programada 
						BETWEEN '$inicio' 
							AND '$fin'
						AND disponibilidad_data.tipo != 'Mant. preventivo'
						AND disponibilidad_activos.criticidad = 'Alta'
						AND (disponibilidad_data.estado = 'Terminado' OR disponibilidad_data.estado = 'Ejecutado')
						GROUP BY disponibilidad_data.equipo 
						ORDER BY horas DESC LIMIT 10";

						//echo $consulta."<br>";

		$topEquiposCriticos_tiempo = Disponibilidad_data::getAllByQuery($consulta);

		$str.="<div class='col-md-7 table-responsive'>";
			$str.="<br>ACTIVOS CRITICOS + TIEMPO DE PARADA";
			$str.="<table class='table-condensed table-bordered table-striped table-hover dataTables-example dataTables_wrapper jambo_table bulk_action' style='font-size:11px;'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<th>#</th> <th>EQUIPO</th> <th>DESCRIPCION</th> <th>T. DE PARADA (HRS)</th>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$z = 1;
					foreach ($topEquiposCriticos_tiempo as $topCriticos_tiempo) 
					{
						$en_horas = 0;
						$en_horas = $topCriticos_tiempo->horas / 3600; // para la conversion a horas

						$str.="<tr >";
							$str.="<td>".$z."</td> <td>".$topCriticos_tiempo->equipo."</td> <td>".$topCriticos_tiempo->descripcion_equipo."</td> <td style='text-align:right;'>".$en_horas."</td>";
						$str.="</tr>";

						$z++;
					}
				$str.="</tbody>";
			$str.="</table>";
		$str.="</div>";

		/* TERMINA TABLA DE ANALISIS GENERAL*/
	}
}
else
{
	$str.="NO DATA";
}


echo $str;


?>


<script type="text/javascript">
	$(document).ready(function() 
	{
		
	});
</script>
