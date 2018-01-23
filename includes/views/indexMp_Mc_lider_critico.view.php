 <?php require_once(VIEW_PATH.'header.inc.php');
      
 ?>        
        <div class="right_col" role="main"> 
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Detalles de cumplimiento <?php echo $nombreResponsable; ?></h3>
                    </div>
                 </div>

                <div class="clearfix"></div>  


            <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-cogs"></i> Datos <small>en el sistema</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content table-responsive">           
                                <!-- aqui va el contenido -->
                <?php
					$str="";
					if(isset($ano ) && isset($responsable))// para el admimistrador
					{	

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
					 
						
						/*if($ano > 2016)
						{*/
							$meses = Calendario_nature::getAllMeses();
							//print_r($meses);
							// Esto es para traernos los pendientes del otro año
							//echo $ano;
							//$responsable = 41185; 
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
								
								$consulta = "SELECT count(ordenesots.orden_trabajo) AS nPendientesMP, activos_equipos.nombre_equipo 
									FROM ordenesots
									INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo 
									WHERE ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior')
					 				AND ordenesots.tipo='Mant. preventivo'
					 				AND (ordenesots.estado = 'Programada' 
					 					OR ordenesots.estado = 'Cierre Lider Mtto'
					 					OR ordenesots.estado = 'Ejecutado'
					 					OR ordenesots.estado = 'Espera de equipo'
					 					OR ordenesots.estado = 'Espera de refacciones'
					 					OR ordenesots.estado = 'Falta de mano de obra'
					 					OR ordenesots.estado = 'Abierta')
			         				AND ordenesots.responsable = 41185";

								$pendientesAnoAnteriorMP = Ordenesots::getAllConsulta($consulta);

								$consulta = "SELECT count(ordenesots.orden_trabajo) AS nPendientesMC, activos_equipos.nombre_equipo 
									FROM ordenesots
									INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo 
									WHERE ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior') 
									AND (ordenesots.tipo <> 'Mant. preventivo') 
									AND (ordenesots.estado = 'Programada' 
										OR ordenesots.estado = 'Cierre Lider Mtto' 
										OR ordenesots.estado = 'Ejecutado' 
										OR ordenesots.estado = 'Espera de equipo' 
										OR ordenesots.estado = 'Espera de refacciones'
										OR ordenesots.estado = 'Falta de mano de obra'
										OR ordenesots.estado = 'Abierta'
										OR ordenesots.estado = 'Solic. de trabajo')
									AND ordenesots.responsable = 41185";

								$pendientesAnoAnteriorMC = Ordenesots::getAllConsulta($consulta);
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
								$str.="<h4 style='text-align:center;' class='hidden'>MANTENIMIENTOS</h4>
										<input class='form-control hidden' type='number' id='ano' value='$ano' >";

						        $str.="<div class='row'>";
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

								


								$str.="<h4 class='text-center '>".$nombre."</h4>";

								$semanas = Calendario_nature::getAllSemanasByMes($mes);
								$nSemanas = count($semanas);

								$str.="<table class='table table-bordered ".$nombre." ' style='font-size:11px'>";
								$str.="<tr >";
									$str.="<th class='bg-primary'>SEM</th>
											<th style='background:#5cb85c; color:white; '>TOTAL MP</th>
											<!--th style='background:#5cb85c; color:white; '>OTROS MC</th-->
											<th style='background:#5cb85c; color:white; '>TERMINADOS MP</th>
											<th style='background:#5cb85c; color:white; '>PENDIENTES MP</th>
											<!--th style='background:#5cb85c; color:white; ' title='MP ACUMULADOS'> + MP</th-->
											<th style='background:#5cb85c; color:white; '>% CMTO.</th>

											<th style='background:#f0ad4e; color:white; '>TOTAL MC</th>
											<!--th style='background:#f0ad4e; color:white; '>OTROS MC</th-->
											<th style='background:#f0ad4e; color:white; '>TERMINADOS MC</th> 
											<th style='background:#f0ad4e; color:white; '>PENDIENTES MC</th>
											<th style='background:#f0ad4e; color:white; '> + MC</th>
											<th style='background:#f0ad4e; color:white; ' title='MC ACUMULADOS'>% CMTO.</th>";
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

									
										$primerDia = $semana->fecha_inicio;
										$ultimoDia = $semana->fecha_fin;


										$fechaInicio = $ano."-".$primerDia;
										$fechaFinalizacion = $ano."-".$ultimoDia;


										
									

									// para todas las ordenes MP de la semana
									$consulta = "SELECT count(ordenesots.orden_trabajo) AS nProgramadosMP, activos_equipos.nombre_equipo 
												FROM ordenesots
												INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo 
												WHERE ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion') 
												AND ordenesots.tipo='Mant. preventivo'
												AND (ordenesots.estado = 'Cierre Lider Mtto'
										 	OR ordenesots.estado = 'Ejecutado'
										 	OR ordenesots.estado = 'Espera de equipo'
										 	OR ordenesots.estado = 'Espera de refacciones'
										 	OR ordenesots.estado = 'Falta de mano de obra'
										 	OR ordenesots.estado = 'Programada' 
										 	OR ordenesots.estado = 'Terminado' )
										 	AND ordenesots.responsable = $responsable";

										 	//if ($mes == 04)echo $consulta."<br>";

									$programadosMP = Ordenesots::getAllConsulta($consulta);
									$cuentaProgramadosMP = 0;
									if (count($programadosMP) > 0) 
									{
										$cuentaProgramadosMP = $programadosMP[0]->nProgramadosMP;
									}

									// para todas las ordenes mp terminados
									$consulta = "SELECT count(ordenesots.orden_trabajo) AS nTerminadosMP, activos_equipos.nombre_equipo 
												FROM ordenesots
												INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo 
												WHERE ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
												 AND ordenesots.tipo='Mant. preventivo'
												 AND (ordenesots.estado='Terminado')
												 AND ordenesots.responsable = $responsable";
									$terminadosMP = Ordenesots::getAllConsulta($consulta);
									$cuentaTerminadosMP = 0;
									if (count($terminadosMP) > 0) 
									{
										$cuentaTerminadosMP = $terminadosMP[0]->nTerminadosMP;
									}

									// para todas las ordenes mp pendientes
									$consulta = "SELECT count(ordenesots.orden_trabajo) AS nPendientesMP, activos_equipos.nombre_equipo
												FROM ordenesots
												INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo 
												WHERE ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
												 AND ordenesots.tipo='Mant. preventivo'
												 AND (ordenesots.estado = 'Programada' 
												 		OR ordenesots.estado = 'Cierre Lider Mtto'
												 		OR ordenesots.estado = 'Ejecutado'
												 		OR ordenesots.estado = 'Espera de equipo'
												 		OR ordenesots.estado = 'Espera de refacciones'
												 		OR ordenesots.estado = 'Falta de mano de obra')
												 AND ordenesots.responsable = $responsable";
									$pendientesMP = Ordenesots::getAllConsulta($consulta);
									$cuentaPendientesMP = 0;
									if (count($pendientesMP) > 0) 
									{
										$cuentaPendientesMP = $pendientesMP[0]->nPendientesMP;
									}

									// para toas las ordenes MP otros
									/*$otrosMP = Ordenesots::getAllOtrosMP($fechaInicio, $fechaFinalizacion);
									$cuentaOtrosMP = 0;
									if (count($otrosMP) > 0) 
									{
										$cuentaOtrosMP = $otrosMP[0]->nOtrosMP;
									}*/


									// para todas las ordenes MC de la semana
									$consulta = "SELECT count(ordenesots.orden_trabajo) AS nProgramadosMC, activos_equipos.nombre_equipo
											FROM ordenesots
											INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo 
											WHERE ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
									 AND (ordenesots.tipo <> 'Mant. preventivo')
									 AND (ordenesots.estado = 'Cierre Lider Mtto'
									 	OR ordenesots.estado = 'Ejecutado'
									 	OR ordenesots.estado = 'Espera de equipo'
									 	OR ordenesots.estado = 'Espera de refacciones'
									 	OR ordenesots.estado = 'Falta de mano de obra'
									 	OR ordenesots.estado = 'Programada' 
									 	OR ordenesots.estado = 'Terminado'
									 	OR ordenesots.estado = 'Abierta'
									 	OR ordenesots.estado = 'Solic. de trabajo' )
									 	AND ordenesots.responsable = $responsable";
									$programadosMC = Ordenesots::getAllConsulta($consulta);
									$cuentaProgramadosMC = 0;
									if (count($programadosMC) > 0) 
									{
										$cuentaProgramadosMC = $programadosMC[0]->nProgramadosMC;
									}

									// para todas las ordenes MC terminados
									$consulta = "SELECT count(ordenesots.orden_trabajo) AS nTerminadosMC, activos_equipos.nombre_equipo 
												FROM ordenesots
												INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo 
												WHERE ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
										 		AND (ordenesots.tipo <> 'Mant. preventivo')
										 		AND (ordenesots.estado = 'Terminado')
												AND ordenesots.responsable = $responsable";
									$terminadosMC = Ordenesots::getAllConsulta($consulta);
									$cuentaTerminadosMC = 0;
									if (count($terminadosMC) > 0) 
									{
										$cuentaTerminadosMC = $terminadosMC[0]->nTerminadosMC;
									}

									// para toas las ordenes MC pendientes
									// para todas las ordenes MC terminados
									$consulta = "SELECT count(ordenesots.orden_trabajo) AS nPendientesMC, activos_equipos.nombre_equipo
												FROM ordenesots
												INNER JOIN activos_equipos ON ordenesots.equipo = activos_equipos.nombre_equipo
												WHERE ( ordenesots.fecha_finalizacion_programada BETWEEN '$fechaInicio' AND '$fechaFinalizacion')
												 AND (ordenesots.tipo <> 'Mant. preventivo')
												 AND (ordenesots.estado = 'Programada' 
												 		OR ordenesots.estado = 'Cierre Lider Mtto'
												 		OR ordenesots.estado = 'Ejecutado'
												 		OR ordenesots.estado = 'Espera de equipo'
												 		OR ordenesots.estado = 'Espera de refacciones'
												 		OR ordenesots.estado = 'Falta de mano de obra'
												 		OR ordenesots.estado = 'Abierta'
												 		OR ordenesots.estado = 'Solic. de trabajo') 
												AND ordenesots.responsable = $responsable";
									$pendientesMC = Ordenesots::getAllConsulta($consulta);
									$cuentaPendientesMC = 0;
									if (count($pendientesMC) > 0) 
									{
										$cuentaPendientesMC = $pendientesMC[0]->nPendientesMC;
									}

									// para toas las ordenes MC otros
									/*$otrosMC = Ordenesots::getAllOtrosMC($fechaInicio, $fechaFinalizacion);
									$cuentaOtrosMC = 0;
									if (count($otrosMC) > 0) 
									{
										$cuentaOtrosMC = $otrosMC[0]->nOtrosMC;
									}*/

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
										$str.="<th >".$semana->semana."</th>";
										$str.="<td class='bg-info mp_programados_wk".$semana->semana."'>".$cuentaProgramadosMP."</td>";
										/*$str.="<td style='background: #5b4282; color:white;'>".$cuentaOtrosMP."</td>";*/
										$str.="<td class='bg-success'>".$cuentaTerminadosMP."</td>";
										$str.="<td class='bg-warning'>".$cuentaPendientesMP."</td>";
										
										$str.="<td class='bg-default'>".$subCumplimientoMP." % </td>";


										$str.="<td class='bg-info mc_programados_wk".$semana->semana."'>".$cuentaProgramadosMC."</td>";
										/*$str.="<td style='background: #5b4282; color:white;'>".$cuentaOtrosMC."</td>";*/
										$str.="<td class='bg-success'>".$cuentaTerminadosMC."</td>";
										$str.="<td class='bg-warning'>".$cuentaPendientesMC."</td>";

										
										$str.="<td class='bg-danger'>".$acumuladoMC."</td>";

										

										$str.="<td class='bg-default'>".$subCumplimientoMC." %</td>";

										
									$str.="</tr>";

									$sumaMC = $cuentaPendientesMC; // para la suma que viene
									$sumaMP = $cuentaPendientesMP;

									$recorreSemana++;
									$posicion++;
								}
									$str.="<tr>";
										$str.="<td 	colspan='4' class='totalMesPreventivo$nombre'>CUMPLIMIENTO MENSUAL PREVENTIVO</td>";
										$str.="<td > <input class='form-control valorMP$nombre' value='".round($totalMesPreventivo / $nSemanas, 2)."' readonly></td>";

										$str.="<td 	colspan='3' class='totalMesPreventivo$nombre'>CUMPLIMIENTO MENSUAL CORRECTIVO</td>";
										$str.="<td colspan='2'> <input class='form-control valorMC$nombre' value='".round($totalMesCorrectivo / $nSemanas, 2)."' readonly> </td>";
									$str.="</tr>";
								$str.="</table>";
								$str.="<hr style='border-top: 1px dashed #8c8b8b;'>";
							}
						

							
						//}
					}
					else
					{
						$str.="NO DATA";
					}


					echo $str;


					?>
				<input type="text" id="fechaInicio" class='form-control hidden' value='<?php echo $fechaInicio; ?>'>
                    <input type="text" id="fechaFinalizacion" class='form-control hidden' value='<?php echo $fechaFinalizacion; ?>'>
                    
                    
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->


 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>
   <!-- Flot Charts JavaScript -->
    <script src="<?php echo $url; ?>dist/js/loader.js"></script>
    <script src="<?php echo $url; ?>dist/js/jsapi.js"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $(".left_col").addClass("hidden", "hidden");
            $(".top_nav").css("margin-left", 0);
            $(".right_col").css("margin-left", 0);
            $(".toggle").addClass("hidden", "hidden");
            

            // ----------------------------------------------------------------

    google.charts.load("visualization", "1", {packages:["corechart","bar","line"]});
    google.charts.setOnLoadCallback(drawPorMes);
    google.charts.setOnLoadCallback(drawOTsemanal);
     
    
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
                
                format: '#\'%\''

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
            
            // ----------------------------------------------------------------

        }); // end ready




    </script>





</body>

</html>                 


