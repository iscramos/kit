<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_GET['parametro']) && ($_SESSION["type"]==1 || $_SESSION["type"]==6 || $_SESSION["type"]==7 || $_SESSION["type"] == 4)) // para el admimistrador
{	
	//$mes = $_GET['mes'];
	$ano = $_GET['ano'];

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

	function nombreMes($mes)
	{
		switch ($mes) 
	    {
	    case 1:
	        $mes = "ENERO";
	        break;
	    case 2:
	        $mes = "FEBRERO";
	        break;
	    case 3:
	        $mes = "MARZO";
	        break;
	    case 4:
	        $mes = "ABRIL";
	        break;
	    case 5:
	        $mes = "MAYO";
	        break;
	    case 6:
	        $mes = "JUNIO";
	        break;
	    case 7:
	        $mes = "JULIO";
	        break;
	    case 8:
	        $mes = "AGOSTO";
	        break;
	    case 9:
	        $mes = "SEPTIEMBRE";
	        break;
	    case 10:
	        $mes = "OCTUBRE";
	        break;
	    case 11:
	        $mes = "NOVIEMBRE";
	        break;
	    case 12:
	        $mes = "DICIEMBRE";
	        break;
	    }

	    return $mes;
	    
	}

	/*function nombreMesIncrementa($mes)
	{
		switch ($mes) 
	    {
	    case 1:
	        $mes = 02;
	        break;
	    case 2:
	        $mes = 03;
	        break;
	    case 3:
	        $mes = 04;
	        break;
	    case 4:
	        $mes = 05;
	        break;
	    case 5:
	        $mes = 06;
	        break;
	    case 6:
	        $mes = 07;
	        break;
	    case 7:
	        $mes = 08;
	        break;
	    case 8:
	        $mes = 09;
	        break;
	    case 9:
	        $mes = 10;
	        break;
	    case 10:
	        $mes = 11;
	        break;
	    case 11:
	        $mes = 12;
	        break;
	    case 12:
	        $mes = 01;
	        break;
	    }

	    return $mes;
	    
	}*/

	/*$weeks = null;
	$weeks = Calendario_nature::getAllMesCount($mes);
	$weeks = $weeks[0]->weeks;*/


	$parametro = $_GET['parametro'];
 
	
	if($parametro == "MPvsMC")
	{
		

		$meses = Calendario_nature::getAllMeses();
		//print_r($meses);
		// Esto es para traernos los pendientes del otro año
		//echo $ano;
		$nPendientesAnoAnteriorMP = 0;
		$pendientesAnoAnteriorMP = 0;

		$nPendientesAnoAnteriorMC = 0;
		$pendientesAnoAnteriorMC = 0;
		$anoAnterior = 0;
		if($ano > 2016)
		{

			$anoAnterior = $ano - 1; 
			$fechaInicioAnoAnterior = $anoAnterior."-01-01";
			$fechaFinalizacionAnoAnterior = $anoAnterior."-12-30";

			$pendientesAnoAnteriorMP = Ordenesots::getAllPendientesMP($fechaInicioAnoAnterior, $fechaFinalizacionAnoAnterior);
			$pendientesAnoAnteriorMC = Ordenesots::getAllPendientesMC($fechaInicioAnoAnterior, $fechaFinalizacionAnoAnterior);
		}

		if($pendientesAnoAnteriorMP != 0 )
		{
			//echo "entro";
			$nPendientesAnoAnteriorMP = $pendientesAnoAnteriorMP[0]->nPendientesMP;
		}
		if($pendientesAnoAnteriorMC != 0 )
		{
			$nPendientesAnoAnteriorMC = $pendientesAnoAnteriorMC[0]->nPendientesMC;
		}
		//echo $nPendientesAnoAnteriorMP. " ".$nPendientesAnoAnteriorMC;
		//$anoAnterior = $programadosMP = Ordenesots::getAllProgramadosMP($fechaInicio, $fechaFinalizacion);
		//$x = 1;
		// PARA LA GRAFICA
			$str.="<h4 style='text-align:center;' >MANTENIMIENTOS</h4>
					<input class='form-control hidden' type='number' id='ano' value='$ano'>
					<a href='indexMp_Mc_lider.php?responsable=41185&ano=$ano' target='_blank' title='Ver cumplimiento por líder' type='button' class='btn btn-default btn-md'> <i class='fa fa-user' aria-hidden='true'></i> Orfanel Rendón</a>
					<a href='indexMp_Mc_lider.php?responsable=239&ano=$ano' target='_blank' title='Ver cumplimiento por líder' type='button' class='btn btn-default btn-md'> <i class='fa fa-user' aria-hidden='true'></i> Humberto Cervantes</a>
					<a href='indexMp_Mc_lider.php?responsable=14993&ano=$ano' target='_blank' title='Ver cumplimiento por líder' type='button' class='btn btn-default btn-md'> <i class='fa fa-user' aria-hidden='true'></i> Miguel Tadeo</a>
					<a href='indexMp_Mc_lider.php?responsable=15113&ano=$ano' target='_blank' title='Ver cumplimiento por líder' type='button' class='btn btn-default btn-md'> <i class='fa fa-user' aria-hidden='true'></i> Antonio Virgen</a>
					 <br>";

	        $str.="<br><div class='row'>";
				$str.="<div class='col-md-12 col-sm-12'>
	                    <div class='panel panel-default'>
	                        <div class='panel-heading'>
	                            MC VS MP ANUAL AL MOMENTO
	                        </div>
	                        <!-- /.panel-heading -->
	                        <div class='panel-body '>
	                             <div width='100%' id='graficaActualizada'></div>
	                        </div>
	                        <!-- /.panel-body -->
	                    </div>
	                    <!-- /.panel -->
	                </div>";
	        $str.="</div>";

	        $str.="<div class='row'>";
				$str.="<div class='col-md-12 col-sm-12'>
	                    <div class='panel panel-default'>
	                        <div class='panel-heading'>
	                            MC VS MP ANUAL HISTÓRICO
	                        </div>
	                        <!-- /.panel-heading -->
	                        <div class='panel-body '>
	                             <div width='100%' id='graficaHistorica'></div>
	                        </div>
	                        <!-- /.panel-body -->
	                    </div>
	                    <!-- /.panel -->
	                </div>";
	        $str.="</div>";

	       

			$acumuladoMP = $nPendientesAnoAnteriorMP;
			$acumuladoMC = $nPendientesAnoAnteriorMC;
			$sumaMP = 0;
			$sumaMC = 0;
			$str.="<div class='alert alert-success' role='alert' id='mensaje'>
                                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                  <strong>Nota!</strong> Iniciamos año con un total de pendientes MP = $acumuladoMP y MC = $acumuladoMC acumulados del año anterior.
         
                                </div>";

		foreach ($meses as $mes) 
		{
			$nombre = nombreMes(intval($mes->mes) );
			$mes = $mes->mes;

			


			$str.="<h4 class='text-center'>".$nombre."</h4>";

			$semanas = Calendario_nature::getAllSemanasByMes($mes);
			$nSemanas = count($semanas);

			$str.="<table class='table table-condensed ".$nombre."' style='font-size:12px'>";
			$str.="<tr >";
				$str.="<th class='bg-primary'>SEM</th>
						<th style='background:#5cb85c; color:white; '>TOTAL MP</th>
						<th style='background:#5cb85c; color:white; '>OTROS MC</th>
						<th style='background:#5cb85c; color:white; '>TERMINADOS MP</th>
						<th style='background:#5cb85c; color:white; '>PENDIENTES MP</th>
						<!--th style='background:#5cb85c; color:white; ' title='MP ACUMULADOS'> + MP</th-->
						<th style='background:#5cb85c; color:white; '>% CMTO.</th>

						<th style='background:#f0ad4e; color:white; '>TOTAL MC</th>
						<th style='background:#f0ad4e; color:white; '>OTROS MC</th>
						<th style='background:#f0ad4e; color:white; '>TERMINADOS MC</th> 
						<th style='background:#f0ad4e; color:white; '>PENDIENTES MC</th>
						<th style='background:#f0ad4e; color:white; '> + MC</th>
						<th style='background:#f0ad4e; color:white; ' title='MC ACUMULADOS'>% CMTO.</th>
						<th class='bg-primary'>ACCIÓN</th>";
			$str.="</tr>";

			//$ultimo_dia = array_pop($semanas);
			$recorreSemana = 1;
			$fechaInicio = "";
			$fechaFinalizacion = "";

			$totalMesPreventivo = 0;
			$totalMesCorrectivo = 0;

			$posicion = 0; 
			foreach ($semanas as $semana) 
			{
				$subCumplimientoMP = 0;
				$subCumplimientoMC = 0;

				

				/*if($recorreSemana == 1)
				{*/
					$primerDia = $semana->fecha_inicio;
					$ultimoDia = $semana->fecha_fin;

					$fechaInicio = $ano."-".$primerDia;
					$fechaFinalizacion = $ano."-".$ultimoDia;


					//echo $semana->semana." = ".$fechaInicio." >> ". $fechaFinalizacion."<br>";
					//echo $fechaInicio;
					/*if ($ultimoDia < $primerDia) // para cuando es otro mes del rango
					{
						$nuevoMes = nombreMesIncrementa($mes); 
						

						if($nuevoMes == 01) // para cuando es el nuevo año
						{
							$ano = $ano + 1;
						}

						$fechaFinalizacion = $ano."-".$nuevoMes."-".$ultimoDia;

						$mesInicio = $mes-1;
						echo $mes;
						$fechaInicio = $ano."-".$mesInicio."-".$primerDia;
					}
					else
					{
						$fechaFinalizacion = $ano."-".$mes."-".$ultimoDia;
					}


					echo "semana=".$semana->semana." ->".$fechaInicio."<br>";*/
					//echo $fechaFinalizacion."<br>";

				//}

				// para todas las ordenes MP de la semana
				$programadosMP = Ordenesots::getAllProgramadosMP($fechaInicio, $fechaFinalizacion);
				$cuentaProgramadosMP = 0;
				if (count($programadosMP) > 0) 
				{
					$cuentaProgramadosMP = $programadosMP[0]->nProgramadosMP;
				}
				//echo $cuentaProgramadosMP;
				// para todas las ordenes mp terminados
				
				$terminadosMP = Ordenesots::getAllTerminadosMP($fechaInicio, $fechaFinalizacion);
				$cuentaTerminadosMP = 0;
				if (count($terminadosMP) > 0) 
				{
					$cuentaTerminadosMP = $terminadosMP[0]->nTerminadosMP;
				}

				// para todas las ordenes mp pendientes
				$pendientesMP = Ordenesots::getAllPendientesMP($fechaInicio, $fechaFinalizacion);
				$cuentaPendientesMP = 0;
				if (count($pendientesMP) > 0) 
				{
					$cuentaPendientesMP = $pendientesMP[0]->nPendientesMP;
				}

				// para toas las ordenes MP otros
				$otrosMP = Ordenesots::getAllOtrosMP($fechaInicio, $fechaFinalizacion);
				$cuentaOtrosMP = 0;
				if (count($otrosMP) > 0) 
				{
					$cuentaOtrosMP = $otrosMP[0]->nOtrosMP;
				}


				// para todas las ordenes MC de la semana
				$programadosMC = Ordenesots::getAllProgramadosMC($fechaInicio, $fechaFinalizacion);
				$cuentaProgramadosMC = 0;
				if (count($programadosMC) > 0) 
				{
					$cuentaProgramadosMC = $programadosMC[0]->nProgramadosMC;
				}

				// para todas las ordenes MC terminados
				$terminadosMC = Ordenesots::getAllTerminadosMC($fechaInicio, $fechaFinalizacion);
				$cuentaTerminadosMC = 0;
				if (count($terminadosMC) > 0) 
				{
					$cuentaTerminadosMC = $terminadosMC[0]->nTerminadosMC;
				}

				// para toas las ordenes MC pendientes
				$pendientesMC = Ordenesots::getAllPendientesMC($fechaInicio, $fechaFinalizacion);
				$cuentaPendientesMC = 0;
				if (count($pendientesMC) > 0) 
				{
					$cuentaPendientesMC = $pendientesMC[0]->nPendientesMC;
				}

				// para toas las ordenes MC otros
				$otrosMC = Ordenesots::getAllOtrosMC($fechaInicio, $fechaFinalizacion);
				$cuentaOtrosMC = 0;
				if (count($otrosMC) > 0) 
				{
					$cuentaOtrosMC = $otrosMC[0]->nOtrosMC;
				}

				// para el acumulado
					
					
					//echo $suma."<br>";
					$acumuladoMC = $sumaMC + $acumuladoMC;
					$acumuladoMP = $sumaMP + $acumuladoMP;
					

					
					//echo $acumuladoMC."<br>";
				
				// para el porcentaje de cumplimiento
				if($cuentaTerminadosMP > 0)
				{
					$subCumplimientoMP = ($cuentaTerminadosMP / $cuentaProgramadosMP) * 100;
					/*$subCumplimientoMP = ($cuentaTerminadosMP / ($cuentaProgramadosMP + $acumuladoMP) ) * 100;*/
					$subCumplimientoMP = round($subCumplimientoMP, 1);

					$totalMesPreventivo = $totalMesPreventivo + $subCumplimientoMP;	
				}
				if ($cuentaTerminadosMC > 0) 
				{
					/*$subCumplimientoMC = ($cuentaTerminadosMC / $cuentaProgramadosMC) * 100;*/ 

					$subCumplimientoMC = ($cuentaTerminadosMC / ($cuentaProgramadosMC + $acumuladoMC) ) * 100;

					$subCumplimientoMC = round($subCumplimientoMC, 1);

					$totalMesCorrectivo = $totalMesCorrectivo + $subCumplimientoMC;	
				}

				

				$str.="<tr>";
					$str.="<th class='bg-info'>".$semana->semana."</th>";
					$str.="<td class='bg-success'> <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='totalMP' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaProgramadosMP."</a></td>";
					$str.="<td class='bg-success'><a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='otrosMP' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaOtrosMP."</a></td>";
					$str.="<td class='bg-success'><a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='terminadoMP' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaTerminadosMP."</a></td>";
					$str.="<td class='bg-success'><a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='pendienteMP' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaPendientesMP."</a></td>";
					/*if($semana->semana != 1)
					{	
						$str.="<td class='bg-danger'>".$acumuladoMP."</td>";
					}
					else
					{
						$str.="<td class='bg-danger'>".$nPendientesAnoAnteriorMP."</td>";
					}*/
					//$str.="<td class='bg-danger'>".$acumuladoMP."</td>";
					$str.="<td class='bg-success'>".$subCumplimientoMP." % </td>";


					$str.="<td class='bg-warning'><a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='totalMC' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaProgramadosMC."</a></td>";
					$str.="<td class='bg-warning'><a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='otrosMC' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaOtrosMC."</a></td>";
					$str.="<td class='bg-warning'><a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='terminadoMC' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaTerminadosMC."</a></td>";
					$str.="<td class='bg-warning'><a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='pendienteMC' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaPendientesMC."</a></td>";

					/*if($semana->semana != 1)
					{	
						$str.="<td class='bg-danger'>".$acumuladoMC."</td>";
					}
					else
					{
						$str.="<td class='bg-danger'>".$nPendientesAnoAnteriorMC."</td>";
					}*/
					$str.="<td class='bg-warning'>".$acumuladoMC."</td>";

					

					$str.="<td class='bg-warning'>".$subCumplimientoMC." %</td>";

					// PARA VER LOS DETALLES
					$str.="<td class='bg-info'>
									<a href='indexMpvsMcDetails.php?semana=$semana->semana&fechaInicio=$fechaInicio&fechaFinalizacion=$fechaFinalizacion&ano=$ano' target='_blank' title='Ver detalles de semana $semana->semana' class='detalles_semana_".$semana->semana." btn btn-info btn-sm' parametroDetalleSemana='".$semana->semana."'>
										<i class='fa fa-eye' aria-hidden='true' ></i> 
									</a>";
									$verifica_historico = Mp_mc_historicos::verifica($ano, $mes, $semana->semana);
									//echo $verifica_historico;

									if($_SESSION["login_user"] == "lramos" && $verifica_historico == 0 )
									{
										$str.="<a type='button' class='btn btn-default btn-sm guardar_semana' data-toggle='confirmation'
											data-singleton='true'  data-btn-ok-label='S&iacute;'  data-btn-ok-class='btn-danger' data-btn-cancel-label='No' data-btn-cancel-class='btn-default' 
										semana='".$semana->semana."'
										mes='".$mes."'
										ano='".$ano."'
										totalmp='".$cuentaProgramadosMP."'
										otrosmp='".$cuentaOtrosMP."'
										terminadosmp='".$cuentaTerminadosMP."'
										pendientesmp='".$cuentaPendientesMP."'
										cumplimientomp='".$subCumplimientoMP."'

										totalmc='".$cuentaProgramadosMC."'
										otrosmc='".$cuentaOtrosMC."'
										terminadosmc='".$cuentaTerminadosMC."'
										pendientesmc='".$cuentaPendientesMC."'
										acumuladosmc='".$acumuladoMC."'
										cumplimientomc='".$subCumplimientoMC."'>

										<i class='fa fa-floppy-o' aria-hidden='true' ></i>
										</a>";	
									}
									
								$str.="</td>";
				$str.="</tr>";

				$sumaMC = $cuentaPendientesMC; // para la suma que viene
				$sumaMP = $cuentaPendientesMP;

				$recorreSemana++;
				$posicion++;
			}
				$str.="<tr>";
					$str.="<td 	colspan='5' class='totalMesPreventivo$nombre input-sm'>CUMPLIMIENTO MENSUAL PREVENTIVO</td>";
					$str.="<td > <input class='form-control input-sm valorMP$nombre' value='".round($totalMesPreventivo / $nSemanas, 2)."' readonly></td>";

					$str.="<td 	colspan='4' class='totalMesPreventivo$nombre input-sm'>CUMPLIMIENTO MENSUAL CORRECTIVO</td>";
					$str.="<td colspan='2'> <input class='form-control input-sm valorMC$nombre' value='".round($totalMesCorrectivo / $nSemanas, 2)."' readonly> </td>";
					$str.="<td> </td>";
				$str.="</tr>";
			$str.="</table>";
			$str.="<hr style='border-top: 1px dashed #8c8b8b;'>";
		}
	

		$str.="<!-- Modal -->
        <div class='modal fade bs-example-modal-lg' id='modalDetalles' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
            <div class='modal-dialog modal-lg' role='document'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    <h4 class='modal-title' id='myModalLabel'>Detalles de órdenes</h4>
                  </div>
                  <div class='modal-body' >
                    
                    <div class='table-responsive' id='recibeDetalles'>
                        
                    </div>

                  </div>
                  <div class='modal-footer'>
                    <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
                  </div>
                    
                </div>
            </div>
        </div>";	
	}
}
else
{
	$str.="NO DATA";
}


