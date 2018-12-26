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
	$lider = $_GET['lider'];
	$semanaActual = "0";
	$inicio = "";
	$fin = "";
	

	$min_calendario = Disponibilidad_calendarios::getMinDiaByAnoSemana($semana, $ano);    
    $max_calendario = Disponibilidad_calendarios::getMaxDiaByAnoSemana($semana, $ano);
    $inicio = $min_calendario[0]->dia;
   	$fin = $max_calendario[0]->dia;
	

	$parametro = $_GET['parametro'];
 	$departamento = "";
 	$nombreResponsable = "";
	
	if($parametro == "ANALISIS")
	{
		if($lider == 41185)
		{
			$departamento = "MECANICO Y SOLDADURA";
			$nombreResponsable = "ORFANEL RENDON RAMIREZ";
		}

		if($lider == 239)
		{
			$departamento = "HIDROELECTRICO";
			$nombreResponsable = "ORFANEL RENDON RAMIREZ";
		}

		$consulta = "SELECT disponibilidad_data.*, disponibilidad_activos.activo, disponibilidad_activos.zona_segregacion
						 FROM disponibilidad_data
						 INNER JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo
						WHERE disponibilidad_data.fecha_finalizacion_programada 
						BETWEEN '$inicio' 
							AND '$fin'
							AND disponibilidad_data.responsable = $lider
							AND disponibilidad_data.tipo <> 'Mant. preventivo'
							AND (disponibilidad_data.estado = 'Ejecutado'
								OR disponibilidad_data.estado = 'Terminado')
						ORDER BY disponibilidad_data.ot DESC";

						//echo $consulta."<br>";

		$ordenes = Disponibilidad_data::getAllByQuery($consulta);

		//print_r($segregaciones);
		
		$str.="<div class='col-md-12 table-responsive'>";
			
			$str.="<table class='table-condensed table-bordered table-hover dataTables_wrapper jambo_table bulk_action' style='width:100%; font-size:11px;'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<th>ZONAS</th> <th>DOMINGO</th>  <th>LUNES</th> <th>MARTES</th> <th>MIERCOLES</th> <th>JUEVES</th> <th>VIERNES</th> <th>SABADO</th> <th>TOTAL</th>";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$dias = ["DOMINGO", "LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO"];
					//$nombreDiaHoy = $dias[date('w', strtotime($diaHoy))];

					$sumaZonaNorte = 0;
					$sumaZonaSur = 0;
					$sumatotal = 0;
					foreach ($zonas_norte as $norte) 
					{
						$dom = 0;
						$lun = 0;
						$mar = 0;
						$mie = 0;
						$jue = 0;
						$vie = 0;
						$sab = 0;

						foreach ($ordenes as $ot) 
						{

							if($norte == $ot->zona_segregacion)
							{
								$diaCompara = $dias[date('w', strtotime($ot->fecha_finalizacion_programada))];

								if($norte == "AREAS COMUNES" && $ot->horas_estimadas > 0)
								{	
									
									if($diaCompara == "DOMINGO")
									{
										$dom = $dom + ($ot->horas_estimadas / 2 );
									}
									if($diaCompara == "LUNES")
									{
										$lun = $lun + ($ot->horas_estimadas / 2 );
									}
									if($diaCompara == "MARTES")
									{
										$mar = $mar + ($ot->horas_estimadas / 2 );
									}
									if($diaCompara == "MIERCOLES")
									{
										$mie = $mie + ($ot->horas_estimadas / 2 );
									}
									if($diaCompara == "JUEVES")
									{
										$jue = $jue + ($ot->horas_estimadas / 2 );
									}
									if($diaCompara == "VIERNES")
									{
										$vie = $vie + ($ot->horas_estimadas / 2 );
									}
									if($diaCompara == "SABADO")
									{
										$sab = $sab + ($ot->horas_estimadas / 2 );
									}
								}
								else
								{
									if($diaCompara == "DOMINGO")
									{
										$dom = $dom + $ot->horas_estimadas;
									}
									if($diaCompara == "LUNES")
									{
										$lun = $lun + $ot->horas_estimadas;
									}
									if($diaCompara == "MARTES")
									{
										$mar = $mar + $ot->horas_estimadas;
									}
									if($diaCompara == "MIERCOLES")
									{
										$mie = $mie + $ot->horas_estimadas;
									}
									if($diaCompara == "JUEVES")
									{
										$jue = $jue + $ot->horas_estimadas;
									}
									if($diaCompara == "VIERNES")
									{
										$vie = $vie + $ot->horas_estimadas;
									}
									if($diaCompara == "SABADO")
									{
										$sab = $sab + $ot->horas_estimadas;
									}
								}
								
							}
						}
						$subtotalZona = $dom + $lun + $mar + $mie + $jue + $vie + $sab;
						$sumaZonaNorte = $sumaZonaNorte + $subtotalZona;
						$str.="<tr>";
							$str.="<td>".$norte."</td> <td>".$dom."</td> <td>".$lun."</td> <td>".$mar."</td> <td>".$mie."</td> <td>".$jue."</td> <td>".$vie."</td> <td>".$sab."</td> <td>".$subtotalZona."</td>";
						$str.="</tr>";
					}
					$str.="<tr style='background-color:#DDF1D7;'>";
							$str.="<td colspan='8' class='text-right'><b>SUMA ZONA NORTE</b></td>  <td><b>".$sumaZonaNorte."</b></td>";
					$str.="</tr>";
					foreach ($zonas_sur as $sur) 
					{
						$dom = 0;
						$lun = 0;
						$mar = 0;
						$mie = 0;
						$jue = 0;
						$vie = 0;
						$sab = 0;

						foreach ($ordenes as $ot) 
						{
							if($sur == $ot->zona_segregacion)
							{
								//echo $sur."<br>";
								$diaCompara = $dias[date('w', strtotime($ot->fecha_finalizacion_programada))];
								if($sur == "AREAS COMUNES" && $ot->horas_estimadas > 0)
								{
									//echo "entro";
									if($diaCompara == "DOMINGO")
									{
										$dom = $dom + ($ot->horas_estimadas / 2 );
									}
									if($diaCompara == "LUNES")
									{
										$lun = $lun + ($ot->horas_estimadas / 2 );
									}
									if($diaCompara == "MARTES")
									{
										$mar = $mar + ($ot->horas_estimadas / 2 );
									}
									if($diaCompara == "MIERCOLES")
									{
										$mie = $mie + ($ot->horas_estimadas / 2 );
									}
									if($diaCompara == "JUEVES")
									{
										$jue = $jue + ($ot->horas_estimadas / 2 );
									}
									if($diaCompara == "VIERNES")
									{
										$vie = $vie + ($ot->horas_estimadas / 2 );
									}
									if($diaCompara == "SABADO")
									{
										$sab = $sab + ($ot->horas_estimadas / 2 );
									}
								}
								else
								{
									if($diaCompara == "DOMINGO")
									{
										$dom = $dom + $ot->horas_estimadas;
									}
									if($diaCompara == "LUNES")
									{
										$lun = $lun + $ot->horas_estimadas;
									}
									if($diaCompara == "MARTES")
									{
										$mar = $mar + $ot->horas_estimadas;
									}
									if($diaCompara == "MIERCOLES")
									{
										$mie = $mie + $ot->horas_estimadas;
									}
									if($diaCompara == "JUEVES")
									{
										$jue = $jue + $ot->horas_estimadas;
									}
									if($diaCompara == "VIERNES")
									{
										$vie = $vie + $ot->horas_estimadas;
									}
									if($diaCompara == "SABADO")
									{
										$sab = $sab + $ot->horas_estimadas;
									}
								}
							}
						}
						$subtotalZona = $dom + $lun + $mar + $mie + $jue + $vie + $sab;
						$sumaZonaSur = $sumaZonaSur + $subtotalZona;
						$str.="<tr >";
							$str.="<td>".$sur."</td> <td>".$dom."</td> <td>".$lun."</td> <td>".$mar."</td> <td>".$mie."</td> <td>".$jue."</td> <td>".$vie."</td> <td>".$sab."</td> <td>".$subtotalZona."</td>";
						$str.="</tr>";
					}
					$str.="<tr style='background-color:#DDF1D7;'>";
							$str.="<td colspan='8' class='text-right'><b>SUMA ZONA SUR</b></td>  <td><b>".$sumaZonaSur."</b></td>";
					$str.="</tr>";

					$sumatotal = $sumaZonaNorte + $sumaZonaSur;
					$str.="<tr style='background-color:#DDF1D7;'>";
							$str.="<td colspan='8' class='text-right'><b>SUMA ZONAS</b></td>  <td><b>".$sumatotal."</b></td>";
					$str.="</tr>";
				$str.="</tbody>";
			$str.="</table>";
		$str.="</div>";

		$str.="<div class='col-md-12'"; 
			$str.="<form class='form-horizontal'>";
				$str.="<br><div class='form-group'>
							<div class='col-md-6'>
						    	<label >Departamento</label>
						      	<input type='text' class='form-control' id='departamento' name='departamento' value='".$departamento."' readonly>
						    </div>
						    <div class='col-md-3'>
						    	<label class='col-sm-2 control-label'>Semana</label>
						      	<input type='number' class='form-control input-sm' id='departamento' name='semana' value='".$semana."' readonly>
						    </div>
						    <div class='col-md-3'>
						    	<label>Fecha</label>
						      	<input type='date' class='form-control input-sm' id='fecha' name='fecha' required>
						    </div>
						</div>";
						$str.="<br><br><div class='form-group'>
						    
						</div>";
				$str.="<br><div class='form-group'>
							<div class='col-md-6'>
						    	<label>Valida</label>
						      	<input type='text' class='form-control input-sm' id='Valida' name='Valida' value='".$nombreResponsable."' readonly>
						    </div>
						    <div class='col-md-6'>
						    	<label >Captura</label>
						      	<input type='text' class='form-control input-sm' id='captura' name='captura' value='' required>
						    </div>
						</div>";
				$str.=" <div class='text-center'>
							<br><br><br>
							<input type='text' class='form-control input-sm hidden' id='lider' name='lider' value='".$lider."' readonly>
							<input type='text' class='form-control input-sm hidden' id='ano' name='ano' value='".$ano."' readonly>
							<button class='btn btn-primary btn-sm external_pdf' type='submit'>Imprimir</button>
						</div>";
			$str.="</form>";
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
   		$(".external_pdf").click(function() 
   		{
   			var departamento = $("#departamento").val();
   			var semana = $("#semana").val();
   			var fecha = $("#fecha").val();
   			var captura = $("#captura").val();
   			var lider = $("#lider").val();
   			var ano = $("#ano").val();
   			var parametro = "SEGREGACION";

   			if(captura && fecha != "")
   			{
   				url = "helperExport.php?departamento="+departamento+"&semana="+semana+"&fecha="+fecha+"&captura="+captura+"&lider="+lider+"&ano="+ano+"&parametro="+parametro;
      			window.open(url, '_blank');
   			}
   			else
   			{
   				alert("Capture los campos de -Fecha-  y -Captura-");
   			}
      		
      		return false;
   		});
	});
</script>