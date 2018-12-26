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
	//$fechaHoyFormateada = date("m-d");
	$fechaHoy = date("Y-m-d");

	$min_calendario = Disponibilidad_calendarios::getMinDiaByAnoSemana($semana, $ano);    
    $max_calendario = Disponibilidad_calendarios::getMaxDiaByAnoSemana($semana, $ano);
    $inicio = $min_calendario[0]->dia;
    $fin = $max_calendario[0]->dia;

	$fechasActual = Disponibilidad_calendarios::getByDia($fechaHoy);
	$semanaActual = $fechasActual[0]->semana;
	//echo $semanaActual;

	if($semana != $semanaActual)
	{
		$fechaHoy = $fin;
	}
	/*echo "Fecha inicio: ".$fechaHoy;
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
 
	
	if($parametro == "CUMPLIMIENTO_V2")
	{
		

		
		/* 	PARA TRAERNOS LOS VALORES GENERALES */
			$query = "";
			$totalOt = 0;
			$totalOtAtrasadas = 0; // variable para contar todas las ordenes de trabajo
			$totalOtTerminadas = 0; // variable para contar todas las ordenes de trabajo
			$cumplimientoGeneral = 0;

			$totalOt = 0;
			$query = "SELECT count(*) AS totalOt
						FROM disponibilidad_data
						WHERE fecha_finalizacion_programada <= '$fechaHoy'
							AND (estado = 'Programada'
                					OR estado = 'Ejecutado' 
							 		OR estado = 'Cierre Lider Mtto'
							 		OR estado = 'Espera de equipo'
							 		OR estado = 'Espera de refacciones'
							 		OR estado = 'Falta mano de obra'
							 		OR estado = 'Condiciones ambientales'
							 		OR estado = 'Abierta'
							 		OR estado = 'Solic. de trabajo'
							 		OR estado = 'Terminado'
							 	)";
			$totalOt = disponibilidad_data::getAllByQuery($query);

			$query = "SELECT count(*) AS totalOtAtrasadas
						FROM disponibilidad_data
						WHERE fecha_finalizacion_programada < '$fechaHoy'
							AND (estado = 'Programada'
                					OR estado = 'Ejecutado' 
							 		OR estado = 'Cierre Lider Mtto'
							 		OR estado = 'Espera de equipo'
							 		OR estado = 'Espera de refacciones'
							 		OR estado = 'Falta mano de obra'
							 		OR estado = 'Condiciones ambientales'
							 		OR estado = 'Abierta'
							 		OR estado = 'Solic. de trabajo'
							 	)";
			$totalOtAtrasadas = disponibilidad_data::getAllByQuery($query);

			$query = "SELECT count(*) AS totalTerminadasOt
						FROM disponibilidad_data
						WHERE estado = 'Terminado' 
						AND fecha_finalizacion_programada <= '$fechaHoy'";
			$totalOtTerminadas = disponibilidad_data::getAllByQuery($query);

			###################################
			# SACANDO EL CUMPLIMIENTO GENERAL #
			###################################

			#echo "Total OT  = ".$totalOt[0]->totalOt."<br>";
			#echo "Total OT Atrasadas = ".$totalOtAtrasadas[0]->totalOtAtrasadas."<br>";
			#echo "Total OT Terminados = ".$totalOtTerminadas[0]->totalTerminadasOt;

			$cumplimientoGeneral = ( ($totalOtTerminadas[0]->totalTerminadasOt * 100) / $totalOt[0]->totalOt);
			$cumplimientoGeneral = number_format($cumplimientoGeneral, 2, '.', '');
			//echo "<br>".$cumplimientoGeneral;
		/* TERMINAN VALORES GENERALES */

		/* INICIA LA TABLA DE CUMPLIMIENTO GENERAL*/
			$atrasadasPreventivas = 0;
			$actualesPreventivas = 0;
			$futurasPreventivas = 0;
			$consulta = "";

			$subtotalPreventivas = 0;
			$subtotalCorrectivas = 0;
			$subtotalSolicitudes = 0;
			$subtotalAbiertas = 0;

			$str.="<div class='membership-pricing-table'>";
						$str.="<div class='row'>";
							$str.="<input class='hidden form-control'name='cumplimientoGeneral' id='cumplimientoGeneral' value='".$cumplimientoGeneral."'>";
							$str.="<input class='hidden form-control'name='totalOtAtrasadas' id='totalOtAtrasadas' value='".$totalOtAtrasadas[0]->totalOtAtrasadas."'>";
							$str.="<div id='chart_div' class='col-sm-2'></div>";
							$str.="<div id='lideres_top_atrasadas' class='col-sm-5'></div>";
							$str.="<div id='cumplimiento_semana' class='col-sm-5'></div>";
						$str.="</div>";


						$str.="<br><br><div class='row '>";
							$str.="<div class='col-sm-12' style='text-align: center !important;'>";
								$str.="<button class='btn btn-success btn-sm mostrar' > <i class='fa fa-level-down' aria-hidden='true'></i> Detalles </button>";
								$str.="<button class='btn btn-default ocultar hidden' > <i class='fa fa-level-up' aria-hidden='true'></i> Detalles</button>";
							$str.="</div>";
						$str.="</div><br>";

						$str.="<div class='row verDetalles hidden'>";
							$str.="<div class='col-sm-12 col-md-12 col-xs-12'>";
					            $str.="<table width='100%'>";
					                $str.="<tbody>";
						                $str.="<tr>
						                    <th>
						                    	
						                    </th>
						                    
						                	<th class='plan-header plan-header-red'>
								                <div class='pricing-plan-name'>OT ATRASADAS</div>
								                <!--div class='pricing-plan-price'>
								                    <sup> < </sup> WK ".$semana."<span></span>
								                </div-->
								            </th>
						                
							                <th class='plan-header plan-header-blue'>
							                <div class='header-plan-inner'>
							                    <div class='pricing-plan-name'>OT ACTUALES</div>
							                    <div class='pricing-plan-price'>
							                        <sup> = </sup> WK ".$semana."<span></span>
							                    </div>
							                </div>
							                </th>
						                
							                <th class='plan-header plan-header-free'>
							                	<div class='pricing-plan-name'>OT FUTURAS</div>
							                	<!--div class='pricing-plan-price'>
							                    	<sup> > </sup> WK ".$semana."<span></span>
							                	</div-->
							                </th>

							                <th class='plan-header plan-header-grisNegro'>
							                	<div class='pricing-plan-name'>OT TOTAL</div>
							                </th>
						                </tr>";

						                $consulta = "SELECT count(*) as atrasadas 
						                				FROM disponibilidad_data 
						                				WHERE tipo = 'Mant. preventivo' 
						                				AND (estado = 'Programada'
						                					OR estado = 'Ejecutado' 
													 		OR estado = 'Cierre Lider Mtto'
													 		OR estado = 'Espera de equipo'
													 		OR estado = 'Espera de refacciones'
													 		OR estado = 'Falta mano de obra'
													 		OR estado = 'Condiciones ambientales'
													 		 )
													 	AND fecha_finalizacion_programada < '$fechaHoy' ";
										//echo $consulta;
										$atrasadasPreventivas = Disponibilidad_data::getAllByQuery($consulta);

										$consulta = "SELECT count(*) as actuales
						                				FROM disponibilidad_data 
						                				WHERE tipo = 'Mant. preventivo' 
						                				AND (estado = 'Programada'
						                					OR estado = 'Ejecutado' 
													 		OR estado = 'Cierre Lider Mtto'
													 		OR estado = 'Espera de equipo'
													 		OR estado = 'Espera de refacciones'
													 		OR estado = 'Falta mano de obra'
													 		OR estado = 'Condiciones ambientales'
													 		 )
													 	AND fecha_finalizacion_programada = '$fechaHoy' ";

										$actualesPreventivas = Disponibilidad_data::getAllByQuery($consulta);
										
										$consulta = "SELECT count(*) as futuras
						                				FROM disponibilidad_data 
						                				WHERE tipo = 'Mant. preventivo' 
						                				AND (estado = 'Programada'
						                					OR estado = 'Ejecutado' 
													 		OR estado = 'Cierre Lider Mtto'
													 		OR estado = 'Espera de equipo'
													 		OR estado = 'Espera de refacciones'
													 		OR estado = 'Falta mano de obra'
													 		OR estado = 'Condiciones ambientales'
													 		 )
													 	AND fecha_finalizacion_programada > '$fechaHoy' ";

										$futurasPreventivas = Disponibilidad_data::getAllByQuery($consulta);
										
										/* -- CORRECTIVAS -- */
										$atrasadasCorrectivas = 0;
										$actualesCorrectivas = 0;
										$futurasCorrectivas = 0;
										$consulta = "SELECT count(*) as atrasadas 
						                				FROM disponibilidad_data 
						                				WHERE tipo <> 'Mant. preventivo' 
						                				AND (estado = 'Programada'
						                					OR estado = 'Ejecutado' 
													 		OR estado = 'Cierre Lider Mtto'
													 		OR estado = 'Espera de equipo'
													 		OR estado = 'Espera de refacciones'
													 		OR estado = 'Falta mano de obra'
													 		OR estado = 'Condiciones ambientales'
													 		 )
													 	AND fecha_finalizacion_programada < '$fechaHoy' ";

										$atrasadasCorrectivas = Disponibilidad_data::getAllByQuery($consulta);

										$consulta = "SELECT count(*) as actuales
						                				FROM disponibilidad_data 
						                				WHERE tipo <> 'Mant. preventivo' 
						                				AND (estado = 'Programada'
						                					OR estado = 'Ejecutado' 
													 		OR estado = 'Cierre Lider Mtto'
													 		OR estado = 'Espera de equipo'
													 		OR estado = 'Espera de refacciones'
													 		OR estado = 'Falta mano de obra'
													 		OR estado = 'Condiciones ambientales'
													 		 )
													 	AND fecha_finalizacion_programada = '$fechaHoy' ";

										$actualesCorrectivas = Disponibilidad_data::getAllByQuery($consulta);
										
										$consulta = "SELECT count(*) as futuras 
						                				FROM disponibilidad_data 
						                				WHERE tipo <> 'Mant. preventivo' 
						                				AND (estado = 'Programada'
						                					OR estado = 'Ejecutado' 
													 		OR estado = 'Cierre Lider Mtto'
													 		OR estado = 'Espera de equipo'
													 		OR estado = 'Espera de refacciones'
													 		OR estado = 'Falta mano de obra'
													 		OR estado = 'Condiciones ambientales'
													 		 )
													 	AND fecha_finalizacion_programada > '$fechaHoy' ";

										$futurasCorrectivas = Disponibilidad_data::getAllByQuery($consulta);

										/* -- SOLICITUD -- */
										$atrasadasSolicitud = 0;
										$actualesSolicitud = 0;
										$futurasSolicitud = 0;
										$consulta = "SELECT count(*) as atrasadas
						                				FROM disponibilidad_data 
						                				WHERE tipo <> 'Mant. preventivo' 
						                				AND (estado = 'Solic. de trabajo')
													 	AND fecha_finalizacion_programada < '$fechaHoy'  ";

										$atrasadasSolicitud = Disponibilidad_data::getAllByQuery($consulta);

										$consulta = "SELECT count(*) as actuales
						                				FROM disponibilidad_data 
						                				WHERE tipo <> 'Mant. preventivo' 
						                				AND (estado = 'Solic. de trabajo')
													 	AND fecha_finalizacion_programada = '$fechaHoy'  ";

										$actualesSolicitud = Disponibilidad_data::getAllByQuery($consulta);
										
										$consulta = "SELECT count(*) as futuras 
						                				FROM disponibilidad_data 
						                				WHERE tipo <> 'Mant. preventivo' 
						                				AND (estado = 'Solic. de trabajo')
													 	AND fecha_finalizacion_programada > '$fechaHoy' ";

										$futurasSolicitud = Disponibilidad_data::getAllByQuery($consulta);

										/* -- ABIERTAS -- */
										$atrasadasAbiertas = 0;
										$actualesAbiertas = 0;
										$futurasAbiertas = 0;
										$consulta = "SELECT count(*) as atrasadas 
						                				FROM disponibilidad_data 
						                				WHERE tipo <> 'Mant. preventivo' 
						                				AND (estado = 'Abierta')
													 	AND fecha_finalizacion_programada < '$fechaHoy' ";

										$atrasadasAbiertas = Disponibilidad_data::getAllByQuery($consulta);

										$consulta = "SELECT count(*) as actuales
						                				FROM disponibilidad_data
						                				WHERE tipo <> 'Mant. preventivo' 
						                				AND (estado = 'Abierta')
													 	AND fecha_finalizacion_programada = '$fechaHoy' ";

										$actualesAbiertas = Disponibilidad_data::getAllByQuery($consulta);
										
										$consulta = "SELECT count(*) as futuras
						                				FROM disponibilidad_data 
						                				WHERE tipo <> 'Mant. preventivo' 
						                				AND (estado = 'Abierta')
													 	AND fecha_finalizacion_programada > '$fechaHoy' ";

										$futurasAbiertas = Disponibilidad_data::getAllByQuery($consulta);

										$subtotalAtrasadas = 0;
										$subtotalActuales = 0;
										$subtotalFuturas = 0;

										$subtotalAtrasadas = $atrasadasPreventivas[0]->atrasadas + $atrasadasCorrectivas[0]->atrasadas + $atrasadasSolicitud[0]->atrasadas + $atrasadasAbiertas[0]->atrasadas;
										$subtotalActuales = $actualesPreventivas[0]->actuales + $actualesCorrectivas[0]->actuales + $actualesSolicitud[0]->actuales + $actualesAbiertas[0]->actuales;
										$subtotalFuturas = $futurasPreventivas[0]->futuras + $futurasCorrectivas[0]->futuras + $futurasSolicitud[0]->futuras + $futurasAbiertas[0]->futuras;

										// HACIENDO SUMAS DE LOS SUBTOTALES
										$subtotalPreventivas = $atrasadasPreventivas[0]->atrasadas + $actualesPreventivas[0]->actuales + $futurasPreventivas[0]->futuras; 

										$subtotalCorrectivas = $atrasadasCorrectivas[0]->atrasadas + $actualesCorrectivas[0]->actuales + $futurasCorrectivas[0]->futuras;

										$subtotalSolicitudes = $atrasadasSolicitud[0]->atrasadas + $actualesSolicitud[0]->actuales + $futurasSolicitud[0]->futuras;

										$subtotalAbiertas = $atrasadasAbiertas[0]->atrasadas + $actualesAbiertas[0]->actuales + $futurasAbiertas[0]->futuras; 
										// TERMINAN LAS SUMAS

						                $str.="<tr>
						                    <td>Mantenimiento Preventivo</td>
						                    <td>".$atrasadasPreventivas[0]->atrasadas."</td>
						                    <td>".$actualesPreventivas[0]->actuales."</td>
						                    <td>".$futurasPreventivas[0]->futuras."</td>
						                    <td class='verde-liga-mx'><b>".$subtotalPreventivas."</b></td>
						                </tr>";
						                $str.="<tr>
						                    <td>Mantenimiento Correctivo</td>
						                    <td>".$atrasadasCorrectivas[0]->atrasadas."</td>
						                    <td>".$actualesCorrectivas[0]->actuales."</td>
						                    <td>".$futurasCorrectivas[0]->futuras."</td>
						                    <td class='verde-liga-mx'><b>".$subtotalCorrectivas."</b></td>
						                </tr>";
						                $str.="<tr>
						                    <td>Solicitudes de Trabajo</td>
						                    <td>".$atrasadasSolicitud[0]->atrasadas."</td>
						                    <td>".$actualesSolicitud[0]->actuales."</td>
						                    <td>".$futurasSolicitud[0]->futuras."</td>
						                    <td class='verde-liga-mx'> <b>".$subtotalSolicitudes."</b></td>
						                </tr>";
						                $str.="<tr>
						                    <td>Órdenes abiertas</td>
						                    <td>".$atrasadasAbiertas[0]->atrasadas."</td>
						                    <td>".$actualesAbiertas[0]->actuales."</td>
						                    <td>".$futurasAbiertas[0]->futuras."</td>
						                    <td class='verde-liga-mx'><b>".$subtotalAbiertas."</b></td>
						                </tr>";
						                $str.="<tr style='background:gold;'>
						                    <td style='text-align:center;' colspan='5'><h4>LÍDERES</h4></td>
						                </tr>";

						                foreach ($lideres as $lider) 
						                {
						                	$atrasadasLider = 0;
						                	$atrasadasPreventivasLider = 0;
											$actualesPreventivasLider = 0;
											$futurasPreventivasLider = 0;

											$subtotalPreventivasLider = 0;
											$subtotalCorrrectivasLider = 0;
											$subtotalSolicitudesLider = 0;
											$subtotalAbiertasLider = 0;

											//echo $cumplimiento_lider."<br>";

											$consulta = "SELECT count(*) AS atrasadas
														FROM disponibilidad_data
														WHERE fecha_finalizacion_programada < '$fechaHoy'
															AND (estado = 'Programada'
								                					OR estado = 'Ejecutado' 
															 		OR estado = 'Cierre Lider Mtto'
															 		OR estado = 'Espera de equipo'
															 		OR estado = 'Espera de refacciones'
															 		OR estado = 'Falta mano de obra'
															 		OR estado = 'Condiciones ambientales'
															 		OR estado = 'Abierta'
															 		OR estado = 'Solic. de trabajo'
															 	)
															 	AND responsable = $lider";
											$atrasadasLider = Disponibilidad_data::getAllByQuery($consulta);

											$consulta = "";
						                	$consulta = "SELECT count(*) as atrasadas 
						                				FROM disponibilidad_data
						                				WHERE tipo = 'Mant. preventivo' 
						                				AND (estado = 'Programada'
						                					OR estado = 'Ejecutado' 
													 		OR estado = 'Cierre Lider Mtto'
													 		OR estado = 'Espera de equipo'
													 		OR estado = 'Espera de refacciones'
													 		OR estado = 'Falta mano de obra'
													 		OR estado = 'Condiciones ambientales'
													 		 )
													 	
													 	AND responsable = $lider
													 	AND fecha_finalizacion_programada < '$fechaHoy' ";

											$atrasadasPreventivasLider = Disponibilidad_data::getAllByQuery($consulta);

											$consulta = "SELECT count(*) as actuales 
							                				FROM disponibilidad_data
							                				WHERE tipo = 'Mant. preventivo' 
							                				AND (estado = 'Programada'
							                					OR estado = 'Ejecutado' 
														 		OR estado = 'Cierre Lider Mtto'
														 		OR estado = 'Espera de equipo'
														 		OR estado = 'Espera de refacciones'
														 		OR estado = 'Falta mano de obra'
														 		OR estado = 'Condiciones ambientales'
														 		 )
														 	AND responsable = $lider
														 	AND fecha_finalizacion_programada = '$fechaHoy' ";

											$actualesPreventivasLider = Disponibilidad_data::getAllByQuery($consulta);
											
											$consulta = "SELECT count(*) as futuras 
							                				FROM disponibilidad_data
							                				WHERE tipo = 'Mant. preventivo' 
							                				AND (estado = 'Programada'
							                					OR estado = 'Ejecutado' 
														 		OR estado = 'Cierre Lider Mtto'
														 		OR estado = 'Espera de equipo'
														 		OR estado = 'Espera de refacciones'
														 		OR estado = 'Falta mano de obra'
														 		OR estado = 'Condiciones ambientales'
														 		 )
														 	AND responsable = $lider
														 	AND fecha_finalizacion_programada > '$fechaHoy' ";

											$futurasPreventivasLider = Disponibilidad_data::getAllByQuery($consulta);
											
											/* -- CORRECTIVAS -- */
											$atrasadasCorrectivasLider = 0;
											$actualesCorrectivasLider = 0;
											$futurasCorrectivasLider = 0;
											$consulta = "SELECT count(*) as atrasadas 
							                				FROM disponibilidad_data 
							                				WHERE tipo <> 'Mant. preventivo' 
							                				AND (estado = 'Programada'
							                					OR estado = 'Ejecutado' 
														 		OR estado = 'Cierre Lider Mtto'
														 		OR estado = 'Espera de equipo'
														 		OR estado = 'Espera de refacciones'
														 		OR estado = 'Falta mano de obra'
														 		OR estado = 'Condiciones ambientales'
														 		 )
														 	AND responsable = $lider
														 	AND fecha_finalizacion_programada < '$fechaHoy' ";

											$atrasadasCorrectivasLider = Disponibilidad_data::getAllByQuery($consulta);

											$consulta = "SELECT count(*) as actuales 
							                				FROM disponibilidad_data
							                				WHERE tipo <> 'Mant. preventivo' 
							                				AND (estado = 'Programada'
							                					OR estado = 'Ejecutado' 
														 		OR estado = 'Cierre Lider Mtto'
														 		OR estado = 'Espera de equipo'
														 		OR estado = 'Espera de refacciones'
														 		OR estado = 'Falta mano de obra'
														 		OR estado = 'Condiciones ambientales'
														 		 )
														 	AND responsable = $lider
														 	AND fecha_finalizacion_programada = '$fechaHoy' ";

											$actualesCorrectivasLider = Disponibilidad_data::getAllByQuery($consulta);
											
											$consulta = "SELECT count(*) as futuras 
							                				FROM disponibilidad_data
							                				WHERE tipo <> 'Mant. preventivo' 
							                				AND (estado = 'Programada'
							                					OR estado = 'Ejecutado' 
														 		OR estado = 'Cierre Lider Mtto'
														 		OR estado = 'Espera de equipo'
														 		OR estado = 'Espera de refacciones'
														 		OR estado = 'Falta mano de obra'
														 		OR estado = 'Condiciones ambientales'
														 		 )
														 	AND responsable = $lider
														 	AND fecha_finalizacion_programada > '$fechaHoy' ";

											$futurasCorrectivasLider = Disponibilidad_data::getAllByQuery($consulta);

											/* -- SOLICITUD -- */
											$atrasadasSolicitudLider = 0;
											$actualesSolicitudLider = 0;
											$futurasSolicitudLider = 0;
											$consulta = "SELECT count(*) as atrasadas 
							                				FROM disponibilidad_data 
							                				WHERE tipo <> 'Mant. preventivo' 
							                				AND (estado = 'Solic. de trabajo')
														 	AND responsable = $lider
														 	AND fecha_finalizacion_programada < '$fechaHoy' ";

											$atrasadasSolicitudLider = Disponibilidad_data::getAllByQuery($consulta);

											$consulta = "SELECT count(*) as actuales
							                				FROM disponibilidad_data
							                				WHERE tipo <> 'Mant. preventivo' 
							                				AND (estado = 'Solic. de trabajo')
														 	AND responsable = $lider
														 	AND fecha_finalizacion_programada = '$fechaHoy' ";

											$actualesSolicitudLider = Disponibilidad_data::getAllByQuery($consulta);
											
											$consulta = "SELECT count(*) as futuras
							                				FROM disponibilidad_data
							                				WHERE tipo <> 'Mant. preventivo' 
							                				AND (estado = 'Solic. de trabajo')
														 	AND responsable = $lider
														 	AND fecha_finalizacion_programada > '$fechaHoy' ";

											$futurasSolicitudLider = Disponibilidad_data::getAllByQuery($consulta);

											/* -- ABIERTAS -- */
											$atrasadasAbiertasLider = 0;
											$actualesAbiertasLider = 0;
											$futurasAbiertasLider = 0;
											$consulta = "SELECT count(*) as atrasadas 
							                				FROM disponibilidad_data
							                				WHERE tipo <> 'Mant. preventivo' 
							                				AND (estado = 'Abierta')
														 	AND responsable = $lider
														 	AND fecha_finalizacion_programada < '$fechaHoy' ";

											$atrasadasAbiertasLider = Disponibilidad_data::getAllByQuery($consulta);

											$consulta = "SELECT count(*) as actuales
							                				FROM disponibilidad_data
							                				WHERE tipo <> 'Mant. preventivo' 
							                				AND (estado = 'Abierta')
														 	AND responsable = $lider
														 	AND fecha_finalizacion_programada = '$fechaHoy' ";

											$actualesAbiertasLider = Disponibilidad_data::getAllByQuery($consulta);
											
											$consulta = "SELECT count(*) as futuras 
							                				FROM disponibilidad_data
							                				WHERE tipo <> 'Mant. preventivo' 
							                				AND (estado = 'Abierta')
														 	AND responsable = $lider
														 	AND fecha_finalizacion_programada > '$fechaHoy' ";

											$futurasAbiertasLider = Disponibilidad_data::getAllByQuery($consulta);

											#------------------------------------
											$totalOt_lider = 0;
											$totalOtTerminadas_lider = 0;
											$cumplimiento_lider = 0;

											$totalOt_lider_temporal = 0;

											$query = "SELECT count(*) AS totalOt
														FROM disponibilidad_data
														WHERE fecha_finalizacion_programada <= '$fechaHoy'
															AND (estado = 'Programada'
								                					OR estado = 'Ejecutado' 
															 		OR estado = 'Cierre Lider Mtto'
															 		OR estado = 'Espera de equipo'
															 		OR estado = 'Espera de refacciones'
															 		OR estado = 'Falta mano de obra'
															 		OR estado = 'Condiciones ambientales'
															 		OR estado = 'Abierta'
															 		OR estado = 'Solic. de trabajo'
															 		OR estado = 'Terminado'
															 	)
															 	AND responsable = $lider";

											$totalOt_lider = Disponibilidad_data::getAllByQuery($query);

											$query = "SELECT count(*) AS totalTerminadasOt
														FROM disponibilidad_data
														WHERE estado = 'Terminado' 
														AND fecha_finalizacion_programada <= '$fechaHoy'
														AND responsable = $lider";

											$totalOtTerminadas_lider = Disponibilidad_data::getAllByQuery($query);

											$totalOt_lider_temporal = $totalOt_lider[0]->totalOt;
											if($totalOt_lider_temporal > 0)
											{
												$cumplimiento_lider = ( ($totalOtTerminadas_lider[0]->totalTerminadasOt * 100) / $totalOt_lider[0]->totalOt);
												$cumplimiento_lider = round($cumplimiento_lider, 2);
											}
											else
											{
												$cumplimiento_lider = 100;
											}
											


											/*echo "cumplimiento:".$cumplimiento_lider;
											echo "cumplimiento:".$cumplimiento_lider;*/
											#------------------------------------

											// SUBTOTALES PARA LIDER
											$subtotalPreventivasLider = $atrasadasPreventivasLider[0]->atrasadas + $actualesPreventivasLider[0]->actuales + $futurasPreventivasLider[0]->futuras;

											$subtotalCorrectivasLider = $atrasadasCorrectivasLider[0]->atrasadas + $actualesCorrectivasLider[0]->actuales + $futurasCorrectivasLider[0]->futuras;

											$subtotalSolicitudesLider = $atrasadasSolicitudLider[0]->atrasadas + $actualesSolicitudLider[0]->actuales + $futurasSolicitudLider[0]->futuras;

											$subtotalAbiertasLider = $atrasadasAbiertasLider[0]->atrasadas + $actualesAbiertasLider[0]->actuales + $futurasAbiertasLider[0]->futuras;
											// ---------------------

						                	$nombre = "";
						                	if($lider == 41185)
						                	{
						                		$nombre = "ORFANEL RENDON";
						                	}
						                	if ($lider == 239) 
						                	{
						                		$nombre = "HUMBERTO CERVANTES";	
						                	}
						                	if ($lider == 14993) 
						                	{
						                		$nombre = "MIGUEL ANGEL TADEO";	
						                	}
						                	if ($lider == 15113) 
						                	{
						                		$nombre = "JOSE ANTONIO VIRGEN";	
						                	}
						                	$str.="<tr>
							                    <td style='text-align:left;' colspan='5'><i class='glyphicon glyphicon-user icon-white'></i><b> ".$nombre."</b>
							                    	<input class='form-control hidden lider_".$lider."' name='lider_".$lider."' id='lider_".$lider."' value='".$atrasadasLider[0]->atrasadas."'>
							                    	<input class='form-control hidden totalCumplimiento_".$lider."' name='totalCumplimiento_".$lider."' id='totalCumplimiento_".$lider."' value='".$cumplimiento_lider."'>
							                    </td>
							                </tr>";
						                	$str.="<tr>
							                    <td>Mantenimiento Preventivo</td>
							                    <td>".$atrasadasPreventivasLider[0]->atrasadas."</td>
						                    	<td>".$actualesPreventivasLider[0]->actuales."</td>
						                    	<td>".$futurasPreventivasLider[0]->futuras."</td>
						                    	<td class='verde-liga-mx'><b>".$subtotalPreventivasLider."</b></td>
							                </tr>";
							                $str.="<tr>
							                    <td>Mantenimiento Correctivo</td>
							                    <td>".$atrasadasCorrectivasLider[0]->atrasadas."</td>
						                    	<td>".$actualesCorrectivasLider[0]->actuales."</td>
						                    	<td>".$futurasCorrectivasLider[0]->futuras."</td>
						                    	<td class='verde-liga-mx'><b>".$subtotalCorrectivasLider."</b></td>
							                </tr>";
							                $str.="<tr>
							                    <td>Solicitudes de Trabajo</td>
							                    <td>".$atrasadasSolicitudLider[0]->atrasadas."</td>
						                    	<td>".$actualesSolicitudLider[0]->actuales."</td>
						                    	<td>".$futurasSolicitudLider[0]->futuras."</td>
						                    	<td class='verde-liga-mx'><b>".$subtotalSolicitudesLider."</b></td>
							                </tr>";
							                $str.="<tr>
							                    <td>Órdenes abiertas</td>
							                    <td>".$atrasadasAbiertasLider[0]->atrasadas."</td>
						                    	<td>".$actualesAbiertasLider[0]->actuales."</td>
						                    	<td>".$futurasAbiertasLider[0]->futuras."</td>
						                    	<td class='verde-liga-mx'><b>".$subtotalAbiertasLider."</b></td>
							                </tr>";
						                }

					            $str.="</tbody>";
					        $str.="</table><br>";
					    $str.="</div>"; 
		    $str.="</div>";
        $str.="</div>";

					

		/* TERMINA TABLA DE CUMPLIMIENTO GENERAL*/
	}
}
else
{
	$str.="NO DATA";
}


