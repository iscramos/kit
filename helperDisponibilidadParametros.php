<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_GET['param']) && ($_SESSION["type"]==1 || $_SESSION["type"]==6 || $_SESSION["type"]==7)) // para el admimistrador
{	
	$mes = $_GET['mes'];
	$ano = $_GET['ano'];
	$param = $_GET['param'];
	$nombreMes = $_GET['nombreMes'];

	//echo $mes;

	
	function getMinutes($fecha1, $fecha2)
	{
	    $fecha1 = str_replace('/', '-', $fecha1);
	    $fecha2 = str_replace('/', '-', $fecha2);
	    $fecha1 = strtotime($fecha1);
	    $fecha2 = strtotime($fecha2);
	    return round( (($fecha2 - $fecha1) / 60) / 60, 1); //convirtiendo a horas
	}

	$weeks = null;
	$weeks = Calendario_nature::getAllMesCount($mes);
	$weeks = $weeks[0]->weeks;
 
	if($param == "FAMILIA") // PARA LOS TUTORES QUE ESTÁN EN EL PLANTEL
	{
		
		$fam = $_GET['fam'];
		//echo $fam;
		//$mps = Ordenesots::getAllMpByMesAnoFamilia($mes, $ano, $fam);
		$equipos = activos_equipos::getAllEquiposFamilia($fam);
		//print_r($equipos);
		$str.=" <br> 
				<h4 id='tituloFamilia'> <i class='fa fa-angle-double-right' aria-hidden='true'></i> AREA: ".$fam." </h4> 
				<table class='table table-bordered table-condensed dataTables_wrapper jambo_table bulk_action paginar' id='original' style='font-size: 10px;'>";

			$str.="<thead >
					<tr>";
				$str.="<th  class='hidden' >#</th> 
						<th >EQUIPO</th>
						<th class='hidden'>A</th>
						<th class='hidden'>B</th>
						<th class='hidden'>C</th>
						<th class='hidden'>D</th>
						<th class='hidden'>E</th>
						<th class='hidden'>F</th>
						<th>A</th>
						<th>B</th>
						<th>C</th>
						<th>D</th>
						<th>E</th>
						<th>F</th>

						<th class='hidden' >IDEAL TOTAL TIME MP</th>
						<th >REAL TOTAL TIME MP</th>
						<th class='hidden'>EXTRA TIME MP</th>
						<th class='hidden'>FAILS FOR EXTRA TIME MP</th>
						<th class='hidden'>MTTR EXTRA TIME MP</th>
						
						<th >TIME TO REPAIR</th>
						<th class='hidden'>TOTAL TIME TO REPAIR</th>
						<th class='hidden'>REAL-TIME OPERATION</th>
						<th class='hidden'>FAILS</th>
						<th >TOTAL FAILS</th>
						<th class=''>MIDDLE TIME TO REPAIR</th>
						<th class=''>MIDDLE TIME BEFORE FAILURE</th>
						<th >DISPONIBILITY</th>
						<th >ACTION</th>
						";
			$str.="</tr>
			</thead>
			<tbody>";
			$i=1;
			//print_r($mps);
			foreach ($equipos as $equipo) 
			{
				$str.="<tr class='".$equipo->familia."'>";
					$str.="<td  class='spec hidden'>$i</td>";
					$str.="<td>".$equipo->nombre_equipo."</td>";
					
					$idealA = null;
					$idealB = null;
					$idealC = null;
					$idealD = null;
					$idealE = null;
					$idealF = null;

					$realA = null;
					$realB = null;
					$realC = null;
					$realD = null;
					$realE = null;
					$realF = null;

					$idealTotalTimeMp = 0;
					$realTotalTimeMp = 0;

					$tiempoIdeal = MpIdeales::getAllInnerActivos($equipo->nombre_equipo, $mes, $ano);
					//print_r($tiempoIdeal);

					if(empty($tiempoIdeal))
					{
						$str.="<td class='idealA hidden'>
								<button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal A'  >0</button>
							</td>";
						$str.="<td class='idealB hidden'>
								<button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal B'  >0</button>
							</td>";
						$str.="<td class='idealC hidden'>
								<button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal C'  >0</button>
							</td>";
						$str.="<td class='idealD hidden'>
								<button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal D'  >0</button>
							</td>";
						$str.="<td class='idealE hidden'>
								<button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal E'  >0</button>
							</td>";
						$str.="<td class='idealF hidden'>
								<button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal F'  >0</button>
							</td>";
					}
					else
					{
						foreach ($tiempoIdeal as $ideal) 
						{
							$idealA = $ideal->A;
							$idealB = $ideal->B;
							$idealC = $ideal->C;
							$idealD = $ideal->D;
							$idealE = $ideal->E;
							$idealF = $ideal->F;
							//echo $ideal->A."<br>";
							$str.="<td class='idealA hidden'>
									<button type='button ' class='btn btn-success btn-circle btn-sm' title='MP ideal A'  >".$idealA."</button>
								</td>";
							$str.="<td class='idealB hidden'>
									<button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal B'  >".$idealB."</button>
								</td>";
							$str.="<td class='idealC hidden'>
									<button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal C'  >".$idealC."</button>
								</td>";
							$str.="<td class='idealD hidden'>
									<button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal D'  >".$idealD."</button>
								</td>";
							$str.="<td class='idealE hidden'>
									<button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal E'  >".$idealE."</button>
								</td>";
							$str.="<td class='idealF hidden'>
									<button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal F'  >".$idealF."</button>
								</td>";
						}
						//$idealTotalTimeMp = $idealA + $idealB + $idealC + $idealD + $idealE + $idealF;
						//echo $idealTotalTimeMp;
					}

					$ordenesmp = Ordenesots::getAllMpByMesAnoEquipo($mes, $ano, $equipo->nombre_equipo);

					$encuentraA = null;
					$encuentraB = null;
					$encuentraC = null;
					$encuentraD = null;
					$encuentraE = null;
					$encuentraF = null;
					
					if(empty($ordenesmp))
					{ 
						$str.="<td class='realA'>
							<button class='btn btn-default btn-circle btn-sm' title='MP real A'  >0</button>
						</td>";
						$str.="<td class='realB'>
							<button class='btn btn-default btn-circle btn-sm' title='MP real B'  >0</button>
						</td>";
						$str.="<td class='realC'>
							<button class='btn btn-default btn-circle btn-sm' title='MP real C'  >0</button>
						</td>";
						$str.="<td class='realD'>
							<button class='btn btn-default btn-circle btn-sm' title='MP real D'  >0</button>
						</td>";
						$str.="<td class='realE'>
							<button class='btn btn-default btn-circle btn-sm' title='MP real E'  >0</button>
						</td>";
						$str.="<td class='realF'>
							<button class='btn btn-default btn-circle btn-sm' title='MP real F'  >0</button>
						</td>";
					}
					else
					{
						foreach ($ordenesmp as $ordenmp) 
						{
							$findA = stripos($ordenmp->descripcion, "TIPO \"A\"");
							if ($findA !== false) 
							{
								//$realA = round(($ordenmp->tiempoReal) / 60);

								//$encuentraA = 1;
								/*echo $equipo->nombre_equipo."->".$ordenmp->fecha_inicio."..".$ordenmp->fecha_finalizacion."<br>";*/
								if($ordenmp->fecha_inicio == "")
								{
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									if($ordenmp->fecha_inicio_programada > $fechaHoy)
									{
										$realA = 0;
									}
									else
									{
										$realA = getMinutes($ordenmp->fecha_inicio_programada, $fechaHoy);
									}
									
									
									$encuentraA = 1;
								}
								else if($ordenmp->fecha_finalizacion == "" && $ordenmp->fecha_inicio != "")
								{
									
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									$realA = getMinutes($ordenmp->fecha_inicio, $fechaHoy);
									
									$encuentraA = 1;
									
								}
								else
								{
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									$realA = getMinutes($ordenmp->fecha_inicio, $ordenmp->fecha_finalizacion);

									$encuentraA = 1;
								}
								//echo $realA;
							}

							$findB = stripos($ordenmp->descripcion, "TIPO \"B\"");
							if ($findB !== false) 
							{

								if($ordenmp->fecha_inicio == "")
								{
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									if($ordenmp->fecha_inicio_programada > $fechaHoy)
									{
										$realB = 0;
									}
									else
									{
										$realB = getMinutes($ordenmp->fecha_inicio_programada, $fechaHoy);
									}
									
									$encuentraB = 1;
								}
								else if($ordenmp->fecha_finalizacion == "" && $ordenmp->fecha_inicio != "")
								{
									
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									$realB = getMinutes($ordenmp->fecha_inicio, $fechaHoy);
									
									$encuentraB = 1;
									
								}
								else
								{
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									$realB = getMinutes($ordenmp->fecha_inicio, $ordenmp->fecha_finalizacion);

									$encuentraB = 1;
								}
							}

							$findC = stripos($ordenmp->descripcion, "TIPO \"C\"");
							if ($findC !== false) 
							{
								if($ordenmp->fecha_inicio == "")
								{
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									if($ordenmp->fecha_inicio_programada > $fechaHoy)
									{
										$realC = 0;
									}
									else
									{
										$realC = getMinutes($ordenmp->fecha_inicio_programada, $fechaHoy);
									}
									
									$encuentraC = 1;
								}
								else if($ordenmp->fecha_finalizacion == "" && $ordenmp->fecha_inicio != "")
								{
									
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									$realC = getMinutes($ordenmp->fecha_inicio, $fechaHoy);
									
									$encuentraC = 1;
									
								}
								else
								{
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									$realC = getMinutes($ordenmp->fecha_inicio, $ordenmp->fecha_finalizacion);

									$encuentraC = 1;
								}
							}

							$findD = stripos($ordenmp->descripcion, "TIPO \"D\"");
							if ($findD !== false) 
							{
								if($ordenmp->fecha_inicio == "")
								{
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									if($ordenmp->fecha_inicio_programada > $fechaHoy)
									{
										$realD = 0;
									}
									else
									{
										$realD = getMinutes($ordenmp->fecha_inicio_programada, $fechaHoy);
									};
									
									$encuentraD = 1;
								}
								else if($ordenmp->fecha_finalizacion == "" && $ordenmp->fecha_inicio != "")
								{
									
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									$realD = getMinutes($ordenmp->fecha_inicio, $fechaHoy);
									
									$encuentraD = 1;
									
								}
								else
								{
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									$realD = getMinutes($ordenmp->fecha_inicio, $ordenmp->fecha_finalizacion);

									$encuentraD = 1;
								}
							}

							$findE = stripos($ordenmp->descripcion, "TIPO \"E\"");
							if ($findE !== false) 
							{
								if($ordenmp->fecha_inicio == "")
								{
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									if($ordenmp->fecha_inicio_programada > $fechaHoy)
									{
										$realE = 0;
									}
									else
									{
										$realE = getMinutes($ordenmp->fecha_inicio_programada, $fechaHoy);
									}
								}
								else if($ordenmp->fecha_finalizacion == "" && $ordenmp->fecha_inicio != "")
								{
									
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									$realE = getMinutes($ordenmp->fecha_inicio, $fechaHoy);
									
									$encuentraE = 1;
									
								}
								else
								{
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									$realE = getMinutes($ordenmp->fecha_inicio, $ordenmp->fecha_finalizacion);

									$encuentraE = 1;
								}
							}

							$findF = stripos($ordenmp->descripcion, "TIPO \"F\"");
							if ($findF !== false) 
							{
								if($ordenmp->fecha_inicio == "")
								{
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									if($ordenmp->fecha_inicio_programada > $fechaHoy)
									{
										$realF = 0;
									}
									else
									{
										$realF = getMinutes($ordenmp->fecha_inicio_programada, $fechaHoy);
									}
									
									$encuentraF = 1;
								}
								else if($ordenmp->fecha_finalizacion == "" && $ordenmp->fecha_inicio != "")
								{
									
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									$realF = getMinutes($ordenmp->fecha_inicio, $fechaHoy);
									
									$encuentraF = 1;
									
								}
								else
								{
									$fechaHoy = null;
									$fechaHoy = date("Y-m-d H:i:s");
									$realF = getMinutes($ordenmp->fecha_inicio, $ordenmp->fecha_finalizacion);

									$encuentraF = 1;
								}
							}				
						}

						
	/*echo $equipo->nombre_equipo."-> A =".$realA." -> ". $realB ." = B".$encuentraB." D = ".$encuentraD."<br>";*/
						if($encuentraA == 1 && ($realA > $idealA) ) $str.="<td class='realA' ><button class='btn btn-danger btn-circle btn-sm' title='MP real A'  >".$realA."</button></td>";
						else if($encuentraA == 1 && ($realA <= $idealA) ) $str.="<td class='realA' ><button class='btn btn-default btn-circle btn-sm' title='MP real A'  >".$realA."</button></td>";
						else $str.="<td class='realA' ><button class='btn btn-default btn-circle btn-sm' title='MP real A'  >0</button></td>";

						if($encuentraB == 1 && ($realB > $idealB) ) $str.="<td class='realB' ><button class='btn btn-danger btn-circle btn-sm' title='MP real B'  >".$realB."</button></td>";
						else if($encuentraB == 1 && ($realB <= $idealB) ) $str.="<td class='realB' ><button class='btn btn-default btn-circle btn-sm' title='MP real B'  >".$realB."</button></td>";
						else $str.="<td class='realB' ><button class='btn btn-default btn-circle btn-sm' title='MP real B'  >0</button></td>";

						if($encuentraC == 1 && ($realC > $idealC)) $str.="<td class='realC' ><button class='btn btn-danger btn-circle btn-sm' title='MP real C'  >".$realC."</button></td>";
						else if($encuentraC == 1 && ($realC <= $idealC)) $str.="<td class='realC' ><button class='btn btn-default btn-circle btn-sm' title='MP real C'  >".$realC."</button></td>";
						else $str.="<td class='realC' ><button class='btn btn-default btn-circle btn-sm' title='MP real C'  >0</button></td>";

						if($encuentraD == 1 && ($realD > $idealD)) $str.="<td class='realD' ><button class='btn btn-danger btn-circle btn-sm' title='MP real D'  >".$realD."</button></td>";
						else if($encuentraD == 1 && ($realD <= $idealD)) $str.="<td class='realD' ><button class='btn btn-default btn-circle btn-sm' title='MP real D'  >".$realD."</button></td>";
						else $str.="<td class='realD' ><button class='btn btn-default btn-circle btn-sm' title='MP real D'  >0</button></td>";

						if($encuentraE == 1 && ($realE > $idealE)) $str.="<td class='realE' ><button class='btn btn-danger btn-circle btn-sm' title='MP real E'  >".$realE."</button></td>";
						else if($encuentraE == 1 && ($realE <= $idealE)) $str.="<td class='realE' ><button class='btn btn-default btn-circle btn-sm' title='MP real E'  >".$realE."</button></td>";
						else $str.="<td class='realE' ><button class='btn btn-default btn-circle btn-sm' title='MP real E'  >0</button></td>";

						if($encuentraF == 1 && ($realF > $idealF)) $str.="<td class='realF' ><button class='btn btn-danger btn-circle btn-sm' title='MP real F'  >".$realF."</button></td>";
						else if($encuentraF == 1 && ($realF <= $idealF)) $str.="<td class='realF' ><button class='btn btn-default btn-circle btn-sm' title='MP real F'  >".$realF."</button></td>";
						else $str.="<td class='realF' ><button class='btn btn-default btn-circle btn-sm' title='MP real F'  >0</button></td>";

						
						$realTotalTimeMp = $realA + $realB + $realC + $realD + $realE + $realF;
					}	
					
					if($realA > 0)
					{
						$idealTotalTimeMp = $idealTotalTimeMp + $idealA;
					}
					if($realB > 0)
					{
						$idealTotalTimeMp = $idealTotalTimeMp + $idealB;
					}
					if($realC > 0)
					{
						$idealTotalTimeMp = $idealTotalTimeMp + $idealC;
					}
					if($realD > 0)
					{
						$idealTotalTimeMp = $idealTotalTimeMp + $idealD;
					}
					if($realE > 0)
					{
						$idealTotalTimeMp = $idealTotalTimeMp + $idealE;
					}
					if($realF > 0)
					{
						$idealTotalTimeMp = $idealTotalTimeMp + $idealF;
					}
					
					$str.="<td class='idealTotalTimeMp hidden' >
						<button type='button' class='btn btn-success btn-circle btn-sm' title='Ideal Total Time Mp'  >".$idealTotalTimeMp."</button>
					</td>";

					if($realTotalTimeMp == 0)
					{
						$str.="<td class='realTotalTimeMp'>
						<button type='button' class='btn btn-default btn-circle btn-sm' title='Real Total Time Mp'  >".$realTotalTimeMp."</button>
						</td>";
					}
					else
					{
						$str.="<td class='realTotalTimeMp'>
						<button type='button' class='btn btn-warning btn-circle btn-sm' title='Real Total Time Mp'  >".$realTotalTimeMp."</button>
						</td>";
					}
					

					$extraTimeMp = 0;
					if($realTotalTimeMp > $idealTotalTimeMp)
					{
						$extraTimeMp = $realTotalTimeMp - $idealTotalTimeMp;
						
						$str.="<td class='extraTimeMp hidden'>
						<button type='button' class='btn btn-info btn-circle btn-sm' title='Extra Time Mp'  >".$extraTimeMp."</button>
						</td>";
					}
					else
					{
						$str.="<td class='extraTimeMp hidden'>
						<button type='button' class='btn btn-info btn-circle btn-sm' title='Extra Time Mp'  >".$extraTimeMp."</button>
						</td>";
					}

					//echo $extraTimeMp;

					// FAILS FOR EXTRA TIME MP
					$failsForExtraTimeMp = 0;
					if ($realA > $idealA) 
					{
						$failsForExtraTimeMp ++;
					}
					if ($realB > $idealB) 
					{
						$failsForExtraTimeMp ++;
					}
					if ($realC > $idealC) 
					{
						$failsForExtraTimeMp ++;
					}
					if ($realD > $idealD) 
					{
						$failsForExtraTimeMp ++;
					}
					if ($realE > $idealE) 
					{
						$failsForExtraTimeMp ++;
					}
					if ($realF > $idealF) 
					{
						$failsForExtraTimeMp ++;
					}

					$str.="<td class='failsForExtraTimeMp hidden' >
						<button type='button' class='btn btn-danger btn-circle btn-sm' title='Fails For Extra Time Mp'  >".$failsForExtraTimeMp."</button>
					</td>";

					//MTTR EXTRA TIME MP
					$mttrExtraTimeMp = 0;
					if($failsForExtraTimeMp > 0)
					{
						$mttrExtraTimeMp = round($extraTimeMp / $failsForExtraTimeMp, 1);
					}
					$str.="<td class='mttrExtraTimeMp hidden'>
						<button type='button' class='btn btn-primary btn-circle btn-sm' title='Mttr Extra Time Mp'  >".$mttrExtraTimeMp."</button>
					</td>";

					
					//TIME TO REPAIR CORRECTIVO
					$timeToRepair = 0;
					$ordenesmc = Ordenesots::getAllMpByMesAnoEquipoCorrectivo($mes, $ano, $equipo->nombre_equipo);
					$cuentaFails = 0; // pasa despues saber cuantas fallas hubo de este equipo
					//print_r($ordenesmc);
					//die("s");
					if(empty($ordenesmc))
					{
						$str.="<td class='timeToRepair'>
							<button type='button' class='btn btn-default btn-circle btn-sm' title='Time To Repair'  >0</button>
						</td>";
					}
					else
					{
						foreach ($ordenesmc as $mc) 
						{
							$fechaHoy = null;
							$fechaHoy = date("Y-m-d H:i:s");

							if($mc->fecha_inicio_programada <= $fechaHoy)
							{
								if($mc->fecha_inicio == "")
								{
									
									$timeToRepair = $timeToRepair + getMinutes($mc->fecha_inicio_programada, $fechaHoy);
									$cuentaFails ++;	

									
								}
								else if($mc->fecha_finalizacion == "" && $mc->fecha_inicio != "") // para cuando no existe aún la fecha de finalización
								{
									
									$timeToRepair = $timeToRepair + getMinutes($mc->fecha_inicio, $fechaHoy);
									$cuentaFails ++;						
								}
								else
								{
									
									$timeToRepair = $timeToRepair + getMinutes($mc->fecha_inicio, $mc->fecha_finalizacion);
									$cuentaFails ++;
									
								}
								
							}


							
						}

						$str.="<td class='timeToRepair'>
							<button type='button' class='btn btn-default btn-circle btn-sm' title='Time To Repair'  >".$timeToRepair."</button>
						</td>";
					}

					//TOTAL TIME TO REPAIR
					$totalTimeToRepair = 0;
					$totalTimeToRepair = round($timeToRepair + $mttrExtraTimeMp, 1);

					$str.="<td class='totalTimeToRepair hidden'>
							<button type='button' class='btn btn-success btn-circle btn-sm' title='Total Time To Repair'  >".$totalTimeToRepair."</button>
					</td>";

					//REAL-TIME OPERATION
					$realTimeOperation = 0;
					$totalOperacionSemanal = Activos_equipos::getAllTiempoBaseEquipo($equipo->nombre_equipo);
					if(count($totalOperacionSemanal) > 0)
					{
					 	// $totalOperacionSemanal = $totalOperacionSemanal->tiempoBaseOperacion;	
						$realTimeOperation = round( (( ($totalOperacionSemanal->tiempoBaseOperacion * $weeks )/ 60) ) - $totalTimeToRepair, 1);
					}

					$str.="<td class='realTimeOperation hidden'>
						<button type='button' class='btn btn-warning btn-circle btn-sm' title='Real Time Operation'  >".$realTimeOperation."</button>
					</td>";

					//FAILS CORRECTIVAS
					$fails = null;
					$fails = $cuentaFails;
					$str.="<td class='fails hidden'>
						<button type='button' class='btn btn-danger btn-circle btn-sm' title='Fails Corrective'  >".$fails."</button>
					</td>";

					//TOTAL FAILS CORRECTIVAS
					$totalFails = 0;
					$totalFails = $failsForExtraTimeMp + $fails;
					if($totalFails == 0)
					{
						$str.="<td class='totalFails'>
								<button type='button' class='btn btn-default btn-circle btn-sm' title='Total Fails'  >".$totalFails."</button>
							</td>";
					}
					else
					{
						$str.="<td class='totalFails'>
								<button type='button' class='btn btn-danger btn-circle btn-sm' title='Total Fails'  >".$totalFails."</button>
							</td>";

					}
					
					//MIDDLE TIME TO REPAIR
					$middleTimeToRepair = 0;

					if($totalFails != 0 ) // para la division entre 0
					{
						$middleTimeToRepair = round($totalTimeToRepair / $totalFails, 2);
					}
					
					$str.="<td class='middleTimeToRepair'>
						<button type='button' class='btn btn-primary btn-circle btn-sm' title='Middle Time To Repair'  >".$middleTimeToRepair."</button>
					</td>";

					//MIDDLE TIME BEFORE FAILURE
					$middleTimeBeforeFailure = 0;
					if($totalFails != 0)
					{
						$middleTimeBeforeFailure = round( ($realTimeOperation - $idealTotalTimeMp) / $totalFails, 1);
					}
					$str.="<td class='middleTimeBeforeFailure'>
						<button type='button' class='btn btn-primary btn-circle btn-sm' title='Middle Time Before Failure'  >".$middleTimeBeforeFailure."</button>
					</td>";

					$disponibility = 0;
					//echo $middleTimeToRepair." # ".$middleTimeBeforeFailure."<br>";

					if( ( ($middleTimeToRepair) + ($middleTimeBeforeFailure) ) != 0 )
					{
						$disponibility = $middleTimeBeforeFailure / ( ($middleTimeToRepair) + ($middleTimeBeforeFailure) );

						if($disponibility > 1)
						{
							$disponibility = $disponibility / 100;
						}
						$disponibility = round($disponibility * 100, 2);
					}
					else
					{
						$disponibility = round(1 * 100, 2); // para los porcentajes de disponibility redondeando
					}

					// ------------- para cuando es negativo 
						if($disponibility < 0)
						{
							$disponibility = 0;
						}
					// --------------
					//echo $disponibility."<br>";
					if($disponibility == 100 || $disponibility >= 90)
					{
						$str.="<td class='disponibility'>
									<div class='progress'>
									  <div class='porcentaje progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='$disponibility' aria-valuemin='0' aria-valuemax='100' style='width: $disponibility%;' data-valor='$disponibility' >$disponibility%
									  </div>
									</div>
								</td>";
					}
					elseif ($disponibility  < 90 && $disponibility >= 50 ) 
					{
						$str.="<td class='disponibility'>
									<div class='progress'>
									  <div class='porcentaje progress-bar progress-bar-warning progress-bar-striped' role='progressbar' aria-valuenow='$disponibility' aria-valuemin='0' aria-valuemax='100' style='width: $disponibility%' data-valor='$disponibility'>$disponibility%
									  </div>
									</div>
								</td>";
					}

					elseif ($disponibility < 50 ) 
					{
						$str.="<td class='disponibility'>
									<div class='progress'>
									  <div class='porcentaje progress-bar progress-bar-danger progress-bar-striped' role='progressbar' aria-valuenow='$disponibility' aria-valuemin='0' aria-valuemax='100' style='width: $disponibility%' data-valor='$disponibility'>$disponibility%
									  </div>
									</div>
								</td>";
					}
					
					

					$str.="<td>
									<button title='Ver mantenimientos' class='detalles_equipo$nombreMes ".$equipo->nombre_equipo." btn btn-info btn-sm btn-circle' parametroDetalle$nombreMes='".$equipo->nombre_equipo."'
										parametroEquipoMes$nombreMes='".$mes."'
										parametroEquipoAno$nombreMes='".$ano."'>
										<i class='fa fa-eye' aria-hidden='true' ></i> 
									</button>
								</td>";
					
					

				$str.="</tr>";
				$i++;
			}
		$str.="</tbody>
			</table>";


	}
	if($param == "EQUIPO")
	{
		
	
		$equipo = $_GET['equipo'];
		$detallesEquipos = Ordenesots::getAllByMesAnoEquipo($mes, $ano, $equipo);
		//print_r($detallesEquipos);

		$str.="<br>
				<h4> <i class='fa fa-wrench' aria-hidden='true'></i> EQUIPO: ".$equipo."</h4>
				<table class='table table-bordered table-condensed dataTables_wrapper jambo_table bulk_action' style='font-size: 10px;'>
					<thead >
					<tr>
						<th>OT</th>
						<th>DESCRIPCION</th>
						<th>TIPO</th>
						<th>ESTADO</th>
						<th>CLASE</th>
						<th>DEPARTAMENTO</th>
						<th>F. INICIO PROGRAMADA</th>
						<th>F. INICIO (TEC)</th>
						<th>F. FIN (TEC)</th>
					</tr>
					</thead>
					</tbody>";
					foreach ($detallesEquipos as $detalleEquipo)
					{
						$str.="<tr>";
							$str.="<td>".$detalleEquipo->orden_trabajo."</td>";
							$str.="<td>".$detalleEquipo->descripcion."</td>";
							$str.="<td>".$detalleEquipo->tipo."</td>";
							$str.="<td>".$detalleEquipo->estado."</td>";
							$str.="<td>".$detalleEquipo->clase."</td>";
							$str.="<td>".$detalleEquipo->departamento."</td>";
							$str.="<td>".$detalleEquipo->fecha_inicio_programada."</td>";
							$str.="<td>".$detalleEquipo->fecha_inicio."</td>";
							$str.="<td>".$detalleEquipo->fecha_finalizacion."</td>";
						$str.="</tr>";
					}
		$str.="</tbody>
		</table>";
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
    <!--script src="<?php echo $url; ?>dist/js/loader.js"></script>
    <script src="<?php echo $url; ?>dist/js/jsapi.js"></script-->

<script type="text/javascript">
	$(".detalles_equipoENERO").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "ENERO";
    	var equipo = null;
    	var mesesito = null;
    	var anito = null;
    	var param = null;
    		equipo = $(this).attr("parametroDetalle"+nombreMes);

    		
    		//alert(equipo);
    		
    		//fam = $(this).attr("parametroDetalle");
    		mesesito = $(this).attr("parametroEquipoMes"+nombreMes);
    		anito = $(this).attr("parametroEquipoAno"+nombreMes);
    		param = "EQUIPO";

    		$(".recibeEquipo"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
    		$.get("helperDisponibilidadParametros.php", {param:param, mes:mesesito, ano:anito, equipo:equipo, nombreMes:nombreMes} ,function(data)
	        {
	        	$(".recibeFamilia"+nombreMes).addClass("hidden");
	        	$(".regresarFamilia"+nombreMes).addClass("hidden");

	        	$(".recibeEquipo"+nombreMes).html(data);
	        	$(".recibeEquipo"+nombreMes).removeClass("hidden");
	        	$(".regresarEquipo"+nombreMes).removeClass("hidden");

	        });
    });

    $(".regresarEquipoENERO").on("click", function(event)
	{
		event.preventDefault();
    	nombreMes = "ENERO";

    	//$(".recibeEquipo").addClass("hidden");
    	$(".recibeEquipo"+nombreMes).addClass("hidden");
    	$(".regresarEquipo"+nombreMes).addClass("hidden");

    	$(".recibeFamilia"+nombreMes).removeClass("hidden");
    	$(".regresarFamilia"+nombreMes).removeClass("hidden");
    });

    // FEBRERO

    $(".detalles_equipoFEBRERO").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "FEBRERO";
    	var equipo = null;
    	var mesesito = null;
    	var anito = null;
    	var param = null;
    		equipo = $(this).attr("parametroDetalle"+nombreMes);

    		
    		//alert(equipo);
    		
    		//fam = $(this).attr("parametroDetalle");
    		mesesito = $(this).attr("parametroEquipoMes"+nombreMes);
    		anito = $(this).attr("parametroEquipoAno"+nombreMes);
    		param = "EQUIPO";

    		$(".recibeEquipo"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
    		$.get("helperDisponibilidadParametros.php", {param:param, mes:mesesito, ano:anito, equipo:equipo, nombreMes:nombreMes} ,function(data)
	        {
	        	$(".recibeFamilia"+nombreMes).addClass("hidden");
	        	$(".regresarFamilia"+nombreMes).addClass("hidden");

	        	$(".recibeEquipo"+nombreMes).html(data);
	        	$(".recibeEquipo"+nombreMes).removeClass("hidden");
	        	$(".regresarEquipo"+nombreMes).removeClass("hidden");

	        });
    });

    $(".regresarEquipoFEBRERO").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "FEBRERO";
    	

    	//$(".recibeEquipo").addClass("hidden");
    	$(".recibeEquipo"+nombreMes).addClass("hidden");
    	$(".regresarEquipo"+nombreMes).addClass("hidden");

    	$(".recibeFamilia"+nombreMes).removeClass("hidden");
    	$(".regresarFamilia"+nombreMes).removeClass("hidden");
    });

    // MARZO

    $(".detalles_equipoMARZO").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "MARZO";
    	var equipo = null;
    	var mesesito = null;
    	var anito = null;
    	var param = null;
    		equipo = $(this).attr("parametroDetalle"+nombreMes);

    		
    		//alert(equipo);
    		
    		//fam = $(this).attr("parametroDetalle");
    		mesesito = $(this).attr("parametroEquipoMes"+nombreMes);
    		anito = $(this).attr("parametroEquipoAno"+nombreMes);
    		param = "EQUIPO";

    		$(".recibeEquipo"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
    		$.get("helperDisponibilidadParametros.php", {param:param, mes:mesesito, ano:anito, equipo:equipo, nombreMes:nombreMes} ,function(data)
	        {
	        	$(".recibeFamilia"+nombreMes).addClass("hidden");
	        	$(".regresarFamilia"+nombreMes).addClass("hidden");

	        	$(".recibeEquipo"+nombreMes).html(data);
	        	$(".recibeEquipo"+nombreMes).removeClass("hidden");
	        	$(".regresarEquipo"+nombreMes).removeClass("hidden");

	        });
    });

    $(".regresarEquipoMARZO").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "MARZO";
    	

    	//$(".recibeEquipo").addClass("hidden");
    	$(".recibeEquipo"+nombreMes).addClass("hidden");
    	$(".regresarEquipo"+nombreMes).addClass("hidden");

    	$(".recibeFamilia"+nombreMes).removeClass("hidden");
    	$(".regresarFamilia"+nombreMes).removeClass("hidden");
    });

    // ABRIL
    $(".detalles_equipoABRIL").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "ABRIL";
    	var equipo = null;
    	var mesesito = null;
    	var anito = null;
    	var param = null;
    		equipo = $(this).attr("parametroDetalle"+nombreMes);

    		
    		//alert(equipo);
    		
    		//fam = $(this).attr("parametroDetalle");
    		mesesito = $(this).attr("parametroEquipoMes"+nombreMes);
    		anito = $(this).attr("parametroEquipoAno"+nombreMes);
    		param = "EQUIPO";

    		$(".recibeEquipo"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
    		$.get("helperDisponibilidadParametros.php", {param:param, mes:mesesito, ano:anito, equipo:equipo, nombreMes:nombreMes} ,function(data)
	        {
	        	$(".recibeFamilia"+nombreMes).addClass("hidden");
	        	$(".regresarFamilia"+nombreMes).addClass("hidden");

	        	$(".recibeEquipo"+nombreMes).html(data);
	        	$(".recibeEquipo"+nombreMes).removeClass("hidden");
	        	$(".regresarEquipo"+nombreMes).removeClass("hidden");

	        });
    });

    $(".regresarEquipoABRIL").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "ABRIL";
    	

    	//$(".recibeEquipo").addClass("hidden");
    	$(".recibeEquipo"+nombreMes).addClass("hidden");
    	$(".regresarEquipo"+nombreMes).addClass("hidden");

    	$(".recibeFamilia"+nombreMes).removeClass("hidden");
    	$(".regresarFamilia"+nombreMes).removeClass("hidden");
    });

    // MAYO
    $(".detalles_equipoMAYO").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "MAYO";
    	var equipo = null;
    	var mesesito = null;
    	var anito = null;
    	var param = null;
    		equipo = $(this).attr("parametroDetalle"+nombreMes);

    		
    		//alert(equipo);
    		
    		//fam = $(this).attr("parametroDetalle");
    		mesesito = $(this).attr("parametroEquipoMes"+nombreMes);
    		anito = $(this).attr("parametroEquipoAno"+nombreMes);
    		param = "EQUIPO";

    		$(".recibeEquipo"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
    		$.get("helperDisponibilidadParametros.php", {param:param, mes:mesesito, ano:anito, equipo:equipo, nombreMes:nombreMes} ,function(data)
	        {
	        	$(".recibeFamilia"+nombreMes).addClass("hidden");
	        	$(".regresarFamilia"+nombreMes).addClass("hidden");

	        	$(".recibeEquipo"+nombreMes).html(data);
	        	$(".recibeEquipo"+nombreMes).removeClass("hidden");
	        	$(".regresarEquipo"+nombreMes).removeClass("hidden");

	        });
    });

    $(".regresarEquipoMAYO").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "MAYO";
    	

    	//$(".recibeEquipo").addClass("hidden");
    	$(".recibeEquipo"+nombreMes).addClass("hidden");
    	$(".regresarEquipo"+nombreMes).addClass("hidden");

    	$(".recibeFamilia"+nombreMes).removeClass("hidden");
    	$(".regresarFamilia"+nombreMes).removeClass("hidden");
    });

    // JUNIO
    $(".detalles_equipoJUNIO").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "JUNIO";
    	var equipo = null;
    	var mesesito = null;
    	var anito = null;
    	var param = null;
    		equipo = $(this).attr("parametroDetalle"+nombreMes);

    		
    		//alert(equipo);
    		
    		//fam = $(this).attr("parametroDetalle");
    		mesesito = $(this).attr("parametroEquipoMes"+nombreMes);
    		anito = $(this).attr("parametroEquipoAno"+nombreMes);
    		param = "EQUIPO";

    		$(".recibeEquipo"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
    		$.get("helperDisponibilidadParametros.php", {param:param, mes:mesesito, ano:anito, equipo:equipo, nombreMes:nombreMes} ,function(data)
	        {
	        	$(".recibeFamilia"+nombreMes).addClass("hidden");
	        	$(".regresarFamilia"+nombreMes).addClass("hidden");

	        	$(".recibeEquipo"+nombreMes).html(data);
	        	$(".recibeEquipo"+nombreMes).removeClass("hidden");
	        	$(".regresarEquipo"+nombreMes).removeClass("hidden");

	        });
    });

    $(".regresarEquipoJUNIO").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "JUNIO";
    	

    	//$(".recibeEquipo").addClass("hidden");
    	$(".recibeEquipo"+nombreMes).addClass("hidden");
    	$(".regresarEquipo"+nombreMes).addClass("hidden");

    	$(".recibeFamilia"+nombreMes).removeClass("hidden");
    	$(".regresarFamilia"+nombreMes).removeClass("hidden");
    });

    // JULIO
    $(".detalles_equipoJULIO").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "JULIO";
    	var equipo = null;
    	var mesesito = null;
    	var anito = null;
    	var param = null;
    		equipo = $(this).attr("parametroDetalle"+nombreMes);

    		
    		//alert(equipo);
    		
    		//fam = $(this).attr("parametroDetalle");
    		mesesito = $(this).attr("parametroEquipoMes"+nombreMes);
    		anito = $(this).attr("parametroEquipoAno"+nombreMes);
    		param = "EQUIPO";

    		$(".recibeEquipo"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
    		$.get("helperDisponibilidadParametros.php", {param:param, mes:mesesito, ano:anito, equipo:equipo, nombreMes:nombreMes} ,function(data)
	        {
	        	$(".recibeFamilia"+nombreMes).addClass("hidden");
	        	$(".regresarFamilia"+nombreMes).addClass("hidden");

	        	$(".recibeEquipo"+nombreMes).html(data);
	        	$(".recibeEquipo"+nombreMes).removeClass("hidden");
	        	$(".regresarEquipo"+nombreMes).removeClass("hidden");

	        });
    });

    $(".regresarEquipoJULIO").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "JULIO";
    	

    	//$(".recibeEquipo").addClass("hidden");
    	$(".recibeEquipo"+nombreMes).addClass("hidden");
    	$(".regresarEquipo"+nombreMes).addClass("hidden");

    	$(".recibeFamilia"+nombreMes).removeClass("hidden");
    	$(".regresarFamilia"+nombreMes).removeClass("hidden");
    });

    // AGOSTO
    $(".detalles_equipoAGOSTO").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "AGOSTO";
    	var equipo = null;
    	var mesesito = null;
    	var anito = null;
    	var param = null;
    		equipo = $(this).attr("parametroDetalle"+nombreMes);

    		
    		//alert(equipo);
    		
    		//fam = $(this).attr("parametroDetalle");
    		mesesito = $(this).attr("parametroEquipoMes"+nombreMes);
    		anito = $(this).attr("parametroEquipoAno"+nombreMes);
    		param = "EQUIPO";

    		$(".recibeEquipo"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
    		$.get("helperDisponibilidadParametros.php", {param:param, mes:mesesito, ano:anito, equipo:equipo, nombreMes:nombreMes} ,function(data)
	        {
	        	$(".recibeFamilia"+nombreMes).addClass("hidden");
	        	$(".regresarFamilia"+nombreMes).addClass("hidden");

	        	$(".recibeEquipo"+nombreMes).html(data);
	        	$(".recibeEquipo"+nombreMes).removeClass("hidden");
	        	$(".regresarEquipo"+nombreMes).removeClass("hidden");

	        });
    });

    $(".regresarEquipoAGOSTO").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "AGOSTO";
    	

    	//$(".recibeEquipo").addClass("hidden");
    	$(".recibeEquipo"+nombreMes).addClass("hidden");
    	$(".regresarEquipo"+nombreMes).addClass("hidden");

    	$(".recibeFamilia"+nombreMes).removeClass("hidden");
    	$(".regresarFamilia"+nombreMes).removeClass("hidden");
    });

    // SEPTIEMBRE
    $(".detalles_equipoSEPTIEMBRE").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "SEPTIEMBRE";
    	var equipo = null;
    	var mesesito = null;
    	var anito = null;
    	var param = null;
    		equipo = $(this).attr("parametroDetalle"+nombreMes);

    		
    		//alert(equipo);
    		
    		//fam = $(this).attr("parametroDetalle");
    		mesesito = $(this).attr("parametroEquipoMes"+nombreMes);
    		anito = $(this).attr("parametroEquipoAno"+nombreMes);
    		param = "EQUIPO";

    		$(".recibeEquipo"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
    		$.get("helperDisponibilidadParametros.php", {param:param, mes:mesesito, ano:anito, equipo:equipo, nombreMes:nombreMes} ,function(data)
	        {
	        	$(".recibeFamilia"+nombreMes).addClass("hidden");
	        	$(".regresarFamilia"+nombreMes).addClass("hidden");

	        	$(".recibeEquipo"+nombreMes).html(data);
	        	$(".recibeEquipo"+nombreMes).removeClass("hidden");
	        	$(".regresarEquipo"+nombreMes).removeClass("hidden");

	        });
    });

    $(".regresarEquipoSEPTIEMBRE").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "SEPTIEMBRE";
    	

    	//$(".recibeEquipo").addClass("hidden");
    	$(".recibeEquipo"+nombreMes).addClass("hidden");
    	$(".regresarEquipo"+nombreMes).addClass("hidden");

    	$(".recibeFamilia"+nombreMes).removeClass("hidden");
    	$(".regresarFamilia"+nombreMes).removeClass("hidden");
    });

    // OCTUBRE

    $(".detalles_equipoOCTUBRE").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "OCTUBRE";
    	var equipo = null;
    	var mesesito = null;
    	var anito = null;
    	var param = null;
    		equipo = $(this).attr("parametroDetalle"+nombreMes);

    		
    		//alert(equipo);
    		
    		//fam = $(this).attr("parametroDetalle");
    		mesesito = $(this).attr("parametroEquipoMes"+nombreMes);
    		anito = $(this).attr("parametroEquipoAno"+nombreMes);
    		param = "EQUIPO";

    		$(".recibeEquipo"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
    		$.get("helperDisponibilidadParametros.php", {param:param, mes:mesesito, ano:anito, equipo:equipo, nombreMes:nombreMes} ,function(data)
	        {
	        	$(".recibeFamilia"+nombreMes).addClass("hidden");
	        	$(".regresarFamilia"+nombreMes).addClass("hidden");

	        	$(".recibeEquipo"+nombreMes).html(data);
	        	$(".recibeEquipo"+nombreMes).removeClass("hidden");
	        	$(".regresarEquipo"+nombreMes).removeClass("hidden");

	        });
    });

    $(".regresarEquipoOCTUBRE").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "OCTUBRE";
    	

    	//$(".recibeEquipo").addClass("hidden");
    	$(".recibeEquipo"+nombreMes).addClass("hidden");
    	$(".regresarEquipo"+nombreMes).addClass("hidden");

    	$(".recibeFamilia"+nombreMes).removeClass("hidden");
    	$(".regresarFamilia"+nombreMes).removeClass("hidden");
    });

    // NOVIEMBRE

    $(".detalles_equipoNOVIEMBRE").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "NOVIEMBRE";
    	var equipo = null;
    	var mesesito = null;
    	var anito = null;
    	var param = null;
    		equipo = $(this).attr("parametroDetalle"+nombreMes);

    		
    		//alert(equipo);
    		
    		//fam = $(this).attr("parametroDetalle");
    		mesesito = $(this).attr("parametroEquipoMes"+nombreMes);
    		anito = $(this).attr("parametroEquipoAno"+nombreMes);
    		param = "EQUIPO";

    		$(".recibeEquipo"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
    		$.get("helperDisponibilidadParametros.php", {param:param, mes:mesesito, ano:anito, equipo:equipo, nombreMes:nombreMes} ,function(data)
	        {
	        	$(".recibeFamilia"+nombreMes).addClass("hidden");
	        	$(".regresarFamilia"+nombreMes).addClass("hidden");

	        	$(".recibeEquipo"+nombreMes).html(data);
	        	$(".recibeEquipo"+nombreMes).removeClass("hidden");
	        	$(".regresarEquipo"+nombreMes).removeClass("hidden");

	        });
    });

    $(".regresarEquipoNOVIEMBRE").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "NOVIEMBRE";
    	

    	//$(".recibeEquipo").addClass("hidden");
    	$(".recibeEquipo"+nombreMes).addClass("hidden");
    	$(".regresarEquipo"+nombreMes).addClass("hidden");

    	$(".recibeFamilia"+nombreMes).removeClass("hidden");
    	$(".regresarFamilia"+nombreMes).removeClass("hidden");
    });

    // DICIEMBRE
    $(".detalles_equipoDICIEMBRE").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "DICIEMBRE";
    	var equipo = null;
    	var mesesito = null;
    	var anito = null;
    	var param = null;
    		equipo = $(this).attr("parametroDetalle"+nombreMes);

    		
    		//alert(equipo);
    		
    		//fam = $(this).attr("parametroDetalle");
    		mesesito = $(this).attr("parametroEquipoMes"+nombreMes);
    		anito = $(this).attr("parametroEquipoAno"+nombreMes);
    		param = "EQUIPO";

    		$(".recibeEquipo"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
    		$.get("helperDisponibilidadParametros.php", {param:param, mes:mesesito, ano:anito, equipo:equipo, nombreMes:nombreMes} ,function(data)
	        {
	        	$(".recibeFamilia"+nombreMes).addClass("hidden");
	        	$(".regresarFamilia"+nombreMes).addClass("hidden");

	        	$(".recibeEquipo"+nombreMes).html(data);
	        	$(".recibeEquipo"+nombreMes).removeClass("hidden");
	        	$(".regresarEquipo"+nombreMes).removeClass("hidden");

	        });
    });

    $(".regresarEquipoDICIEMBRE").on("click", function(event)
	{
		event.preventDefault();
		nombreMes = "DICIEMBRE";
    	

    	//$(".recibeEquipo").addClass("hidden");
    	$(".recibeEquipo"+nombreMes).addClass("hidden");
    	$(".regresarEquipo"+nombreMes).addClass("hidden");

    	$(".recibeFamilia"+nombreMes).removeClass("hidden");
    	$(".regresarFamilia"+nombreMes).removeClass("hidden");
    });

    

</script>



