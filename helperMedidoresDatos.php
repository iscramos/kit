<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_GET['parametro']) && ($_SESSION["type"]==1 || $_SESSION["type"]==7 || $_SESSION["type"]==10)) // para el admimistrador
{	
	//$mes = $_GET['mes'];
	$ano = $_GET['ano'];
	$semana = $_GET['semana'];
	
	$inicio = "";
	$fin = "";
	

	$min_calendario = Disponibilidad_calendarios::getMinDiaByAnoSemana($semana, $ano);    
    $max_calendario = Disponibilidad_calendarios::getMaxDiaByAnoSemana($semana, $ano);

    $consulta = "SELECT * FROM disponibilidad_activos WHERE activo LIKE 'CO-BMU%'
											OR activo LIKE 'CO-COM%'
											OR activo LIKE 'CO-POZ%'
											AND organizacion = 'COL' ORDER BY activo ASC";
	$equipos = Disponibilidad_activos::getAllByQuery($consulta);

    $inicio = $min_calendario[0]->dia;
   	$fin = $max_calendario[0]->dia;
	

	$parametro = $_GET['parametro'];
 	
	
	if($parametro == "SISPA")
	{
		

		$consulta = "SELECT * 
						FROM bd_rebombeo 
							WHERE tipo = 3
								AND ( DATE(fechaLectura) BETWEEN '".$inicio."' AND '".$fin."')";

						//echo $consulta."<br>";

		$mediciones = Disponibilidad_data::getAllByQuery($consulta);

		//print_r($mediciones);
		
		$str.="<div class='col-md-12 table-responsive'>";
			
			$str.="<table class='table-condensed table-bordered table-hover dataTables_wrapper jambo_table bulk_action' style='width:100%; font-size:11px;'>";
				$str.="<thead>";
					$str.="<tr>";
						$str.="<th>UBICACION</th> <th>MEDIDOR</th> <th>DOMINGO</th>  <th>LUNES</th> <th>MARTES</th> <th>MIERCOLES</th> <th>JUEVES</th> <th>VIERNES</th> <th>SABADO</th> ";
					$str.="</tr>";
				$str.="</thead>";
				$str.="<tbody>";

					$dias = ["DOMINGO", "LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO"];
					//$nombreDiaHoy = $dias[date('w', strtotime($diaHoy))];

					$sumaZonaNorte = 0;
					$sumaZonaSur = 0;
					$sumatotal = 0;
					foreach ($equipos as $equipo) 
					{
						$dom = 0;
						$lun = 0;
						$mar = 0;
						$mie = 0;
						$jue = 0;
						$vie = 0;
						$sab = 0;

						foreach ($mediciones as $medicion) 
						{
							if($equipo->activo == $medicion->equipo)
							{	
								$diaCompara = $dias[date('w', strtotime($medicion->fechaLectura))];
								$potencia = 1;

								/*if($medicion->equipo != "CO-BMU-009")
								{
									$potencia = 10;
								}*/
								//echo $diaCompara;
								
								if($diaCompara == "DOMINGO")
								{
									$dom = $dom + ($medicion->m_consumidos * $potencia );
								}
								if($diaCompara == "LUNES")
								{
									$lun = $lun + ($medicion->m_consumidos * $potencia );
								}
								if($diaCompara == "MARTES")
								{
									$mar = $mar + ($medicion->m_consumidos * $potencia );
								}
								if($diaCompara == "MIERCOLES")
								{
									$mie = $mie + ($medicion->m_consumidos * $potencia );
								}
								if($diaCompara == "JUEVES")
								{
									$jue = $jue + ($medicion->m_consumidos * $potencia );
								}
								if($diaCompara == "VIERNES")
								{
									$vie = $vie + ($medicion->m_consumidos * $potencia );
								}
								if($diaCompara == "SABADO")
								{
									$sab = $sab + ($medicion->m_consumidos * $potencia );
								}
							}
							
						}
						
						$str.="<tr>";
							$str.="<td>".$equipo->descripcion."</td> <td>".$equipo->medidor."</td> <td>".$dom."</td> <td>".$lun."</td> <td>".$mar."</td> <td>".$mie."</td> <td>".$jue."</td> <td>".$vie."</td> <td>".$sab."</td>";
						$str.="</tr>";
					}
					
					
					
				$str.="</tbody>";
			$str.="</table>";
		$str.="</div>";

		$str.="<div class='col-md-12'>"; 
			
			$str.="<form class='form-horizontal'>";
				$str.="<br><div class='form-group'>
						<p style='text-align:center;'> - - - - COMPLEMENTAR DATOS - - - - </p>
						    <div class='col-md-3'>
						    	<label>Semana</label>
						      	<input type='number' class='form-control input-sm' id='semana' name='semana' value='".$semana."' readonly>
						    </div>
						    <div class='col-md-3'>
                                <label >Fecha</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' name='fecha' id='fecha' class='form-control input-sm' value='' autocomplete='off' required>
                                    <span class='input-group-addon'>
                                        <span class='glyphicon glyphicon-calendar'></span>
                                    </span>
                                </div>
                            </div>
						    <div class='col-md-3'>
						    	<label>Realizó</label>
						      	<input type='text' class='form-control input-sm' id='realizo' name='realizo' value='' required>
						    </div>
						    <div class='col-md-3'>
						    	<label >Supervisor</label>
						      	<input type='text' class='form-control input-sm' id='supervisor' name='supervisor' value='' required>
						    </div>
						</div>";
				$str.="<div class='form-group'>
							<div class='col-md-12'>
						    	<label>Observaciones</label>
						    	<textarea class='form-control' rows='3' id='observacion' name='observacion'></textarea>
						    </div>
						</div>";
				$str.=" <div class='text-center'>
							<br>
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
   			var semana = $("#semana").val();
   			var fecha = $("#fecha").val();
   			var realizo = $("#realizo").val();
   			var supervisor = $("#supervisor").val();
   			var ano = $("#ano").val();
   			var observacion = $("#observacion").val();
   			var parametro = "SISPA";

   			if(realizo && supervisor && fecha != "")
   			{
   				url = "helperExport.php?semana="+semana+"&fecha="+fecha+"&realizo="+realizo+"&supervisor="+supervisor+"&ano="+ano+"&observacion="+observacion+"&parametro="+parametro;
      			window.open(url, '_blank');
   			}
   			else
   			{
   				alert("Capture los campos de -Fecha-, -Realizó-, -Supervisor-");
   			}
      		
      		return false;
   		});

   		$(function () 
        {
            $('#datetimepicker1').datetimepicker({
                format: 'YYYY-MM-DD',
                pickTime: false,
                autoclose: true,

            });
        });


	});
</script>