echo $str;


?>
<style type="text/css">



.membership-pricing-table table .icon-no,.membership-pricing-table table .icon-yes {
    font-size: 22px
}

.membership-pricing-table table .icon-no {
    color: #a93717
}

.membership-pricing-table table .icon-yes {
    color: #209e61
}

.membership-pricing-table table .plan-header {
    text-align: center;
    font-size: 48px;
    border: 1px solid #e2e2e2;
    padding: 25px 0
}

.membership-pricing-table table .plan-header-free {
    background-color: #eee;
    color: #555
}

.membership-pricing-table table .plan-header-blue {
    color: #fff;
    background-color: #61a1d1;
    border-color: #3989c6
}

.membership-pricing-table table .plan-header-grisNegro {
    color: #fff;
    background-color: #182347;
    border-color: #3989c6
}

.verde-liga-mx{
	background-color: #DFE6C7 !important;
	border-color: #DFE6C7 !important;
}

.membership-pricing-table table .plan-header-red {
    color: #fff;
    background-color: #d9534f;
    border-color: #a94442
}

.membership-pricing-table table .plan-header-standard {
    color: #fff;
    background-color: #ff9317;
    border-color: #e37900
}

.membership-pricing-table table td {
    text-align: center;
    width: 15%;
    padding: 7px 10px;
    background-color: #fafafa;
    font-size: 14px;
    -webkit-box-shadow: 0 1px 0 #fff inset;
    box-shadow: 0 1px 0 #fff inset
}