echo $str;


?>
<style type="text/css">
	.cabecera1
{
    text-align: center !important;
    font-size: 16px !important;
}

.mpideal
{
	color: white;
    background: #449d44;
}
.mpreal
{
	color: black;
    background: #f3d93a;
}

#disponibilityForFamily button
{
	width: 50px !important;
}

#original button
{
	width: 50px !important;
}
</style>
<!-- jQuery -->
    <script src="<?php echo $url; ?>vendor/jquery/jquery.js"></script>
    <!-- DataTables JavaScript -->
    <script src="<?php echo $url; ?>vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $url; ?>vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo $url; ?>vendor/datatables-responsive/dataTables.responsive.js"></script>

       <!-- Flot Charts JavaScript -->
   
    

    <script src="<?php echo $url; ?>dist/js/bootstrap-popover.js"></script>
    <script src="<?php echo $url; ?>dist/js/bootstrap-tooltip.js"></script>
      
    <script src="<?php echo $url; ?>dist/js/bootstrap-confirmation.js"></script>


    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $url; ?>vendor/bootstrap/js/bootstrap.min.js"></script>
 

	<script type="text/javascript">

		/*$('.dataTables-example').DataTable(
		{
	        //responsive: true,
	        "language":{
	            "oPaginate": {
	                "sNext" : "Siguiente",
	                "sPrevious": "Anterior"
	            },
	            "search": "Buscar ",
	            "sNext": "Siguiente",
	            "sPrevious": "Anterior",
	            "lengthMenu": "_MENU_ Registros por página",
	            "zeroRecords": "Nada encontrado",
	            "info": "Mostrando página _PAGE_ de _PAGES_",
	            "infoEmpty": "No registros disponibles",
	            "infoFiltered": "(filtrado de _MAX_ registros totales)"
	        }
	    });*/

	    $(document).ready(function()
	    {
	    	$(".detallesOrdenes").on("click", function(event) 
		    {
		        event.preventDefault();

		        var fechaInicio = null;
		        var fechaFinalizacion = null;
		        var lider = null;
		        var tipo = null;

		        var fechaInicio = $(this).attr("fechaInicio");
		        var fechaFinalizacion = $(this).attr("fechaFinalizacion");
		        var tipo = $(this).attr("tipo");

		        //Añadimos la imagen de carga en el contenedor
		        $("#modalDetalles").modal("show");
		        $('#recibeDetalles').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');
		      
		        $.get("helperMpvsMcDetailsGeneral.php", {fechaInicio:fechaInicio, fechaFinalizacion:fechaFinalizacion, tipo:tipo} ,function(data)
		        {
		            $("#recibeDetalles").html(data);
		        });
		        
		    });// fin de detalles
	    });
		

	</script>


