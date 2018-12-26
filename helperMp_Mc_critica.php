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



	$parametro = $_GET['parametro'];
 
	
	if($parametro == "MPvsMC")
	{


		$meses = Disponibilidad_meses::getAllByOrden("mes","ASC");
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
			$data_min = Disponibilidad_calendarios::getMinDiaByAno($anoAnterior);
			$fechaInicioAnoAnterior = $data_min[0]->dia;

			$data_max = Disponibilidad_calendarios::getMaxDiaByAno($anoAnterior); 
			$fechaFinalizacionAnoAnterior = $data_max[0]->dia;

			$pendientesAnoAnteriorMP = Disponibilidad_data::getAllPendientesMPcriticos($fechaInicioAnoAnterior, $fechaFinalizacionAnoAnterior);
			$pendientesAnoAnteriorMC = Disponibilidad_data::getAllPendientesMCcriticos($fechaInicioAnoAnterior, $fechaFinalizacionAnoAnterior);
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
			$str.="<h4 style='text-align:center;' >MANTENIMIENTOS A EQUIPOS CRÍTICOS</h4>
					<input class='form-control hidden' type='number' id='ano' value='$ano'>
					<a href='indexMp_Mc_lider_critico.php?responsable=41185&ano=$ano' target='_blank' title='Ver cumplimiento por líder' type='button' class='btn btn-default btn-md'> <i class='fa fa-user' aria-hidden='true'></i> Orfanel</a>
					<a href='indexMp_Mc_lider_critico.php?responsable=239&ano=$ano' target='_blank' title='Ver cumplimiento por líder' type='button' class='btn btn-default btn-md'> <i class='fa fa-user' aria-hidden='true'></i> Humberto</a>
					 <br>";



	        $str.="<br><div class='row'>";
				$str.="<div class='col-md-12 col-sm-12'>
	                    <div class='panel panel-default' style='border-color: #d43f3a !important;'>
	                        <div class='panel-heading' style='background-color: #d43f3a !important;
    color: white !important;'>
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

	        $str.="<br><div class='row'>";
				$str.="<div class='col-md-12 col-sm-12'>
	                    <div class='panel panel-default' style='border-color: #d43f3a !important;'>
	                        <div class='panel-heading' style='background-color: #d43f3a !important;
    color: white !important;'>
	                            MC VS MP DE OT PROGRAMADAS
	                        </div>
	                        <!-- /.panel-heading -->
	                        <div class='panel-body '>
	                             <div width='100%' id='graficaOTSemanal'></div>
	                        </div>
	                        <!-- /.panel-body -->
	                    </div>
	                    <!-- /.panel --> 
	                </div>";
	        $str.="</div>";

	        /*$str.="<div class='row'>";
				$str.="<div class='col-md-12 col-sm-12'>
	                    <div class='panel panel-default' style='border-color: #d43f3a !important;'>
	                        <div class='panel-heading' style='background-color: #d43f3a !important;
    color: white !important;'>
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
	        $str.="</div>";*/

	       

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

			$semanas = Disponibilidad_calendarios::getAllSemanasByMesAno($mes, $ano);
			$nSemanas = count($semanas);

			$str.="<table class='table table-condensed ".$nombre."' style='font-size:12px'>";
			$str.="<tr >";
				$str.="<th class='bg-primary'>SEM</th>
						<th style='background:#5cb85c; color:white; '>TOTAL MP</th>
						<th style='background:#5cb85c; color:white; '>OTROS MP</th>
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

				
				$semanaDia_min = Disponibilidad_calendarios::getMinDiaByAnoSemana($semana->semana, $ano);
				$semanaDia_max = Disponibilidad_calendarios::getMaxDiaByAnoSemana($semana->semana, $ano);

				$fechaInicio = $semanaDia_min[0]->dia;
				$fechaFinalizacion = $semanaDia_max[0]->dia;

					

				// para todas las ordenes MP de la semana
				$programadosMP = Disponibilidad_data::getAllProgramadosMPcriticos($fechaInicio, $fechaFinalizacion);
				$cuentaProgramadosMP = 0;
				if (count($programadosMP) > 0) 
				{
					$cuentaProgramadosMP = $programadosMP[0]->nProgramadosMP;
				}

				// para todas las ordenes mp terminados
				
				$terminadosMP = Disponibilidad_data::getAllTerminadosMPcriticos($fechaInicio, $fechaFinalizacion);
				$cuentaTerminadosMP = 0;
				if (count($terminadosMP) > 0) 
				{
					$cuentaTerminadosMP = $terminadosMP[0]->nTerminadosMP;
				}

				// para todas las ordenes mp pendientes
				$pendientesMP = Disponibilidad_data::getAllPendientesMPcriticos($fechaInicio, $fechaFinalizacion);
				$cuentaPendientesMP = 0;
				if (count($pendientesMP) > 0) 
				{
					$cuentaPendientesMP = $pendientesMP[0]->nPendientesMP;
				}

				// para toas las ordenes MP otros
				$otrosMP = Disponibilidad_data::getAllOtrosMPcriticos($fechaInicio, $fechaFinalizacion);
				$cuentaOtrosMP = 0;
				if (count($otrosMP) > 0) 
				{
					$cuentaOtrosMP = $otrosMP[0]->nOtrosMP;
				}


				// para todas las ordenes MC de la semana
				$programadosMC = Disponibilidad_data::getAllProgramadosMCcriticos($fechaInicio, $fechaFinalizacion);
				$cuentaProgramadosMC = 0;
				if (count($programadosMC) > 0) 
				{
					$cuentaProgramadosMC = $programadosMC[0]->nProgramadosMC;
				}

				// para todas las ordenes MC terminados
				$terminadosMC = Disponibilidad_data::getAllTerminadosMCcriticos($fechaInicio, $fechaFinalizacion);
				$cuentaTerminadosMC = 0;
				if (count($terminadosMC) > 0) 
				{
					$cuentaTerminadosMC = $terminadosMC[0]->nTerminadosMC;
				}

				// para toas las ordenes MC pendientes
				$pendientesMC = Disponibilidad_data::getAllPendientesMCcriticos($fechaInicio, $fechaFinalizacion);
				$cuentaPendientesMC = 0;
				if (count($pendientesMC) > 0) 
				{
					$cuentaPendientesMC = $pendientesMC[0]->nPendientesMC;
				}

				// para toas las ordenes MC otros
				$otrosMC = Disponibilidad_data::getAllOtrosMCcriticos($fechaInicio, $fechaFinalizacion);
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

				

				$str.="<tr >";
					$str.="<th class='bg-info ' >".$semana->semana."</th>";
					$str.="<td class='bg-success'> <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes mp_programados_wk".$semana->semana."' tipo='totalMP' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaProgramadosMP."</td>";
					$str.="<td class='bg-success'> <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='otrosMP' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaOtrosMP."</td>";
					$str.="<td class='bg-success'> <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='terminadoMP' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaTerminadosMP."</td>";
					$str.="<td class='bg-success'> <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='pendienteMP' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaPendientesMP."</td>";
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


					$str.="<td class='bg-warning'> <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes mc_programados_wk".$semana->semana."' tipo='totalMC' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaProgramadosMC."</td>";
					$str.="<td class='bg-warning'> <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='otrosMC' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaOtrosMC."</td>";
					$str.="<td class='bg-warning'> <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='terminadoMC' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaTerminadosMC."</td>";
					$str.="<td class='bg-warning'> <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='pendienteMC' fechaInicio='$fechaInicio' fechaFinalizacion='$fechaFinalizacion'>".$cuentaPendientesMC."</td>";

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
									<a href='indexMpvsMcDetailsCriticos.php?semana=$semana->semana&fechaInicio=$fechaInicio&fechaFinalizacion=$fechaFinalizacion&ano=$ano' target='_blank' title='Ver detalles de semana $semana->semana' class='detalles_semana_".$semana->semana." btn btn-info btn-md' parametroDetalleSemana='".$semana->semana."'>
										<i class='fa fa-eye' aria-hidden='true' ></i> 
									</a>";
									/*$verifica_historico = Mp_mc_historicos::verifica($ano, $mes, $semana->semana);
									//echo $verifica_historico;

									if($_SESSION["login_user"] == "lramos" && $verifica_historico == 0 )
									{
										$str.="<a type='button' class='btn btn-default btn-md guardar_semana' data-toggle='confirmation'
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
									}*/
									
								$str.="</td>";
				$str.="</tr>";

				$sumaMC = $cuentaPendientesMC; // para la suma que viene
				$sumaMP = $cuentaPendientesMP;

				$recorreSemana++;
				$posicion++;
			}
				$str.="<tr>";
					$str.="<td 	colspan='5' class='totalMesPreventivo$nombre'>CUMPLIMIENTO MENSUAL PREVENTIVO</td>";
					$str.="<td > <input class='form-control valorMP$nombre' value='".round($totalMesPreventivo / $nSemanas, 2)."' readonly></td>";

					$str.="<td 	colspan='4' class='totalMesPreventivo$nombre'>CUMPLIMIENTO MENSUAL CORRECTIVO</td>";
					$str.="<td colspan='2'> <input class='form-control valorMC$nombre' value='".round($totalMesCorrectivo / $nSemanas, 2)."' readonly> </td>";
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
    <!--script src="<?php echo $url; ?>vendor/jquery/jquery.js"></script-->
    <!-- DataTables JavaScript -->
    <!--script src="<?php echo $url; ?>vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $url; ?>vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo $url; ?>vendor/datatables-responsive/dataTables.responsive.js"></script-->

       <!-- Flot Charts JavaScript -->
   
    

    <!--script src="<?php echo $url; ?>dist/js/bootstrap-popover.js"></script>
    <script src="<?php echo $url; ?>dist/js/bootstrap-tooltip.js"></script>
      
    <script src="<?php echo $url; ?>dist/js/bootstrap-confirmation.js"></script-->

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
		      
		        $.get("helperMpvsMcDetailsGeneralCriticos.php", {fechaInicio:fechaInicio, fechaFinalizacion:fechaFinalizacion, tipo:tipo} ,function(data)
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
    /*$('[data-toggle="confirmation"]').confirmation(
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

    });*/


    google.charts.load("visualization", "1", {packages:["corechart","bar","line"]});
    google.charts.setOnLoadCallback(drawPorMes);
    google.charts.setOnLoadCallback(drawOTsemanal); // para graficar los numeros de mantenimientos de mp y mc semanales
    //google.charts.setOnLoadCallback(drawPorHistorico);
      
     
    
	function drawPorMes()
	{
		var meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];

		var constructor = [['',  'TOTAL', 'Preventivos', 'Correctivos']];
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

          },
          bars: 'vertical',
          vAxis: {
          		//format: 'percent',
          		 //textStyle: { color: '#94511A'},
          		title: '% de cumplimiento',
          		
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

	function drawOTsemanal()
	{
		var semanitas = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52];

		var constructor = [['WK', 'Preventivos', 'Correctivos']];
		$.each(semanitas, function( key, value ) 
		{
			var semanita = value;
	
				var nMP = 0;
				var nMC = 0;

			
			   nMP = $(".mp_programados_wk"+semanita).text();
			   nMC = $(".mc_programados_wk"+semanita).text();
			   //console.log(porcentajePreventivo);
			   
			
				nMP = parseInt(nMP);
				nMC = parseInt(nMC);
				console.log("preventivos: "+ nMP+"Correctivos: "+ nMC);

				constructor.push(["S "+semanita, nMP, nMC]);
		});

		var data = google.visualization.arrayToDataTable(constructor);

        var options = 
        {
        	hAxis: {
          		//title: 'WK',
          		logScale: true,
          		titleFontSize:12
        	},
        		vAxis: {
          		title: 'No. de mant.',
          		//logScale: true,
          		format: '#'
          		
        	},
        		height: 315,
        		//width: 1200,
        		colors: ['#5cb85c', '#f0ad4e'],
        		fontSize:12, 
            	legendFontSize:12, 
            	titleFontSize:12, 
            	tooltipFontSize:12,
            	chartArea: {width: '86%', height: '75%'}
      	};

	      var chart = new google.visualization.LineChart(document.getElementById('graficaOTSemanal'));
	      chart.draw(data, options);

	}
	
	/*function drawPorHistorico()
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
					   
						   
						
					
						cuentaSemana++;

		 			}
	 			
		        	//console.log("ano = "+field['ano'] +" mes= " + field['mes'] + " semana= "+field['semana']);
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
		      	
		      	
	 			
	 				porcentajeMesTotal = parseFloat( (porcentajeMesMp + porcentajeMesMc) / 2 );
	 			
		      	

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
		

	}*/

</script>