.membership-pricing-table table,.membership-pricing-table table td {
    border: 1px solid #ebebeb
}

.membership-pricing-table table tr td:first-child {
    background-color: transparent;
    text-align: right;
    width: 24%
}

.membership-pricing-table table tr td:nth-child(5) {
    background-color: #FFF
}

.membership-pricing-table table tr:first-child td,.membership-pricing-table table tr:nth-child(2) td {
    -webkit-box-shadow: none;
    box-shadow: none
}

.membership-pricing-table table tr:first-child th:first-child {
    border-top-color: transparent;
    border-left-color: transparent;
    border-right-color: #e2e2e2
}

.membership-pricing-table table tr:first-child th .pricing-plan-name {
    font-size: 22px
}

.membership-pricing-table table tr:first-child th .pricing-plan-price {
    line-height: 35px
}

.membership-pricing-table table tr:first-child th .pricing-plan-price>sup {
    font-size: 45%
}

.membership-pricing-table table tr:first-child th .pricing-plan-price>span {
    font-size: 30%
}

.membership-pricing-table table tr:first-child th .pricing-plan-period {
    margin-top: -7px;
    font-size: 25%
}

.membership-pricing-table table .header-plan-inner {
    position: relative
}

.membership-pricing-table table .recommended-plan-ribbon {
    box-sizing: content-box;
    background-color: #f0ad4e;
    color: #FFF;
    position: absolute;
    padding: 3px 6px;
    font-size: 11px!important;
    font-weight: 500;
    left: -6px;
    top: -22px;
    z-index: 99;
    width: 100%;
    -webkit-box-shadow: 0 -1px #d9534f inset;
    box-shadow: 0 -1px #d9534f inset;
    text-shadow: 0 -1px #d9534f
}