<!-- ------------------------------------------------ -->
<!-- ------------------------------------------------ -->
<!-- PARA LA GRÁFICA DE MANTENIMIENTOS TOTALES EN EL MES -->
<!-- ------------------------------------------------ -->
<!-- ------------------------------------------------ -->
<script type="text/javascript">
	 	//$('[data-toggle="tooltip"]').tooltip();


    $('[data-toggle="confirmation"]').confirmation(
    {
        title: '¿Guardar?',
        btnOkLabel : '<i class="icon-ok-sign icon-white"></i> Sí',
              
        onConfirm: function(event) 
        {
        	event.preventDefault();
        	var ano = null;
        	var mes = null;
        	var semana = null;
        	var totalmp = null;
        	var otrosmp = null;
        	var terminadosmp = null;
        	var pendientesmp = null;
        	var cumplimientomp = null;

        	var totalmc = null;
        	var otrosmc = null;
        	var terminadosmc = null;
        	var pendientesmc = null;
        	var acumuladosmc = null;
        	var cumplimientomc = null;

        	ano = $(this).parents("td").children(".guardar_semana").attr("ano");
        	mes = $(this).parents("td").children(".guardar_semana").attr("mes");
        	semana = $(this).parents("td").children(".guardar_semana").attr("semana");
        	totalmp = $(this).parents("td").children(".guardar_semana").attr("totalmp");
        	otrosmp = $(this).parents("td").children(".guardar_semana").attr("otrosmp");
        	terminadosmp = $(this).parents("td").children(".guardar_semana").attr("terminadosmp");
        	pendientesmp = $(this).parents("td").children(".guardar_semana").attr("pendientesmp");
        	cumplimientomp = $(this).parents("td").children(".guardar_semana").attr("cumplimientomp");

        	totalmc = $(this).parents("td").children(".guardar_semana").attr("totalmc");
        	otrosmc = $(this).parents("td").children(".guardar_semana").attr("otrosmc");
        	terminadosmc = $(this).parents("td").children(".guardar_semana").attr("terminadosmc");
        	pendientesmc = $(this).parents("td").children(".guardar_semana").attr("pendientesmc");
        	acumuladosmc = $(this).parents("td").children(".guardar_semana").attr("acumuladosmc");
        	cumplimientomc = $(this).parents("td").children(".guardar_semana").attr("cumplimientomc");

        	$(this).confirmation('hide');
        	$(".popover").hide();
        	$(this).parents("td").children(".guardar_semana").remove();

        	$.post(
	            "create_mp_mc_historicos.php",
	            { ano: ano, mes:mes, semana:semana, totalmp:totalmp, otrosmp:otrosmp, terminadosmp:terminadosmp, pendientesmp:pendientesmp, cumplimientomp:cumplimientomp, totalmc:totalmc, otrosmc:otrosmc, terminadosmc:terminadosmc, pendientesmc:pendientesmc, acumuladosmc:acumuladosmc, cumplimientomc:cumplimientomc },
	              	function(data) 
	              	{
	              		alert("Información de semana: "+semana+" guardada en el sistema.");
	                	//$('#semestre').html(data);
	            	}
	           );
        	
          //var idR = $(this).parents("tr").attr("campoid");
          //window.location.href='deleteUser.php?id='+idR;
        },

    });


    google.charts.load("visualization", "1", {packages:["corechart","bar"]});
    google.charts.setOnLoadCallback(drawPorMes);
    google.charts.setOnLoadCallback(drawPorHistorico);
      
     
    
	function drawPorMes()
	{
		var meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];

		var constructor = [['',  'TOTAL', 'Preventivos', 'Correctivos' ]];
		$.each(meses, function( key, value ) 
		{
			var mes = value;
	
				var porcentajePreventivo = 0;
				var porcentajeCorrectivo = 0;

				porcentajeMes = 0;
				//promedio = 0;

			$( ".totalMesPreventivo"+mes).each(function() 
			{
			   porcentajePreventivo = $(".valorMP"+mes).val();
			   porcentajeCorrectivo = $(".valorMC"+mes).val();
			   //console.log(porcentajePreventivo);
			   
			});
			porcentajePreventivo = parseFloat(porcentajePreventivo);
			porcentajeCorrectivo = parseFloat(porcentajeCorrectivo);

			porcentajeMes = parseFloat( (porcentajePreventivo + porcentajeCorrectivo) / 2 );

			


			/*contadorPreventivo = parseInt(contadorPreventivo);
			contadorCorrectivo = parseInt(contadorPreventivo);*/
			/*constructor.push([mes, porcentajePreventivo, porcentajeCorrectivo, porcentajeMes]);*/

			constructor.push([mes, porcentajeMes, porcentajePreventivo, porcentajeCorrectivo]);
		});

		var data = google.visualization.arrayToDataTable(constructor);

        var options = {
        	
          chart: {
            //title: 'Company Performance',
            subtitle: 'Cumplimiento mensual de MP vs MC',
            displayAnnotations: true,

          },
          bars: 'vertical',
          vAxis: {
          		//format: 'percent',
          		 //textStyle: { color: '#94511A'},
          		//title: '% de cumplimiento',
          		
          		format: '#\'%\'',
          		

          		//format: '#',
          		//viewWindow: {min: 0, max: 85},
          		//gridlines:{count:5},
          		
          		
      		},
      		
          height: 315,
          /*width:400,*/
          colors: ['#337ab7', '#5cb85c', '#f0ad4e']
        };

        var chart = new google.charts.Bar(document.getElementById('graficaActualizada'));

        chart.draw(data, google.charts.Bar.convertOptions(options));

	}
	
	function drawPorHistorico()
	{
		// Para crear la gráfica de cumplimiento histórico
	 	var anoParametro = $("#ano").val();
	 	var meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
		var constructorHistorico = [['',  'TOTAL', 'Preventivos', 'Correctivos']];

	 	$.getJSON("api_mp_mc_historico.php?ano="+anoParametro, function(result)
	 	{
	 		$.each(meses, function(key, value)
	 		{
	 			var mesHistorico = "";
	 			var mes = value;

	 			var porcentajePreventivo = 0;
				var porcentajeCorrectivo = 0;

				var porcentajeMesMp = 0;
				var porcentajeMesMc = 0;
				var porcentajeMesTotal = 0;
				var cuentaSemana = 0;
	 			// COMPARANDO MESES
	 			$.each(result, function(i, field)
		      	{
		 			if (field['mes'] == '01')
		 			{
		 				mesHistorico = "ENERO";
		 			}
		 			else if(field['mes'] == '02')
		 			{
		 				mesHistorico = "FEBRERO";
		 			}
		 			else if(field['mes'] == '03')
		 			{
		 				mesHistorico = "MARZO";
		 			}
		 			else if(field['mes'] == '04')
		 			{
		 				mesHistorico = "ABRIL";
		 			}
		 			else if(field['mes'] == '05')
		 			{
		 				mesHistorico = "MAYO";
		 			}
		 			else if(field['mes'] == '06')
		 			{
		 				mesHistorico = "JUNIO";
		 			}
		 			else if(field['mes'] == '07')
		 			{
		 				mesHistorico = "JULIO";
		 			}
		 			else if(field['mes'] == '08')
		 			{
		 				mesHistorico = "AGOSTO";
		 			}
		 			else if(field['mes'] == '09')
		 			{
		 				mesHistorico = "SEPTIEMBRE";
		 			}
		 			else if(field['mes'] == '10')
		 			{
		 				mesHistorico = "OCTUBRE";
		 			}
		 			else if(field['mes'] == '11')
		 			{
		 				mesHistorico = "NOVIEMBRE";
		 			}
		 			else if(field['mes'] == '12')
		 			{
		 				mesHistorico = "DICIEMBRE";
		 			}
		 			//console.log(mesHistorico);
	 				if(mesHistorico == mes)
		 			{
					   porcentajePreventivo = parseFloat(field['cumplimientomp']) + parseFloat(porcentajePreventivo);
					   porcentajeCorrectivo = parseFloat(field['cumplimientomc']) + parseFloat(porcentajeCorrectivo);
					  // porcentajeCorrectivo = $(".valorMC"+mes).val();
					   
						   
						
					/*porcentajePreventivo = parseFloat(porcentajePreventivo);
					porcentajeCorrectivo = parseFloat(porcentajeCorrectivo);

					porcentajeMes = parseFloat( (porcentajePreventivo + porcentajeCorrectivo) / 2 );

					constructorHistorico.push([mes, porcentajeMes, porcentajePreventivo, porcentajeCorrectivo]);*/
						cuentaSemana++;

		 			}
	 			
		        	/*console.log("ano = "+field['ano'] +" mes= " + field['mes'] + " semana= "+field['semana']);*/
		      	});// fin de each result

	 			if(porcentajePreventivo > 0)
	 			{
	 				porcentajeMesMp = porcentajePreventivo / cuentaSemana;	
	 			}
	 			else
	 			{
	 				porcentajeMesMp = parseFloat(porcentajePreventivo);
	 			}

	 			if(porcentajeCorrectivo > 0)
	 			{
	 				porcentajeMesMc = porcentajeCorrectivo / cuentaSemana;
	 			}
	 			else
	 			{
	 				porcentajeMesMc = parseFloat(porcentajeCorrectivo);
	 			}
		      	
		      	
	 			/*if(porcentajeMesTotal > 0)
	 			{*/
	 				porcentajeMesTotal = parseFloat( (porcentajeMesMp + porcentajeMesMc) / 2 );
	 			/*}
	 			else
	 			{
	 				porcentajeMesTotal = parseFloat(porcentajeMesTotal);
	 			}*/
		      	

		      	//console.log(porcentajeMesTotal);

		      	constructorHistorico.push([mes, porcentajeMesTotal
		      		, porcentajeMesMp, porcentajeMesMc]);

		      	

	 		});// fin de each mes

	 		var data = google.visualization.arrayToDataTable(constructorHistorico);

	        var options = {
	        	
	          chart: {
	            //title: 'Company Performance',
	            subtitle: 'Cumplimiento mensual de MP vs MC Histórico',

	          },
	          bars: 'vertical',
	          vAxis: {
	          		title: '% de cumplimiento',
	          		format: '#\'%\''
	          		
	          		
	      		},
	          height: 315,
	          colors: ['#337ab7', '#5cb85c', '#f0ad4e']
	        };

	        var chart = new google.charts.Bar(document.getElementById('graficaHistorica'));

	        chart.draw(data, google.charts.Bar.convertOptions(options));

	    }); // fin de getJson
		

	}

</script>


