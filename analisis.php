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
	

	$fechas = Calendario_nature::getAllSemana($semana);
	$inicio = $ano."-".$fechas[0]->fecha_inicio;
	$fin = $ano."-".$fechas[0]->fecha_fin;
	
	/*echo "Fecha inicio: ".$inicio;
	echo "<br>Fecha fin: ".$fin;*/

	//$countPreventivos = Ordenesots::getAllMpByMesAnoCuentaPreventivo($mes, $ano);
	//$countCorrectivos = Ordenesots::getAllMpByMesAnoCuentaCorrectivo($mes, $ano);

	/*$str.="<input type='number' class='hidden' value='".$countPreventivos[0]->nPreventivos."' id='nPreventivos' >";
	$str.="<input type='number' class='hidden' value='".$countCorrectivos[0]->nCorrectivos."' id='nCorrectivos' >";*/

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
		/* 	MIS VARIABLES GENERALES */

		$consulta = "SELECT count(*) AS fallas, ordenesots.clase
					FROM ordenesots
					WHERE fecha_finalizacion_programada 
						BETWEEN '$inicio' 
							AND '$fin'
						AND tipo != 'Mant. preventivo'
						GROUP BY clase 
						ORDER BY fallas DESC LIMIT 10";

						//echo $consulta."<br>";

		$topClases = Ordenesots::getAllConsulta($consulta);

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
							$str.="<td>".$x."</td> <td>".$topC->clase."</td> <td>".$topC->fallas."</td>";
						$str.="</tr>";

						$x++;
					}
				$str.="</tbody>";
			$str.="</table>";
		$str.="</div>";


		$consulta = "SELECT count(*) AS fallas, ordenesots.equipo, activos_eam.descripcion as descripcion_equipo
					FROM ordenesots
					LEFT JOIN activos_eam ON ordenesots.equipo = activos_eam.activo 
					WHERE ordenesots.fecha_finalizacion_programada 
						BETWEEN '$inicio' 
							AND '$fin'
						AND ordenesots.tipo != 'Mant. preventivo'
						GROUP BY ordenesots.equipo 
						ORDER BY fallas DESC LIMIT 10";

						//echo $consulta."<br>";

		$topEquipos = Ordenesots::getAllConsulta($consulta);

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
							$str.="<td>".$y."</td> <td>".$topE->equipo."</td> <td>".$topE->descripcion_equipo."</td> <td>".$topE->fallas."</td>";
						$str.="</tr>";

						$y++;
					}
				$str.="</tbody>";
			$str.="</table>";
		$str.="</div>";


		$consulta = "SELECT count(*) AS fallas, ordenesots.equipo, activos_eam.descripcion as descripcion_equipo
					FROM ordenesots
					LEFT JOIN activos_eam ON ordenesots.equipo = activos_eam.activo 
					INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
					WHERE ordenesots.fecha_finalizacion_programada 
						BETWEEN '$inicio' 
							AND '$fin'
						AND ordenesots.tipo != 'Mant. preventivo'
						GROUP BY ordenesots.equipo 
						ORDER BY fallas DESC LIMIT 10";

						//echo $consulta."<br>";

		$topEquiposCriticos = Ordenesots::getAllConsulta($consulta);

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
							$str.="<td>".$z."</td> <td>".$topCriticos->equipo."</td> <td>".$topCriticos->descripcion_equipo."</td> <td>".$topCriticos->fallas."</td>";
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