.membership-pricing-table table .recommended-plan-ribbon:before {
    border: solid;
    border-color: #d9534f transparent;
    border-width: 6px 0 0 6px;
    bottom: -5px;
    content: "";
    left: 0;
    position: absolute;
    z-index: 90
}

.membership-pricing-table table .recommended-plan-ribbon:after {
    border: solid;
    border-color: #d9534f transparent;
    border-width: 6px 6px 0 0;
    bottom: -5px;
    content: "";
    right: 0;
    position: absolute;
    z-index: 90
}

.membership-pricing-table table .plan-head {
    box-sizing: content-box;
    background-color: #ff9c00;
    border: 1px solid #cf7300;
    position: absolute;
    top: -33px;
    left: -1px;
    height: 30px;
    width: 100%;
    border-bottom: none
}
</style>



<script type="text/javascript">



	$(document).ready(function() 
	{
		$(".mostrar").on("click", function(event)
		{
			event.preventDefault();
			$(".verDetalles").removeClass("hidden");
			$(".ocultar").removeClass("hidden");
			$(".mostrar").addClass("hidden");
		});

		$(".ocultar").on("click", function(event)
		{
			event.preventDefault();
			$(".verDetalles").addClass("hidden");
			$(".ocultar").addClass("hidden");
			$(".mostrar").removeClass("hidden");

		});



		
	});

	



		google.charts.load("current",  {'packages':['gauge','corechart','bar']});
	    google.charts.setOnLoadCallback(drawChart);
	    google.charts.setOnLoadCallback(draw_cumplimiento_atrasada);
	    google.charts.setOnLoadCallback(draw_cumplimiento_semana);


      	

      	var lideres = [41185, 239,  15113, 14993];
      		

      function drawChart() 
      {
      	var cumplimientoGeneral = 0;
      		cumplimientoGeneral = $("#cumplimientoGeneral").val(); 

      		
      		cumplimientoGeneral = parseFloat(cumplimientoGeneral, 1);

        var data = new google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['% General', cumplimientoGeneral]
        ]);

        var options = {
          width: 440, height: 160,
          greenFrom: 95, greenTo: 100,
          yellowFrom:51, yellowTo: 94,
          redFrom: 0, redTo: 50
          
          //minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    	
    	

	    function draw_cumplimiento_atrasada()
		{

			var constructor = [['',  'Atrasadas']];
			var cuentaatrasadas = 0;
			$.each(lideres, function( key, value ) 
			{
				var lider = value;
					//console.log(lider);
				var nombre = "";
		
				var numAtrasadas = 0;

				$( ".lider_"+lider).each(function() 
				{
					numAtrasadas = $(this).val();
				   	numAtrasadas = parseInt(numAtrasadas);
				   
				});

				if(lider == 41185)
				{
					nombre = "MECA";
				}
				if(lider == 239)
				{
					nombre = "HID";
				}
				if(lider == 15113)
				{
					nombre = "PDS";
				}
				if(lider == 14993)
				{
					nombre = "PLA";
				}

				

				constructor.push([nombre, numAtrasadas]);
				cuentaatrasadas = cuentaatrasadas + numAtrasadas;
			});
			var data = new google.visualization.arrayToDataTable(constructor);

	        var options = {
		            chart: {
		            //title: 'Nature Sweet',
		            subtitle: cuentaatrasadas+' OT atrasadas por departamento'

		          },
		          bars: 'vertical',
		           colors: [ '#ec971f'],
		           height: 160,
		           vAxis: {
		                    //title: '% de disponibilidad',
		                    //format: '#\'%\''
		                    format:"decimal"

		                    } // Required for Material Bar Charts.
		        };

	        var chart = new google.charts.Bar(document.getElementById('lideres_top_atrasadas'));

	        chart.draw(data, google.charts.Bar.convertOptions(options));

		}

	    function draw_cumplimiento_semana()
		{

			var constructor_cumplimiento = [['',  '%', {role:'annotation'}]];
			$.each(lideres, function( key, value ) 
			{
				var lider = value;
				var nombre = "";
					porcentajeSemanal = 0;
					//promedio = 0;

				$( ".totalCumplimiento_"+lider).each(function() 
				{
				   porcentajeSemanal = $(".totalCumplimiento_"+lider).val();
				   //console.log(porcentajeSemanal);
				   
				});
				porcentajeSemanal = parseFloat(porcentajeSemanal, 1);

				if(lider == 41185)
				{
					nombre = "MECA";
				}
				if(lider == 239)
				{
					nombre = "HID";
				}
				if(lider == 15113)
				{
					nombre = "PDS";
				}
				if(lider == 14993)
				{
					nombre = "PLA";
				}

				constructor_cumplimiento.push([nombre + " " +porcentajeSemanal, porcentajeSemanal, porcentajeSemanal]);
			});

			var data = new google.visualization.arrayToDataTable(constructor_cumplimiento);

	        var options = {
		            chart: {
		            //title: 'Nature Sweet',
		            subtitle: '% Cumplimiento general por departamento'

		          },
		          bars: 'vertical',
		           colors: ['#449d44', '#ec971f'],
		           height: 160,
		           vAxis: {
		                    //title: '% de disponibilidad',
		                    //format: '#\'%\''
		                    format:"decimal"

		                    } // Required for Material Bar Charts.
		        };

	        var chart = new google.charts.Bar(document.getElementById('cumplimiento_semana'));

	        chart.draw(data, google.charts.Bar.convertOptions(options));

		}
		
</script>
